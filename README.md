# Voyager Excel Export

[![Tests](https://github.com/tu6ge/voyager-excel/workflows/Tests/badge.svg?branch=master)](https://github.com/tu6ge/voyager-excel/actions)
[![Coverage Status](https://coveralls.io/repos/github/tu6ge/voyager-excel/badge.svg?branch=master)](https://coveralls.io/github/tu6ge/voyager-excel?branch=master)
[![Latest Stable Version](https://poser.pugx.org/tu6ge/voyager-excel/v)](//packagist.org/packages/tu6ge/voyager-excel)
[![styleci](https://github.styleci.io/repos/239457151/shield?branch=master)](https://github.com/tu6ge/voyager-excel)
[![FOSSA Status](https://app.fossa.com/api/projects/git%2Bgithub.com%2Ftu6ge%2Fvoyager-excel.svg?type=shield)](https://app.fossa.com/projects/git%2Bgithub.com%2Ftu6ge%2Fvoyager-excel?ref=badge_shield)
[![](https://img.shields.io/github/issues-closed/tu6ge/voyager-excel)](https://github.com/tu6ge/voyager-excel)
[![](http://github-actions.40ants.com/tu6ge/voyager-excel/matrix.svg)](https://github.com/tu6ge/voyager-excel)


a plugin of [voyager](https://github.com/the-control-group/voyager) for excel export

## Required

- *voyager* this is a missing laravel admin 

## Install

```bash
composer require tu6ge/voyager-excel
```

## Configuration

1. disable special Model

You can disable export button in special Model :

```
class Example extends Model
{
    public $disable_export = true;

    // ...
}
```

2. allow export all records of special Model, default export selected records

```
class Example extends Model
{
    public $allow_export_all = true;

    // ...
}
```

## Support Language

- zh_CN
- en 

## Test

run `composer test` command.

## License

[![FOSSA Status](https://app.fossa.com/api/projects/git%2Bgithub.com%2Ftu6ge%2Fvoyager-excel.svg?type=large)](https://app.fossa.com/projects/git%2Bgithub.com%2Ftu6ge%2Fvoyager-excel?ref=badge_large)

## Links

- [Voyager中文文档](http://doc.laravel-voyager.cn/)

## Star

If this packages helped you, leave a star for the author.

## Contributing

[Contributing Guide](https://github.com/tu6ge/voyager-excel/blob/master/CONTRIBUTING.md)

