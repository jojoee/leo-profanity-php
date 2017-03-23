# leo-profanity-php

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]

Profanity filter, based on Shutterstock dictionary

## Install

Via Composer

``` bash
$ composer require jojoee/leo-profanity
```

``` php
use Jojoee\Library\LeoProfanity as LeoProfanity;

$filter = new LeoProfanity();
$filter->check('I have BoOb');
```

## Usage

### $filter->getList()

``` php
// return all profanity words (string[])
$filter->getList();
```

### $filter->check(string)

Check out mor example on `clean` method

``` php
// output: true
$filter->clean('I have boob');
```

### $filter->clean(string, [replaceKey=*])

``` php
// no bad word
// output: I have 2 eyes
$filter->clean('I have 2 eyes');

// normal case
// output: I have ****, etc.
$filter->clean('I have boob, etc.');

// case sensitive
// output: I have ****
$filter->clean('I have BoOb');

// separated by comma and dot
// output: I have ****.
$filter->clean('I have BoOb.');

// multi occurrence
// output: I have ****,****, ***, and etc.
$filter->clean('I have boob,boob, ass, and etc.');

// should not detect unspaced-word
// output: Buy classic watches online
$filter->clean('Buy classic watches online');

// clean with custom replacement-character
// output: I have ++++
$filter->clean('I have boob', '+');
```

### $filter->add(string|string[])

``` php
// add word
$filter->add('b00b');

// add word's array
// check duplication automatically
$filter->add(['b00b', 'b@@b']);
```

### $filter->remove(string|string[])

``` php
// remove word
$filter->remove('b00b');

// remove word's array
$filter->remove(['b00b', 'b@@b']);
```

### $filter->reset()

Reset word list by using default dictionary (also remove word that manually add)

### $filter->clearList()

Clear all profanity words

## Note

- [Filter algorithm from `jojoee/leo-profanity`](https://github.com/jojoee/leo-profanity#algorithm)
- Testing (using `composer test`) 
- [PSR-2 Coding Standard](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) (tested by `composer check-style` and fix it with `composer fix-style`.)
- Security, if you discover any security related issues, please email inid3a@gmail.com instead of using the issue tracker.
- Follow [SemVer v2.0.0](http://semver.org/)
- Coherent history (each individual commit is meaningful), if not please [squash them](http://www.git-scm.com/book/en/v2/Git-Tools-Rewriting-History#Changing-Multiple-Commit-Messages).

## TODO

- [x] Unit test
- [x] Test coverage
- [x] PHP CodeSniffer
- [x] Support PHP version 5.6, 7.0, hhvm

## Contribute

Please run `composer check` and fix before commit

## Reference

- Skeleton template: [thephpleague/skeleton](https://github.com/thephpleague/skeleton), [koriym/Koriym.PhpSkeleton](https://github.com/koriym/Koriym.PhpSkeleton), [petk/php-skeleton](https://github.com/petk/php-skeleton)

[ico-version]: https://img.shields.io/packagist/v/jojoee/leo-profanity.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/jojoee/leo-profanity-php/master.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/jojoee/leo-profanity
[link-travis]: https://travis-ci.org/jojoee/leo-profanity-php

