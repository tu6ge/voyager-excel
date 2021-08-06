<?php

namespace Tu6ge\VoyagerExcel\Tests;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use TCG\Voyager\Models\Category;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Permission;

class GeneralTest extends TestCase
{
    public function setUp(): void
    {
        // $this->markTestSkipped(
        //     '临时跳过 General'
        //   );
        parent::setUp();

        Auth::loginUsingId(1);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        Schema::dropIfExists('categories');

        DataType::where('name', 'categories')->delete();
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

        $this->visitRoute('voyager.categories.index')
        ->see('Export Excel')
        ->see('<input type="hidden" name="action" value="Tu6ge\VoyagerExcel\Actions\Export">');
    }

    public function testExportPartRecord()
    {
        $this->initCategory();

        Excel::fake();

        Carbon::setTestNow('2021-08-05 12:34:00');

        $this->post(route('voyager.categories.action'), [
            'action' => 'Tu6ge\VoyagerExcel\Actions\Export',
            'ids'    => '1',
        ]);

        // $this->getResponse()->dumpHeaders();

        // $this->getResponse()->assertHeader('content-type', 'application/vnd.ms-excel');

        Excel::assertDownloaded('Categories_2021-08-05_12_34.xls', function ($content) {
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

    public function testExportEmptyRecord()
    {
        $this->initCategory();

        $this->post(route('voyager.categories.action'), [
            'action' => 'Tu6ge\VoyagerExcel\Actions\Export',
            'ids'    => '',
        ])->see('window.history.go(-1)');
    }

    private function createBreadForFormfield($type, $name, $options = '')
    {
        Schema::dropIfExists('categories');
        Schema::create('categories', function ($table) use ($type, $name) {
            $table->bigIncrements('id');
            $table->{$type}($name)->nullable();
            $table->timestamps();
        });

        // Delete old BREAD
        $this->delete(route('voyager.bread.delete', ['id' => DataType::where('name', 'categories')->first()->id]));

        // Create BREAD
        $this->visitRoute('voyager.bread.create', ['table' => 'categories'])
        ->select($name, 'field_input_type_'.$name)
        ->type($options, 'field_details_'.$name)
        ->type('TCG\\Voyager\\Models\\Category', 'model_name')
        ->press(__('voyager::generic.submit'))
        ->seeRouteIs('voyager.bread.index');

        // Attach permissions to role
        Auth::user()->role->permissions()->syncWithoutDetaching(Permission::all()->pluck('id'));

        Category::insert([
            'text_area' => 'bar',
        ]);

        Category::insert([
            'text_area' => 'foo',
        ]);
    }
}
