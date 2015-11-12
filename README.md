# Potato-orm

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]


A simple ORM to insert, read, update, and delete data from a database.

## Install

Via Composer

``` bash
$ composer require Wilson/potato-orm
```

## Usage

- Insert a record into the database table, e.g. users table

```
$person = new User();
$person->name = "Wilson Omokoro";
$person->email = "wilson.omokoro@andela.com";
$person->password = "12345";
$person->save();
```

- Read all records from the database table

```
$users = User::getAll();
print_r($users);
```

- Update a record in the database table. For example update the password of the fifth record in the users table:

```
$user = User::find(5);
$user->password = "lkHJu9Z";
$user->save();
```

- Delete a record from the database table. For example delete the third record in the users table:

```
$user = User::destroy(3);
```

## Testing

If the  folder containing your test classes is "tests"

```
$ phpunit tests
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email :author_email instead of using the issue tracker.

## Credits

Potato-orm is maintained by Wilson Omokoro.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/league/:package_name.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/thephpleague/:package_name/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/thephpleague/:package_name.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/thephpleague/:package_name.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/league/:package_name.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/league/:package_name
[link-travis]: https://travis-ci.org/thephpleague/:package_name
[link-scrutinizer]: https://scrutinizer-ci.com/g/thephpleague/:package_name/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/thephpleague/:package_name
[link-downloads]: https://packagist.org/packages/league/:package_name
[link-author]: https://github.com/:author_username
[link-contributors]: ../../contributors
