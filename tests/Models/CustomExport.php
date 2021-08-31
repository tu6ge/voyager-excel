<?php

namespace Tu6ge\VoyagerExcel\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\FromCollection;
use Tu6ge\VoyagerExcel\Exports\AbstractExport;

class CustomExport extends Model
{
    protected $table = 'categories';

    public $export_handler = MyExport::class;

    protected $fillable = ['slug', 'name'];
}

class MyExport extends AbstractExport implements FromCollection
{
    public function __construct($dataType, array $ids)
    {
    }

    public function collection()
    {
        return collect([['foo', 'bar']]);
    }
}
