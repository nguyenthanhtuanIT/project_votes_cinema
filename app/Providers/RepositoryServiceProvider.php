<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap services.
	 *
	 * @return void
	 */
	public function boot() {
		//
	}

	/**
	 * Register services.
	 *
	 * @return void
	 */
	public function register() {
		$this->app->bind(\App\Repositories\Contracts\UserRepository::class, \App\Repositories\Eloquent\UserRepositoryEloquent::class);
		$this->app->bind(\App\Repositories\Contracts\ImageRepository::class, \App\Repositories\Eloquent\ImageRepositoryEloquent::class);
		$this->app->bind(\App\Repositories\Contracts\VoteRepository::class, \App\Repositories\Eloquent\VoteRepositoryEloquent::class);
		$this->app->bind(\App\Repositories\Contracts\CinemaRepository::class, \App\Repositories\Eloquent\CinemaRepositoryEloquent::class);
		$this->app->bind(\App\Repositories\Contracts\FilmsRepository::class, \App\Repositories\Eloquent\FilmsRepositoryEloquent::class);
		$this->app->bind(\App\Repositories\Contracts\RegisterRepository::class, \App\Repositories\Eloquent\RegisterRepositoryEloquent::class);
		$this->app->bind(\App\Repositories\Contracts\ChairRepository::class, \App\Repositories\Eloquent\ChairRepositoryEloquent::class);
		$this->app->bind(\App\Repositories\Contracts\ChooseChairRepository::class, \App\Repositories\Eloquent\ChooseChairRepositoryEloquent::class);
		$this->app->bind(\App\Repositories\Contracts\BlogRepository::class, \App\Repositories\Eloquent\BlogRepositoryEloquent::class);
		$this->app->bind(\App\Repositories\Contracts\VoteDetailsRepository::class, \App\Repositories\Eloquent\VoteDetailsRepositoryEloquent::class);

	}
}
