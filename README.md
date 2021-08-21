# Laravel Form Generator

[![Latest Version on Packagist](https://img.shields.io/packagist/v/yeejiawei/laravel-form-generator.svg)](https://packagist.org/packages/yeejiawei/laravel-form-generator)
[![Latest Version on Packagist](https://img.shields.io/badge/license-MIT-green)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/yeejiawei/laravel-form-generator.svg)](https://packagist.org/packages/yeejiawei/laravel-form-generator)
![Github.com Stars](https://img.shields.io/github/stars/yeejiawei/laravel-form-generator.svg)

## Installation

You can install the package via composer:

```bash
composer require yeejiawei/laravel-form-generator
```

## Usage

```php
return FormGenerator::create()
            ->setLayout('layouts_admin.app') // set layout when no using 'layouts.app' as default
            ->setFormName('Create Category')
            ->addInputField('title')
            ->setCreateRouteName('category.store')
            ->render();
```

## Credits

- [YeeJiaWei](https://github.com/YeeJiaWei)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.