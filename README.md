# PHP Pipe Operator

<a href="https://packagist.org/packages/sebastiaanluca/php-pipe-operator"><img src="https://poser.pugx.org/sebastiaanluca/php-pipe-operator/version" alt="Latest stable release"></img></a>
<a href="LICENSE.md"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg" alt="Software license"></img></a>
<a href="https://travis-ci.org/sebastiaanluca/php-pipe-operator"><img src="https://img.shields.io/travis/sebastiaanluca/php-pipe-operator/master.svg" alt="Build status"></img></a>
<a href="https://packagist.org/packages/sebastiaanluca/php-pipe-operator"><img src="https://img.shields.io/packagist/dt/sebastiaanluca/php-pipe-operator.svg" alt="Total downloads"></img></a>

<a href="https://packagist.org/packages/sebastiaanluca"><img src="https://img.shields.io/badge/link-packagist-lightgrey.svg" alt="View my other packages and projects"></img></a>
<a href="https://blog.sebastiaanluca.com"><img src="https://img.shields.io/badge/link-blog-lightgrey.svg" alt="Read my blog"></img></a>
<a href="https://twitter.com/sebastiaanluca"><img src="https://img.shields.io/twitter/follow/sebastiaanluca.svg?style=social" alt="Follow @sebastiaanluca on Twitter"></img></a>
<a href="https://twitter.com/intent/tweet?text=Use%20PHP%27s%20pipe%20operator%20now!%20https%3A%2F%2Fgithub.com%2Fsebastiaanluca%2Fphp-pipe-operator%20via%20%40sebastiaanluca&source=webclient"><img src="https://img.shields.io/twitter/url/http/shields.io.svg?style=social" alt="Share this package on Twitter"></img></a>

A (hopefully) temporary solution to implement the pipe operator in PHP.

## Table of contents

- [Requirements](#requirements)
- [How to install](#how-to-install)
- [What does it solve?](#what-does-it-solve)
    - [A simple example](#a-simple-example)
    - [Another way of writing](#another-way-of-writing)
    - [More examples of the issue at hand](#more-examples-of-the-issue-at-hand)
- [How to use](#how-to-use)
    - [The basics](#the-basics)
    - [Using closures](#using-closures)
    - [Using class methods](#using-class-methods)
- [Notes](#notes)
- [License](#license)
- [Change log](#change-log)
- [Testing](#testing)
- [Contributing](#contributing)
- [Security](#security)
- [Credits](#credits)
- [About](#about)

## Requirements

- PHP 7.1 or higher

## How to install

Via Composer:

```bash
composer require sebastiaanluca/php-pipe-operator
```

## What does it solve?

This package is based on the [pipe operator RFC by Sara Golemon (2016)](https://wiki.php.net/rfc/pipe-operator), who explains the problem as:

>A common PHP OOP pattern is the use of method chaining, or what is also known as “Fluent Expressions”. […] This works well enough for OOP classes which were designed for fluent calling, however it is impossible, or at least unnecessarily arduous, to adapt non-fluent classes to this usage style, harder still for functional interfaces.

Coming across the proposal, I also [blogged about it](https://blog.sebastiaanluca.com/enabling-php-method-chaining-with-a-makeshift-pipe-operator).

### A simple example

Say you want to get the subdomain from a URL, you end up with something like this:

```php
$subdomain = 'https://blog.sebastiaanluca.com/';
$subdomain = parse_url($subdomain, PHP_URL_HOST);
$subdomain = explode('.', $subdomain);
$subdomain = reset($subdomain);

// "blog"
```

This works, of course, but it's quite verbose and repetitive.

### Another way of writing

Same result, different style:

```php
$subdomain = explode('.', parse_url('https://blog.sebastiaanluca.com/', PHP_URL_HOST))[0];

// "blog"
```

This might be the worst of all solutions, as it requires you to start reading from the center, work your way towards the outer methods, and keep switching back and forth. The more methods and variants, the more difficult to get a sense of what's going on.

### More examples of the issue at hand

See [Sara's RFC](https://wiki.php.net/rfc/pipe-operator#introduction) for more complex and real-world examples.

## How to use

### The basics

The basic gist of the package is that it takes a value and performs one or more actions on it. A simple example:

```php
take('hello')->strtoupper()->get();

// "HELLO"
```

Of course that's not very useful since you could've just used `strtoupper('hello')` and be done with it, but the goal is to make multi-method calls on a value easier to read and write:

```php
$subdomain = take('https://blog.sebastiaanluca.com')
    ->parse_url()
    ->end()
    ->explode('.', PIPED_VALUE)
    ->reset()
    ->get();

// "blog"
```

Note that in comparison to the original RFC, there's no need to pass the initial value to methods that receive the value as first parameter and have no other required parameters. The previous value is always passed as first parameter. In effect, both of the following examples will work:

```php
take('hello')->strtoupper()->get();

// "HELLO"

take('hello')->strtoupper(PIPED_VALUE)->get();

// "HELLO"
```

In contrast, if a method takes e.g. a setting before the previous value, we need to set it manually using the replacement identifier (the globally available `PIPED_VALUE` constant). This identifier can be placed *anywhere* in the method call, it will simply be replaced by the previous value.

```php
take(['key' => 'value'])
    ->array_search('value', PIPED_VALUE)
    ->get();

// "key"
```

### Using closures

Sometimes standard methods don't cut it and you need to perform a custom operation on a value in the process. You can do so using a closure:

```php
take('string')
    ->pipe(function (string $value) {
        return 'prefixed-' . $value;
    })
    ->get();

// "prefixed-string"
```

### Using class methods

The same is possible using a class method (regardless of visibility):

```php
class MyClass
{
    public function __construct()
    {
        take('HELLO')
            ->pipe($this)->lowercase()
            ->get();

        // "hello"
    }

    /**
     * @param string $value
     *
     * @return string
     */
    private function lowercase(string $value) : string
    {
        return mb_strtolower($value);
    }
}
```

#### Class method alternatives

If you don't want to use the internal pipe proxy and pass `$this`, there are two other ways you can use class methods.

Using an array (for public methods only):

```php
class MyClass
{
    public function __construct()
    {
        take('HELLO')
            ->pipe([$this, 'lowercase'])
            ->get();

        // "hello"
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function lowercase(string $value) : string
    {
        return mb_strtolower($value);
    }
}
```

By parsing the callable method to a closure:

```php
use Closure;

class MyClass
{
    public function __construct()
    {
        take('HELLO')
            ->pipe(Closure::fromCallable([$this, 'lowercase']))
            ->get();

        // "hello"
    }

    /**
     * @param string $value
     *
     * @return string
     */
    private function lowercase(string $value) : string
    {
        return mb_strtolower($value);
    }
}
```

## Notes

While this packages makes a good attempt at bringing the pipe operator to PHP, it unfortunately does not offer autocompletion on chained methods. For that to work we need the real deal, so make some noise and get the people in charge to vote *for* Sara's RFC!

## License

This package operates under the MIT License (MIT). Please see [LICENSE](LICENSE.md) for more information.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

```bash
composer install
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email [hello@sebastiaanluca.com][link-author-email] instead of using the issue tracker.

## Credits

- [Sebastiaan Luca][link-github-profile]
- [All Contributors][link-contributors]

## About

My name is Sebastiaan and I'm a freelance Laravel developer specializing in building custom Laravel applications. Check out my [portfolio][link-portfolio] for more information, [my blog][link-blog] for the latest tips and tricks, and my other [packages][link-packages] to kick-start your next project.

Have a project that could use some guidance? Send me an e-mail at [hello@sebastiaanluca.com][link-author-email]!

[link-packagist]: https://packagist.org/packages/sebastiaanluca/php-pipe-operator
[link-travis]: https://travis-ci.org/sebastiaanluca/php-pipe-operator
[link-contributors]: ../../contributors

[link-portfolio]: https://www.sebastiaanluca.com
[link-blog]: https://blog.sebastiaanluca.com
[link-packages]: https://packagist.org/packages/sebastiaanluca
[link-github-profile]: https://github.com/sebastiaanluca
[link-author-email]: mailto:hello@sebastiaanluca.com
