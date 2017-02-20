<?php

require 'src/functions.php';

assert(
    partition([1,2,3,4,5,6,7,8,9], 3) == [[1,2,3,4,5], [6,7], [8,9]]
);

assert(
    partition([1,1,1,1,1,1,1,1,1], 3) == [[1,1,1], [1,1,1], [1,1,1]]
);

assert(
    partition([1,1,1,1,1,1,1,1,1], 1) == [[1,1,1,1,1,1,1,1,1]]
);
