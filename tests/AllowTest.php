<?php

namespace Tu6ge\VoyagerExcel\Tests;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Permission;
use Tu6ge\VoyagerExcel\Tests\Models\CategoryAllow;

class AllowTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Auth::loginUsingId(1);
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function initCategory()
    {
        $this->createBreadForFormfield('text', 'text_area', json_encode([
            'default' => 'Default Text',
        ]));
    }

    public function testShowExportButton()
    {
        $this->initCategory();

        $this->visitRoute('voyager.categoryallows.index')
        ->see('Export Excel')
        ->see('<input type="hidden" name="action" value="Tu6ge\VoyagerExcel\Actions\Export">');
    }

    public function testExportPartRecord()
    {
        $this->initCategory();

        Excel::fake();

        Carbon::setTestNow('2021-08-05 12:34:00');

        $this->post(route('voyager.categoryallows.action'), [
            'action' => 'Tu6ge\VoyagerExcel\Actions\Export',
            'ids'    => '1'
        ]);

        // $this->getResponse()->dumpHeaders();

        // $this->getResponse()->assertHeader('content-type', 'application/vnd.ms-excel');

        Excel::assertDownloaded('Categoryallows_2021-08-05_12_34.xls', function ($content) {
            $collection = $content->collection();
            if ($collection[0][0] != 'Text Area') {
                return false;
            }

            if ($collection[1]['text_area'] != 'bar') {
                return false;
            }

            return true;
        });
    }

    public function testExportAllRecord()
    {
        $this->initCategory();

        Excel::fake();

        Carbon::setTestNow('2021-08-05 12:34:00');

        $this->post(route('voyager.categoryallows.action'), [
            'action' => 'Tu6ge\VoyagerExcel\Actions\Export',
            'ids'    => ''
        ]);

        Excel::assertDownloaded('Categoryallows_2021-08-05_12_34.xls', function ($content) {
            $collection = $content->collection();
            if ($collection[0][0] != 'Text Area') {
                return false;
            }

            if ($collection[1]['text_area'] != 'bar') {
                return false;
            }

            if ($collection->count() != 3) {
                return false;
            }

            return true;
        });
    }

    private function createBreadForFormfield($type, $name, $options = '')
    {
        Schema::dropIfExists('categoryallows');

        Schema::create('categoryallows', function ($table) use ($type, $name) {
            $table->bigIncrements('id');
            $table->{$type}($name)->nullable();
            $table->timestamps();
        });

        $categoryallows = DataType::where('name', 'categoryallows')->first();
        if ($categoryallows) {
            $this->delete(route('voyager.bread.delete', ['id' => $categoryallows->id]));
        }
        // Create BREAD
        // dd($this->visitRoute('voyager.bread.create', ['table' => 'categories']));
        $this->visitRoute('voyager.bread.create', ['table' => 'categoryallows'])
        ->select($name, 'field_input_type_'.$name)
        ->type($options, 'field_details_'.$name)
        ->type('Tu6ge\\VoyagerExcel\\Tests\\Models\\CategoryAllow', 'model_name')
        //->type('Tu6ge\\VoyagerExcel\\Tests\\DemoPolicy', 'policy_name')
        ->press(__('voyager::generic.submit'))
        ->seeRouteIs('voyager.bread.index');

        //dd(DataType::where('name', 'categoryallows')->first());

        // Attach permissions to role
        Auth::user()->role->permissions()->syncWithoutDetaching(Permission::all()->pluck('id'));

        CategoryAllow::insert([
            'text_area' => 'bar',
        ]);

        CategoryAllow::insert([
            'text_area' => 'foo',
        ]);
    }
}
