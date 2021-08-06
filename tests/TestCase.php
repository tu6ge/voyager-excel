<?php

namespace Tu6ge\VoyagerExcel\Tests;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Maatwebsite\Excel\ExcelServiceProvider;
use Orchestra\Testbench\BrowserKit\TestCase as OrchestraTestCase;
use Tu6ge\VoyagerExcel\VoyagerExcelServiceProvider;
use TCG\Voyager\Models\User;
use TCG\Voyager\VoyagerServiceProvider;

class TestCase extends OrchestraTestCase
{
    protected $withDummy = true;

    public function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations();

        if (!is_dir(base_path('routes'))) {
            mkdir(base_path('routes'));
        }

        if (!file_exists(base_path('routes/web.php'))) {
            file_put_contents(
                base_path('routes/web.php'),
                "<?php Route::get('/', function () {return view('welcome');});"
            );
        }

        $this->app->make('Illuminate\Contracts\Http\Kernel')->pushMiddleware('Illuminate\Session\Middleware\StartSession');
        $this->app->make('Illuminate\Contracts\Http\Kernel')->pushMiddleware('Illuminate\View\Middleware\ShareErrorsFromSession');

        $this->install();
    }

    protected function getPackageProviders($app)
    {
        return [
            ExcelServiceProvider::class,
            VoyagerExcelServiceProvider::class,
            VoyagerServiceProvider::class,
        ];
    }

    public function tearDown(): void
    {
        //parent::tearDown();

        //$this->artisan('migrate:reset');
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        // Setup Voyager configuration
        $app['config']->set('voyager.user.namespace', User::class);

        // Setup Authentication configuration
        $app['config']->set('auth.providers.users.model', User::class);
    }

    protected function install()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $this->artisan('voyager:install', ['--with-dummy' => $this->withDummy]);

        $this->seedVoyager("CategoriesAllowTableSeeder");
        $this->seedVoyager("CategoriesDisableTableSeeder");

        app(VoyagerServiceProvider::class, ['app' => $this->app])->loadAuth();

        if (file_exists(base_path('routes/web.php'))) {
            require base_path('routes/web.php');
        }
    }

    protected function seedVoyager($class)
    {
        if (!class_exists($class)) {
            require_once __DIR__.'/database/seeders/'.$class.'.php';
        }

        with(new $class())->run();
    }

    public function disableExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, new DisabledTestException());
    }

    /**
     * Visit the given URI with a GET request.
     *
     * @param string $uri
     *
     * @return $this
     */
    public function visit($uri)
    {
        if (is_callable('parent::visit')) {
            return parent::visit($uri);
        }

        return $this->get($uri);
    }

    /**
     * Assert that a given string is seen on the current HTML.
     *
     * @param string $text
     * @param bool   $negate
     *
     * @return $this
     */
    public function see($text, $negate = false)
    {
        if (is_callable('parent::see')) {
            return parent::see($text);
        }

        if ($negate) {
            return $this->assertDontSee($text);
        }

        return $this->assertSee($text);
    }

    protected function getResponse()
    {
        return $this->response;
    }
}
