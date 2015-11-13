# Potato-orm

[![Build Status](https://travis-ci.org/andela-womokoro/potato-orm.svg)](https://travis-ci.org/andela-womokoro/potato-orm)


A simple ORM to insert, read, update, and delete data from a database written in PHP.

## Install

Via Composer

``` bash
$ composer require Wilson/potato-orm
```

## Usage

- Simply extend the base class. The base class is an abstract class called "Base". So for example if you have a users table in the database and you wish to perform create, read, update, and delete (CRUD) operations on the table, create a corresponding class like this

```
use Wilson\Source\Base;

class User extends Base
{

}
```

- Insert a record into the table

```
$person = new User();
$person->name = "Wilson Omokoro";
$person->email = "wilson.omokoro@andela.com";
$person->password = "12345";
$person->save();
```

- Find a particular record in the table

```
$user = User::find(3);
echo $user->result;
```

- Read all records from the table

```
$users = User::getAll();
print_r($users);
```

- Update a record in the table. For example update the password of the fifth record in the users table:

```
$user = User::find(5);
$user->password = "lkHJu9Z";
$user->save();
```

- Delete a record from the table. For example delete the third record in the users table:

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

If you discover any security related issues, please email wilson.omokoro@andela.com instead of using the issue tracker.

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
