<?php
namespace TechnicallyPhp\LinearParitioning\Test;

use PHPUnit\Framework\TestCase;
use TechnicallyPhp\LinearPartitioning\LinearPartitioning;

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

    /**
     * @test
     */
    public function it_should_support_floating_point_elements() // why not? :)
    {
        $elements = [0.1, 0.2, 0.3, 0.4, 0.5, 0.6, 0.7, 0.8, 0.9];
        $expected = [[0.1, 0.2, 0.3, 0.4, 0.5], [0.6, 0.7], [0.8, 0.9]];

        $actual = LinearPartitioning::partition($elements, 3);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     * @dataProvider invalid_input_values
     * @param array $elements
     */
    public function it_should_throw_invalid_argument_exception_on_invalid_input(array $elements)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageRegExp('/ .* \b Element\ \#4 \b .* /ix');
        LinearPartitioning::partition($elements, 10);
    }

    public function partitioning_test_cases(): array
    {
        return [
            [
                'elements' => [1, 2, 3, 4, 5, 6, 7, 8, 9],
                'ranges'   => 3,
                'expected' => [[1, 2, 3, 4, 5], [6, 7], [8, 9]],
            ],
            [
                'elements' => [1, 1, 1, 1, 1, 1, 1, 1, 1],
                'ranges'   => 3,
                'expected' => [[1, 1, 1], [1, 1, 1], [1, 1, 1]],
            ],
            [
                'elements' => [1, 1, 1, 1, 1, 1, 1, 1, 1],
                'ranges'   => 1,
                'expected' => [[1, 1, 1, 1, 1, 1, 1, 1, 1]],
            ],
            [
                'elements' => [1, 1, 1, 1, 1, 1, 1, 1, 1],
                'ranges'   => 0,
                'expected' => [],
            ],
        ];
    }

    public function invalid_input_values(): array
    {
        return [
            'negative integers' => [[1, 1, 1, 1, -5, 1, 1, 1, 1]],
            'negative floats'   => [[1, 1, 1.5, 1, -5.0, 1, 1, 1.9, 1]],
            'boolean'           => [[1, 1, 1, 1, false, 1, 1, 1, 1]],
            'array'             => [[1, 1, 1, 1, [1], 1, 1, 1, 1]],
            'object'            => [[1, 1, 1, 1, $this, 1, 1, 1, 1]],
            'null'              => [[1, 1, 1, 1, null, 1, 1, 1, 1]],
            'zeros'             => [[1, 1, 1, 1, 0, 1, 1, 1, 1]],
        ];
    }
}
