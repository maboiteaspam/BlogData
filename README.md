# C\BlogData

[![Commitizen friendly](https://img.shields.io/badge/commitizen-friendly-brightgreen.svg)](http://commitizen.github.io/cz-cli/)

C\BlogData module provides blog oriented
data providers service.

## Install

Until the module is published,
add this repository to the `composer` file
then run `composer update`.
```
# composer.json
,
    {
      "type": "git",
      "url": "git@github.com:maboiteaspam/BlogData.git
    }

shell
# composer update
```

or run `c2-bin require-gh -m=...`

```
c2-bin require-gh -m=maboiteaspam/BlogData
```


## Registration

To register this module please proceed such,

```php

require 'vendor/autoload.php';

$app = new Application();

$config = [
    'env'=>'dev',
    'blogdata.provider'     => "Eloquent",
//    'blogdata.provider'   => "PO",
    'capsule.connections' => [
        "dev"=>[
            'driver'    => 'sqlite',
            'database'  => ':memory:',
            'prefix'    => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ],
    ],
];
foreach ($config as $k=>$v) {
    $app[$k] = $v;
}
$eloquent = new Eloquent();
$app->register($eloquent);
$blog = new BlogData();
$app->register($blog);
$app->boot();

```

## Usage

This module providers several pieces to
work with a simple blog data model.

#### Entities

- ling to BlogEntry
- ling to BlogComment

#### Schemas

- ling to BlogEntry
- ling to BlogComment

#### Fixtures

- ling to BlogEntry
- ling to BlogComment

## Example

To use this module please proceed such,

```php

// .. boot the app

/* @var $entryService EntryRepositoryInterface */
$entryService = $app['blogdata.entry'];

/* @var $entrySchema \C\BlogData\Eloquent\Schema */
$entrySchema = $app['blogdata.schema'];

try{
    $entrySchema->dropTables(); // at first init,
    // there is no such tables to drop
    // so it miserably fails.
}catch (\Exception $ex){ /* the try/catch cover ups. */ }
$entrySchema->createTables();

$entry = new Entry();
$entry->title = 'title;';
$entry->author = 'title;';
$entry->img_alt = 'title;';
$entry->content = 'title;';
$entry->status = 'title;';
$entry->created_at = date('Y-m-d');
$entry->updated_at = date('Y-m-d');
unset($entry->comments); // needed by eloquent.

$insertedId = $entryService->insert($entry);

```

## Configuration

This module exposes those configuration values,

##### blogdata.provider

`blogdata.provider` configures the underlying data providers.

It accepts `Eloquent` or `PO`.

## Services

This module exposes those services,

##### blogdata.entry

`blogdata.entry` provides a `EntryRepositoryInterface` compatible data provider.

##### blogdata.comment

`blogdata.comment` provides a `CommentRepositoryInterface` compatible data provider.

##### blogdata.schema

`blogdata.schema` can initialize a database to `drop`, `create` tables.

## Requirements

php-pdo ect

## Contributing

For now on please follow `angular` contributing guide as it s very nice effort.

https://github.com/angular/angular.js/blob/master/CONTRIBUTING.md#-git-commit-guidelines

Read also about `symfony` recommendations
- http://symfony.com/doc/current/contributing/documentation/format.html
- http://symfony.com/doc/current/contributing/documentation/standards.html

Check also this wonderful software to realize the `git commit` command

- https://github.com/commitizen/cz-cli
- https://github.com/kentcdodds/validate-commit-msg

## Credits, notes, more

Have fun!
