<?php

namespace themachinarium\MacherExcel\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class BaseExport extends AbstractExport implements FromCollection
{
    protected $dataType;
    protected $model;
    protected $ids;

    public function __construct($dataType, array $ids)
    {
        $this->dataType = $dataType;
        $this->model = new $dataType->model_name();
        $this->ids = array_filter($ids);
    }

    public function collection()
    {
        $fields = $this->dataType->browseRows;

        $rs = $this->model->when(
            count($this->ids) > 0,
            function ($query) {
                $query->whereIn($this->model->getKeyName(), $this->ids);
            }
        )->get();

        $langTopColumn = [];
        $rs = $rs->map(function ($res) use ($fields, &$langTopColumn) {
            $arr = [];
            foreach ($fields as $row) {
                $options = $row->details;

                if ($row->type == 'relationship') {
                    if ($options->type == 'belongsTo') {
                        $model = app($options->model);
                        $query = $model::where($options->key, $res->{$options->column})->first();
                        $arr[$row->field] = $query->{$options->label} ?? null;
                    } elseif ($options->type == 'belongsToMany') {
                        $model = app($options->model);
                        $selected_values = $res->belongsToMany($options->model, $options->pivot_table, $options->foreign_pivot_key ?? null, $options->related_pivot_key ?? null, $options->parent_key ?? null, $options->key)->get()->map(function ($item, $key) use ($options) {
                            return $item->{$options->label};
                        })->all();
                        $arr[$row->field] = implode(',', $selected_values);
                    }
                } elseif ($row->type == 'text') {
                    $arr[$row->field] = $res[$row->field] ?? '';
                    if (is_field_translatable(app($this->dataType->model_name), $row)) {
                        $langs = json_decode(get_field_translations($res, $row->field), 1);
                        foreach ($langs as $k => $lang) {
                            $arr[$row->field . $k] = $lang ?? '';
                            if (empty($langTopColumn[$row->field][$k])) {
                                $langTopColumn[$row->field][$k] = $row->display_name . ' ' . $k;
                            }
                        }
                    }
                } else {
                    $arr[$row->field] = $res[$row->field] ?? '';
                }
            }

            return $arr;
        });
        foreach ($fields as $row) {
            $topColumn[$row->field] = $row->display_name;
            if (!empty($langTopColumn[$row->field])) {
                foreach ($langTopColumn[$row->field] as $key => $lang) {
                    $topColumn[$row->field . '_' . $key] = $row->display_name . ' ' . $key;
                }
            }
        }

        $table = collect([$topColumn])->merge($rs);

        return $table ?? '';
    }
}
