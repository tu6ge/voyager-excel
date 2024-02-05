<?php

namespace themachinarium\MacherExcel\Actions;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;
use MCH\Macher\Actions\AbstractAction;
use themachinarium\MacherExcel\Exports\AbstractExport;
use themachinarium\MacherExcel\Exports\BaseExport;

class Export extends AbstractAction
{
    public function getTitle()
    {
        return __('macher_excel::excel.export_excel');
    }

    public function getIcon()
    {
        return 'macher-download';
    }

    public function shouldActionDisplayOnDataType()
    {
        if (empty($this->dataType->model_name)) {
            return false;
        }

        if (!class_exists($this->dataType->model_name)) {
            return false;
        }

        $model = new $this->dataType->model_name();
        if (!($model instanceof  Model)) {
            return false;
        }

        if ($model->disable_export) {
            return false;
        }

        return true;
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-primary',
        ];
    }

    public function getDefaultRoute()
    {
        return null;
    }

    public function massAction($ids, $comingFrom)
    {
        $model = new $this->dataType->model_name();

        if ($model->allow_export_all == false && empty(array_filter($ids))) {
            return $this->redirect();
        }

        $export = new BaseExport($this->dataType, $ids);

        if (isset($model->export_handler) && class_exists($model->export_handler)) {
            $export = new $model->export_handler($this->dataType, $ids);

            if (!($export instanceof AbstractExport)) {
                throw new \Exception(sprintf('the %s model export_handler is not instanceof themachinarium\MacherExcel\Exports\AbstractExport', get_class($model)));
            }
        }

        return Excel::download(
            $export,
            $this->getFileName()
        );
    }

    protected function getFileName()
    {
        return sprintf('%s_%s.xls', $this->dataType->display_name_plural, Carbon::now()->format('Y-m-d_H_i'));
    }

    protected function redirect()
    {
        return <<<'eot'
            <html>
                <body>
                    <script type="text/javascript">
                        window.history.go(-1)
                    </script>
                </body>
            </html>
        eot;
    }
}
