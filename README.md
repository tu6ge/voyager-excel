# Voyager Excel Export

[![Tests](https://github.com/tu6ge/voyager-excel/workflows/Tests/badge.svg?branch=master)](https://github.com/tu6ge/voyager-excel/)
[![Coverage Status](https://coveralls.io/repos/github/tu6ge/voyager-excel/badge.svg?branch=master)](https://coveralls.io/github/tu6ge/voyager-excel?branch=master)
[![Latest Stable Version](https://poser.pugx.org/tu6ge/voyager-excel/v)](//packagist.org/packages/tu6ge/voyager-excel)

[![](http://github-actions.40ants.com/tu6ge/voyager-excel/matrix.svg)](https://github.com/tu6ge/voyager-excel)


a plugin for excel export 

## Install

```bash
composer require tu6ge/voyager-excel
```

## Configuration

1. disable special Model

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

- zh_CN （中文）
- en 

## License

MIT

## Links

- [Voyager中文文档](http://doc.laravel-voyager.cn/)
- [国内插件源](http://satisfy.xiaoqiezi.top)
- [国内插件源使用方法](http://doc.laravel-voyager.cn/getting-started/installation.html#%E5%AE%89%E8%A3%85%E4%B8%AD%E6%96%87%E8%AF%AD%E8%A8%80%E5%8C%85)
