<p align="center">
<h1>PHP Pipe Operator</h1>
</p>

<p align="center">
<a href="https://packagist.org/packages/sebastiaanluca/php-pipe-operator"><img src="https://poser.pugx.org/sebastiaanluca/php-pipe-operator/version" alt="Latest stable release"></img></a>
<a href="LICENSE.md"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg" alt="Software license"></img></a>
<a href="https://travis-ci.org/sebastiaanluca/php-pipe-operator"><img src="https://img.shields.io/travis/sebastiaanluca/php-pipe-operator/master.svg" alt="Build status"></img></a>
<a href="https://packagist.org/packages/sebastiaanluca/php-pipe-operator"><img src="https://img.shields.io/packagist/dt/sebastiaanluca/php-pipe-operator.svg" alt="Total downloads"></img></a>
</p>

<p align="center">
<a href="https://blog.sebastiaanluca.com"><img src="https://img.shields.io/badge/link-blog-lightgrey.svg" alt="Read my blog"></img></a>
<a href="https://packagist.org/packages/sebastiaanluca"><img src="https://img.shields.io/badge/link-other_packages-lightgrey.svg" alt="View my other packages and projects"></img></a>
<a href="https://twitter.com/sebastiaanluca"><img src="https://img.shields.io/twitter/follow/sebastiaanluca.svg?style=social" alt="Follow @sebastiaanluca on Twitter"></img></a>
<a href="https://twitter.com/intent/tweet?text=Use%20PHP%27s%20pipe%20operator%20now!%20https%3A%2F%2Fgithub.com%2Fsebastiaanluca%2Fphp-pipe-operator%20via%20%40sebastiaanluca&source=webclient"><img src="https://img.shields.io/twitter/url/http/shields.io.svg?style=social" alt="Share this package on Twitter"></img></a>
</p>

# PHP Pipe Operator

**A (hopefully) temporary solution to implement the pipe operator in PHP.**

## Table of contents

- [Requirements](#requirements)
- [How to install](#how-to-install)
- [How to use](#how-to-use)
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

If you want to use the global function helper, copy the code below to your project or install `sebastiaanluca/php-helpers`:

```
if (! function_exists('take')) {
    /**
     * Create a new piped item from a given value.
     *
     * @param mixed $value
     *
     * @return \SebastiaanLuca\PipeOperator\Item
     */
    function take($value) : Item
    {
        return new \SebastiaanLuca\PipeOperator\Item($value);
    }
}
```

or

```bash
composer require sebastiaanluca/php-helpers
```

### How to use

```php
(new Item('https://blog.sebastiaanluca.com'))
    ->pipe('parse_url')
    ->pipe('end')
    ->pipe('explode', '.', '$$')
    ->pipe('reset')
    ->get()

// "blog"
```

Similar using the shorthand helper:

```php
take('https://blog.sebastiaanluca.com')
    ->pipe('parse_url')
    ->pipe('end')
    ->pipe('explode', '.', '$$')
    ->pipe('reset')
    ->get()

// "blog"
```

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
