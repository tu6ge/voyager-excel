<?php

namespace Tu6ge\VoyagerExcel\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\FromCollection;

class CustomExportThrow extends Model
{
    protected $table = 'categories';

    public $export_handler = MyTwoExport::class;

    protected $fillable = ['slug', 'name'];
}

class MyTwoExport implements FromCollection
{
    public function __construct($dataType, array $ids)
    {
    }

    public function collection()
    {
        return collect([['foo', 'bar']]);
    }
}
