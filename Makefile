.PHONY: clean test

clean:
	rm -rf vendor
vendor:
	composer install
test: vendor
	php test.php
