<?php 

namespace VoyagerExcel\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use TCG\Voyager\Facades\Voyager;

class PostExport implements FromCollection
{
    protected $dataType;
    protected $model;
    protected $ids;
    public function __construct($dataType, $ids)
    {
        $this->dataType = $dataType;
        $this->model = new $dataType->model_name;
        $this->ids = $ids;
    }
    public function collection()
    {
        $fields = $this->dataType->browseRows->map(function($res){
            return $res['field'];
        });

        $table = $this->dataType->browseRows->map(function($res){
            return $res['display_name'];
        });

        $rs =  $this->model->whereIn('id', $this->ids)->get();
        $rs = $rs->map(function($res)use($fields){
            $arr = [];
            foreach($fields as $val){
                $arr[$val] = $res[$val];
            }
            return $arr;
        });

        $table = collect([$table->toArray()])->merge($rs);

        return $table;
    }
}