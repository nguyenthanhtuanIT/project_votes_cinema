<?php

namespace App\Models;

/**
 * Class Seat.
 *
 * @package namespace App\Models;
 */
class Seat extends BaseModel
{
    /**
     * Set viewers to seats randomly
     * @param: $seats, $viewers - format: [[x1, x2, x3], [y1, y2, ...], ...]
     * @return: array with status and data
     * @author: AuTN
     */
    public function shuffle_seats($seats = [], $viewers = []) {
        $seats = array_values($seats);
        $viewers = array_values($viewers);
        // seats or viewers list is empty
        if (empty($seats) || empty($viewers)) {
            return [
                'status' => 'success',
                'data' => [],
            ];
        }
        // validate inputs
        $original_seats = $original_viewers = [];
        foreach ($seats as $key => $seats_group) {
            if (!is_array($seats_group)) {
                return [
                    'status' => 'failed',
                    'data' => 'The data is invalid (seats)',
                ];
            } elseif (!empty($seats_group)) {
                $original_seats = array_merge($original_seats, $seats_group);
            } else {
                unset($seats[$key]);
            }
        }
        foreach ($viewers as $key => $viewers_group) {
            if (!is_array($viewers_group)) {
                return [
                    'status' => 'failed',
                    'data' => 'The data is invalid (viewers)',
                ];
            } elseif (!empty($viewers_group)) {
                $original_viewers = array_merge($original_viewers, $viewers_group);
            } else {
                unset($viewers[$key]);
            }
        }
        // number of viewers must smaller than number of seats
        if (count($original_viewers) > count($original_seats)) {
            return [
                'status' => 'failed',
                'data' => 'Not enoght seats',
            ];
        }

        // prepare data: sort viewers and shuffle seats...
        shuffle($viewers);
        usort($viewers, function ($a, $b) {
            if (count($a) < count($b)) { return 1; }
            if (count($a) > count($b)) { return -1; }
            return 0;
        });
        shuffle($seats);
        // count the items of each group
        $seats_count = [];
        foreach ($seats as $key => $group) {
            $seats_count[$key] = count($group);
        }
        // set positions to viewers
        $positions = $this->array_2_slots($viewers, $seats_count);

        // set viewer to seat randomly
        $viewer_to_seat = [];
        foreach ($seats as $group_key => $seat_group) {
            if (!empty($positions[$group_key])) {
                shuffle($positions[$group_key]);
                $list = call_user_func_array('array_merge', $positions[$group_key]);
                foreach ($seat_group as $seat_key => $seat) {
                    $viewer_to_seat[$seat] = $list[$seat_key] ?? '';
                }
            }
        }
        // back to original order of seats
        $results = [];
        foreach ($original_seats as $key => $seat) {
            $results[$seat] = $viewer_to_seat[$seat] ?? '';
        }

        return [
            'status' => 'success',
            'data' => $results,
        ];
    }

    /**
     * Set array to slots
     * @param: $array1, $slots, $positions
     * @return: list with format 'key' (from $array2) => 'value' (from $array1)
     * @author: AuTN
     */
    private function array_2_slots($array1 = [], &$slots = [], &$positions = []) {
        foreach ($array1 as $array1_group_key => $array1_group) {
            $i = 0;
            $max_available_slots_of_array2 = [0];
            foreach ($slots as $slots_group_key => $slots_group_value) {
                if ($slots_group_value > array_values($max_available_slots_of_array2)[0]) {
                    $max_available_slots_of_array2 = [
                        $slots_group_key => $slots_group_value
                    ];
                }
                if (count($array1_group) <= $slots_group_value) {
                    // set to list
                    $positions[$slots_group_key][] = $array1_group;
                    $slots[$slots_group_key] = $slots_group_value - count($array1_group);
                    break;
                } elseif (++$i == count($slots)) {
                    // if not enoght slots, break to 2 lists
                    reset($max_available_slots_of_array2);
                    $max_slots_key = key($max_available_slots_of_array2);
                    $part1 = array_slice($array1_group, 0, $slots[$max_slots_key]);
                    $part2 = array_slice($array1_group, $slots[$max_slots_key]);
                    $positions[$max_slots_key][] = $part1;
                    $slots[$max_slots_key] = 0;
                    $this->array_2_slots([$part2], $slots, $positions);
                }
            }
        }

        return $positions;
    }
}
