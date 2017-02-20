<?php

require 'src/functions.php';

function validate(array $expected, array $actual) {
    assert($expected == $actual, json_encode($expected) . ' !== ' . json_encode($actual));
}

validate(
    partition([1,2,3,4,5,6,7,8,9], 3),
    [[1,2,3,4,5], [6,7], [8,9]]
);

validate(
    partition([1,1,1,1,1,1,1,1,1], 3),
    [[1,1,1], [1,1,1], [1,1,1]]
);

validate(
    partition([1,1,1,1,1,1,1,1,1], 1),
    [[1,1,1,1,1,1,1,1,1]]
);
