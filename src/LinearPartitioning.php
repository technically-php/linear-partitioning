<?php
namespace TechnicallyPhp\LinearPartitioning;

class LinearPartitioning
{
    const COST = 0;
    const DELIMITER = 1;

    public static function partition(array $elements, int $max_ranges): array
    {
        // 0) Validate input
        if ($max_ranges < 0) {
            throw new \InvalidArgumentException("\$max_ranges should be a non-negative integer. {$max_ranges} given.");
        }

        foreach ($elements as $i => $element) {
            if ( ! is_int($element) && ! is_float($element)) {
                $type = is_object($element) ? get_class($element) : gettype($element);
                throw new \InvalidArgumentException("\$elements should be an array of positive numbers. Element #$i is of type $type.");
            }
            if ($element <= 0) {
                throw new \InvalidArgumentException("\$elements should be an array of positive numbers. Element #$i is $element.");
            }
        }

        // An array S of non-negative numbers {s1, ... ,sn}
        $s = array_merge([null], array_values($elements)); // adapt indices here: [0..n-1] => [1..n]

        // Integer K - number of ranges to split items into
        $k = $max_ranges;

        $n = count($elements);

        // Let M[n,k] be the minimum possible cost over all partitionings of N elements to K ranges
        $m = [];

        // Let D[n,k] be the position of K-th divider
        // which produces the minimum possible cost partitioning of N elements to K ranges
        $d = [];

        // Note: For code simplicity we don't use zero indices for `m` and `d`
        //       to make code match math formulas

        // Let pi be the sum of first i elements (cost calculation optimization)
        $p = [];

        // 1) Init prefix sums array
        //    pi = sum of {s1, ..., si}
        $p[0] = 0;
        for ($i = 1; $i <= $n; $i++) {
            $p[$i] = $p[$i - 1] + $s[$i];
        }

        // 2) Init boundaries
        for ($i = 1; $i <= $n; $i++) {
            // The only possible partitioning of i elements to 1 range is a single all-elements range
            // The cost of that partitioning is the sum of those i elements
            $m[$i][1] = $p[$i]; // sum of {s1, ..., si} -- optimized using pi
        }
        for ($j = 1; $j <= $k; $j++) {
            // The only possible partitioning of 1 element into j ranges is a single one-element range
            // The cost of that partitioning is the value of first element
            $m[1][$j] = $s[1];
        }

        // 3) Main recurrence (fill the rest of values in table M)
        for ($i = 2; $i <= $n; $i++) {
            for ($j = 2; $j <= $k; $j++) {
                $solutions = [];
                for ($x = 1; $x <= ($i - 1); $x++) {
                    $solutions[] = [
                        self::COST      => max($m[$x][$j - 1], $p[$i] - $p[$x]),
                        self::DELIMITER => $x,
                    ];
                }

                usort($solutions, function (array $x, array $y) {
                    return $x[self::COST] <=> $y[self::COST];
                });

                $best_solution = $solutions[0];

                $m[$i][$j] = $best_solution[self::COST];
                $d[$i][$j] = $best_solution[self::DELIMITER];
            }
        }

        // 4) Reconstruct partitioning
        $i = $n;
        $j = $k;
        $partition = [];
        while ($j > 0) {
            // delimiter position
            $dp = $d[$i][$j] ?? 0;

            // Add elements after delimiter {sdp, ..., si} to resulting $partition.
            $partition[] = array_slice($s, $dp + 1, $i - $dp);

            // Step forward: look for delimiter position for partitioning M[$dp, $j-1]
            $i = $dp;
            $j = $j - 1;
        }

        // Fix order as we reconstructed the partitioning from end to start
        return array_reverse($partition);
    }
}
