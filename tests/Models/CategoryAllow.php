<?php

namespace Tu6ge\VoyagerExcel\Tests\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryAllow extends Model
{
    public $allow_export_all = true;

    protected $table = 'categoryallows';

    protected $fillable = ['slug', 'name'];
}
