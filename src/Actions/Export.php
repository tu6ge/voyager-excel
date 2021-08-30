<?php

namespace Tu6ge\VoyagerExcel\Actions;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;
use TCG\Voyager\Actions\AbstractAction;
use Tu6ge\VoyagerExcel\Exports\AbstractExport;
use Tu6ge\VoyagerExcel\Exports\BaseExport;

class Export extends AbstractAction
{
    public function getTitle()
    {
        return __('voyager_excel::excel.export_excel');
    }

    public function getIcon()
    {
        return 'voyager-download';
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
                throw new \Exception(sprintf('the %s model export_handler is not instanceof Tu6ge\VoyagerExcel\Exports\AbstractExport', get_class($model)));
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
