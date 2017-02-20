<?php
namespace TechnicallyPhp\LinearParitioning\Test;

use PHPUnit\Framework\TestCase;
use TechnicallyPhp\LinearPartitioning;

class LinearPartitioningTest extends TestCase
{
    /**
     * @test
     * @dataProvider partitioning_test_cases
     *
     * @param array $elements
     * @param int $ranges
     * @param array $expected
     */
    public function it_should_partition_elements_into_ranges(array $elements, int $ranges, array $expected)
    {
        $actual = LinearPartitioning::partition($elements, $ranges);
        $this->assertEquals($expected, $actual);
    }

    public function partitioning_test_cases()
    {
        return [
            [
                'elements' => [1,2,3,4,5,6,7,8,9],
                'ranges' => 3,
                'expected' => [[1,2,3,4,5], [6,7], [8,9]],
            ],
            [
                'elements' => [1,1,1,1,1,1,1,1,1],
                'ranges' => 3,
                'expected' => [[1,1,1], [1,1,1], [1,1,1]],
            ],
            [
                'elements' => [1,1,1,1,1,1,1,1,1],
                'ranges' => 1,
                'expected' => [[1,1,1,1,1,1,1,1,1]],
            ],
        ];
    }
}
