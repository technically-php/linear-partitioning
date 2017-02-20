<?php

function cost(array $partition): int
{
    $groups_costs = [];
    foreach ($partition as $group) {
        $groups_costs[] = array_sum($group);
    }
    $cost = max($groups_costs);

    return $cost;
}

function partition(array $items, int $max_groups): array
{
    if ($max_groups === 1) {
        return [$items];
    }

    if ($max_groups >= count($items)) {
        return array_map(function($item) {
            return [$item];
        }, $items);
    }

    $solutions = [];
    foreach (range(1, count($items) - 1) as $i) {
        $solution = array_merge(
            partition(array_slice($items, 0, $i), $max_groups - 1),
            [ array_slice($items, $i, count($items) - $i) ]
        );
        $cost = cost($solution);
        $solutions[$cost] = $solution;
    }

    ksort($solutions, SORT_NUMERIC);

    $best_cost = array_keys($solutions)[0];
    $best_solution = array_values($solutions)[0];

    return $best_solution;
}
