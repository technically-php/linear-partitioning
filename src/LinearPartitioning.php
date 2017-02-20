<?php
namespace TechnicallyPhp;

class LinearPartitioning
{
    public static function partition(array $elements, int $max_ranges): array
    {
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
                        'cost' => max($m[$x][$j - 1], $p[$i] - $p[$x]),
                        'delimiter' => $x,
                    ];
                }

                usort($solutions, function (array $x, array $y) {
                    return $x['cost'] <=> $y['cost'];
                });

                $best_solution = $solutions[0];

                $m[$i][$j] = $best_solution['cost'];
                $d[$i][$j] = $best_solution['delimiter'];
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