# php-stemmer

[![PHP Version](https://img.shields.io/badge/php-%5E7.4%7C%5E8.0-blue.svg)](https://img.shields.io/badge/php-%5E7.4%7C%5E8.0-blue.svg)
![CI](https://github.com/amaccis/php-stemmer/workflows/CI/badge.svg)

## What is PHP Stemmer?
PHP Stemmer is a PHP interface to the stemming algorithms from the [Snowball project](https://snowballstem.org/), largely inspired by Richard Boulton's [PyStemmer](https://github.com/snowballstem/pystemmer).
It uses FFI (PHP >= 7.4.0) and expects to find the file libstemmer.so (a version of [Libstemmer](https://snowballstem.org/dist/libstemmer_c.tgz) compiled as shared library) in LD_LIBRARY_PATH.  
In order to set-up this kind of environment you can take a look at [docker-php-libstemmer](https://github.com/amaccis/docker-php-libstemmer) Dockerfile or you can use the corresponding docker image: [amaccis/php-libstemmer](https://hub.docker.com/r/amaccis/php-libstemmer)

## Installation

PHP Stemmer is available on [Packagist](http://packagist.org/packages/amaccis/php-stemmer), 
you can install it using [Composer](http://getcomposer.org).

```shell
composer require amaccis/php-stemmer
```

## Usage

```php
<?php

use Amaccis\Stemmer\Stemmer;

$algorithms = Stemmer::algorithms();
var_dump($algorithms);
/*
array(26) {
  [0]=>
  string(6) "arabic"
  [1]=>
  string(6) "basque"
  [2]=>
  string(7) "catalan"
  [3]=>
  string(6) "danish"
  [4]=>
  string(5) "dutch"
  [5]=>
  string(7) "english"
  [6]=>
  string(7) "finnish"
  [7]=>
  string(6) "french"
  [8]=>
  string(6) "german"
  [9]=>
  string(5) "greek"
  [10]=>
  string(5) "hindi"
  [11]=>
  string(9) "hungarian"
  [12]=>
  string(10) "indonesian"
  [13]=>
  string(5) "irish"
  [14]=>
  string(7) "italian"
  [15]=>
  string(10) "lithuanian"
  [16]=>
  string(6) "nepali"
  [17]=>
  string(9) "norwegian"
  [18]=>
  string(6) "porter"
  [19]=>
  string(10) "portuguese"
  [20]=>
  string(8) "romanian"
  [21]=>
  string(7) "russian"
  [22]=>
  string(7) "spanish"
  [23]=>
  string(7) "swedish"
  [24]=>
  string(5) "tamil"
  [25]=>
  string(7) "turkish"
}
*/

$algorithm = "english";
$word = "cycling";
$stemmer = new Stemmer($algorithm);
$stem = $stemmer->stemWord($word);
var_dump($stem);
/*
string(4) "cycl"
*/
```

## License
All files are MIT &copy; [Andrea Maccis](https://twitter.com/andreamaccis) except for _resources/libstemmer.h_ BSD-3 &copy; [Snowball Project](https://github.com/snowballstem/snowball).