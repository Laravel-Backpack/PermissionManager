# Backpack\Settings

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

An interface for the administrator to easily change application settings. Uses Laravel Backpack. On Laravel 5.2.

## Install

1) In your terminal:

``` bash
$ composer require backpack/settings
$ php artisan migrate --path=vendor/backpack/settings/src/database/migrations
$ php artisan db:seed --class="Backpack\Settings\database\seeds\SettingsTableSeeder"
```

2) Add the service provider to your config/app.php file:
```php
Backpack\Settings\SettingsServiceProvider::class,
```

3) [Optional] Add a menu item for it in resources/views/vendor/backpack/base/inc/sidebar.blade.php or menu.blade.php:

```html
<li><a href="{{ url('admin/setting') }}"><i class="fa fa-cog"></i> <span>Settings</span></a></li>
```


## Usage

### End user
Add it to the menu or access it by its route: **application/admin/setting**

### Programmer
Use it like you would any config value in a virtual settings.php file. Except the values are stored in the database and fetched on boot, instead of being stored in a file.

``` php
Config::get('settings.contact_email')
```

### Add new settings

Settings are stored in the database in the "settings" table. Its columns are:
- id (ex: 1)
- key (ex: contact_email)
- name (ex: Contact form email address)
- description (ex: The email address that all emails go to.)
- value (ex: admin@laravelbackpack.com)
- field (Backpack CRUD field configuration in JSON format. http://laravelbackpack.com/docs)
- active (1 or 0)
- created_at
- updated_at

There is no interface available to add new settings. They are added by the developer directly in the database, since the Dick CRUD field configuration is a bit complicated. See the field types and their configuration code on http://laravelbackpack.com/docs

## Screenshots

See http://laravelbackpack.com

- List view:
![List / table view in Backpack/Settings](https://dl.dropboxusercontent.com/u/2431352/backpack_settings_list.png)
- Editing a setting with the email field type:
![Editing an email setting in Backpack/Settings](https://dl.dropboxusercontent.com/u/2431352/backpack_settings_email.png)
- Editing a setting with the textarea field type:
![Editing a textarea setting in Backpack/Settings](https://dl.dropboxusercontent.com/u/2431352/backpack_settings_textarea.png)

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email hello@tabacitu.ro instead of using the issue tracker.

## Credits

- [Cristian Tabacitu][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/backpack/settings.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/laravel-backpack/settings/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/laravel-backpack/settings.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/laravel-backpack/settings.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/backpack/settings.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/backpack/settings
[link-travis]: https://travis-ci.org/laravel-backpack/settings
[link-scrutinizer]: https://scrutinizer-ci.com/g/laravel-backpack/settings/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/laravel-backpack/settings
[link-downloads]: https://packagist.org/packages/backpack/settings
[link-author]: http://tabacitu.ro
[link-contributors]: ../../contributors
