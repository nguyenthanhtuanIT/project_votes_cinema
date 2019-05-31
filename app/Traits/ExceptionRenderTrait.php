<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait ExceptionRenderTrait
{

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        $data = [
            'status' => $e instanceof HttpException ? $e->getStatusCode() : 500,
            'errors' => [[
                'title' => 'Internal Server Error',
                'detail' => $e->getMessage() ?: ('An exception of ' . get_class_name($e)),
            ]],
        ];

        if ($e instanceof \Illuminate\Auth\Access\AuthorizationException) {
            $data = array_merge($data, [
                'status' => 403,
                'errors' => [[
                    'title' => 'Permission denied.',
                    'detail' => $e->getMessage(),
                ]],
            ]);
        }

        if ($e instanceof \Illuminate\Auth\AuthenticationException) {
            $data = array_merge($data, [
                'status' => 401,
                'errors' => [[
                    'title' => 'Authenticate Error',
                    'detail' => $e->getMessage() ?: 'Unauthenticated',
                ]],
            ]);
        }

        if ($e instanceof \Illuminate\Validation\AuthenticationException) {
            $data = array_merge($data, [
                'status' => 401,
                'errors' => [[
                    'title' => 'Authenticate Error',
                    'detail' => $e->getMessage() ?: 'Unauthenticated',
                ]],
            ]);
        }

        if ($e instanceof ModelNotFoundException) {
            $data = array_merge($data, [
                'status' => 404,
                'errors' => [[
                    'title' => 'Not Found Error',
                    'detail' => 'Not Found Model',
                ]],
            ]);
        }

        if ($e instanceof HttpException) {
            $data = array_merge($data, [
                'status' => $e->getStatusCode(),
                'errors' => [[
                    'title' => 'Not Found Error',
                    'detail' => $e->getMessage() ?: ('An exception of ' . get_class_name($e)),
                ]],
            ]);
        }

        if ($e instanceof \Illuminate\Validation\ValidationException) {
            $data = array_merge($data, [
                'status' => $e->status,
                'title' => 'Validation Error',
            ]);
            $errorResponses = function ($errors) use ($data) {
                foreach ($errors as $key => $error) {
                    if (!is_array($error)) {
                        $errorResponses[] = [
                            'title' => 'Bad Request',
                            'detail' => $error,
                        ];
                    } else {
                        foreach ($error as $detail) {
                            $errorResponses[] = [
                                'title' => $data['title'],
                                'detail' => $detail,
                                'source' => [
                                    'pointer' => $key,
                                ],
                            ];
                        }
                    }
                }

                return $errorResponses;
            };
            $data['errors'] = $errorResponses((array) $e->errors());
        }

        return response()->json($data, $data['status']);
    }
}
