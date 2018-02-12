# PHP solution to Linear Partition Problem 

Based on a description from [The Algorithm Design Manual](http://www.algorist.com/) book by *Steven S. Skiena*.

* Leverages the Dynamic Programming principle
* *O(n²)* complexity
* Fully annotated code
* Test suite
* Semver

## Installation

```bash
composer require technically-php/linear-partitioning:^1.0
```

## Usage

```php

use \TechnicallyPhp\LinearPartitioning\LinearPartitioning;

$items = [100, 200, 300, 400, 500, 600, 700, 800, 900];
$ranges = LinearPartitioning::partition($items, 3);

var_dump($ranges);
// [ [100, 200, 300, 400, 500], [600, 700], [800, 900] ]

```

## Credits

* Implemented by [Ivan Voskoboinyk](https://github.com/e1himself)
