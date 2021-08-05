<?php

namespace Tu6ge\VoyagerExcel\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class BaseExport implements FromCollection
{
    protected $dataType;
    protected $model;
    protected array $ids;

    public function __construct($dataType, array $ids)
    {
        $this->dataType = $dataType;
        $this->model = new $dataType->model_name();
        $this->ids = array_filter($ids);
    }

    public function collection()
    {
        $fields = $this->dataType->browseRows->map(function ($res) {
            return $res['field'];
        });

        $table = $this->dataType->browseRows->map(function ($res) {
            return $res['display_name'];
        });

        $rs = $this->model->when(
            count($this->ids) > 0,
            function ($query) {
                $query->whereIn($this->model->getKeyName(), $this->ids);
            }
        )->get();

        $rs = $rs->map(function ($res) use ($fields) {
            $arr = [];
            foreach ($fields as $val) {
                $arr[$val] = $res[$val];
            }

            return $arr;
        });

        $table = collect([$table->toArray()])->merge($rs);

        return $table;
    }
}
