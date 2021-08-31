<!-- vscode-markdown-toc -->


<!-- vscode-markdown-toc-config
	numbering=true
	autoSave=true
	/vscode-markdown-toc-config -->
<!-- /vscode-markdown-toc -->
# Voyager Excel Export

[![Tests](https://github.com/tu6ge/voyager-excel/workflows/Tests/badge.svg?branch=master)](https://github.com/tu6ge/voyager-excel/actions)
[![Coverage Status](https://coveralls.io/repos/github/tu6ge/voyager-excel/badge.svg?branch=master)](https://coveralls.io/github/tu6ge/voyager-excel?branch=master)
[![Latest Stable Version](https://poser.pugx.org/tu6ge/voyager-excel/v)](//packagist.org/packages/tu6ge/voyager-excel)
[![styleci](https://github.styleci.io/repos/239457151/shield?branch=master)](https://github.com/tu6ge/voyager-excel)
[![FOSSA Status](https://app.fossa.com/api/projects/git%2Bgithub.com%2Ftu6ge%2Fvoyager-excel.svg?type=shield)](https://app.fossa.com/projects/git%2Bgithub.com%2Ftu6ge%2Fvoyager-excel?ref=badge_shield)
[![](https://img.shields.io/github/issues-closed/tu6ge/voyager-excel)](https://github.com/tu6ge/voyager-excel)
[![](http://github-actions.40ants.com/tu6ge/voyager-excel/matrix.svg)](https://github.com/tu6ge/voyager-excel)


a plugin of [voyager](https://github.com/the-control-group/voyager) for excel export

##  <a name='Required'></a>Required

- *voyager* this is a missing laravel admin 

##  <a name='Install'></a>Install

```bash
composer require tu6ge/voyager-excel
```

##  <a name='Usage'></a>Usage

* 1. [disable special Model](#disablespecialModel)
* 2. [Allow export all records of special Model, default export selected records](#export-all)
* 3. [Custom export excel content and format.](#custom-export)

###  1. <a name='disablespecialModel'></a>disable special Model

You can disable export button in special Model :

```
class Example extends Model
{
    public $disable_export = true;

    // ...
}
```

###  2. <a name='export-all'></a>Allow export all records of special Model, default export selected records

```
class Example extends Model
{
    public $allow_export_all = true;

    // ...
}
```

###  3. <a name='custom-export'></a>Custom export excel content and format.

Now, You can customize the export excel content and format, Use more features of `maatwebsite/excel`:

1. Create a custom export class , and extends `Tu6ge\VoyagerExcel\Exports\AbstractExport` :

```
<?php

namespace YourApp;

use Tu6ge\VoyagerExcel\Exports\AbstractExport;

class MyCustomExport extends AbstractExport
{
    protected $dataType;
    protected $model;

    public function __construct($dataType, array $ids)
    {
        $this->dataType = $dataType;
        $this->model = new $dataType->model_name();

        // write your own idea
    }
}
```

`Export` class more usage, see [documents](https://docs.laravel-excel.com/3.1/exports/collection.html)

2. Associate the export with your model:

```
<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $export_handler = \YourApp\MyCustomExport::class;
}
```

now, you export this Model data , the excel format is your custom.

##  <a name='SupportLanguage'></a>Support Language

- zh_CN
- en 

##  <a name='Test'></a>Test

run `composer test` command.

##  <a name='License'></a>License

[![FOSSA Status](https://app.fossa.com/api/projects/git%2Bgithub.com%2Ftu6ge%2Fvoyager-excel.svg?type=large)](https://app.fossa.com/projects/git%2Bgithub.com%2Ftu6ge%2Fvoyager-excel?ref=badge_large)

##  <a name='Links'></a>Links

- [Voyager中文文档](http://doc.laravel-voyager.cn/)

##  <a name='Star'></a>Star

If this packages helped you, leave a star for the author.

##  <a name='Contributing'></a>Contributing

[Contributing Guide](https://github.com/tu6ge/voyager-excel/blob/master/CONTRIBUTING.md)

