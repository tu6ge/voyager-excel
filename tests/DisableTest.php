<?php

namespace Tu6ge\VoyagerExcel\Tests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Permission;
use Tu6ge\VoyagerExcel\Tests\Models\CategoryDisable;

class DisableTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Auth::loginUsingId(1);
    }

    protected function tearDown(): void
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

        $this->visitRoute('voyager.categorydisables.index')
        ->dontsee('Export Excel')
        ->dontsee('<input type="hidden" name="action" value="Tu6ge\VoyagerExcel\Actions\Export">');
    }

    private function createBreadForFormfield($type, $name, $options = '')
    {
        Schema::dropIfExists('categorydisables');

        Schema::create('categorydisables', function ($table) use ($type, $name) {
            $table->bigIncrements('id');
            $table->{$type}($name)->nullable();
            $table->timestamps();
        });

        $categorydisables = DataType::where('name', 'categorydisables')->first();
        if ($categorydisables) {
            $this->delete(route('voyager.bread.delete', ['id' => $categorydisables->id]));
        }
        // Create BREAD
        $this->visitRoute('voyager.bread.create', ['table' => 'categorydisables'])
        ->select($name, 'field_input_type_'.$name)
        ->type($options, 'field_details_'.$name)
        ->type('Tu6ge\\VoyagerExcel\\Tests\\Models\\CategoryDisable', 'model_name')
        //->type('Tu6ge\\VoyagerExcel\\Tests\\DemoPolicy', 'policy_name')
        ->press(__('voyager::generic.submit'))
        ->seeRouteIs('voyager.bread.index');

        // Attach permissions to role
        Auth::user()->role->permissions()->syncWithoutDetaching(Permission::all()->pluck('id'));

        CategoryDisable::insert([
            'text_area' => 'bar',
        ]);

        CategoryDisable::insert([
            'text_area' => 'foo',
        ]);
    }
}
