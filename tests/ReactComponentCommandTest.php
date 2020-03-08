<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Orchestra\Testbench\TestCase;
use Illuminate\Filesystem\Filesystem;
use Mockery\MockInterface;
use _77Gears_\ReactMake\Support\CommandsProvider;

class ReactComponentCommandTest extends TestCase {

    protected function getPackageProviders($app)
    {
        return [CommandsProvider::class];
    }


    public function test_it_requires_name_parameter()
    {
        $this->expectErrorMessage('missing: "name"');

        Artisan::call('react:component');
    }

    public function test_it_checks_if_component_already_exists()
    {

        $this->mock(Filesystem::class, function(MockInterface $mock) {
            $filepath = resource_path('js/components/TestComponent.js');

            // Stubs.
            $mock->allows([
                'isDirectory' => true,
                'get' => 'template content',
                'put' => 23,
            ]);
            $mock->shouldReceive('exists')
                ->with($filepath)
                ->once()
                ->andReturn(false);
        });

        $result = Artisan::call('react:component', ['name' => 'TestComponent']);
        $this->assertSame(0, $result);
    }

    public function test_it_creates_directories()
    {
        $this->mock(Filesystem::class, function(MockInterface $mock) {

            // Stubs.
            $mock->allows([
                'exists' => false,
                'isDirectory' => false,
                'get' => 'template content',
                'put' => 23,
            ]);

            $dirpath = App::resourcePath('js/components/foo/bar');

            $mock->shouldReceive('makeDirectory')
                ->withArgs([$dirpath, 0777, true, true])
                ->once()
                ->andReturn(true);
        });

        $result = Artisan::call('react:component', ['name' => 'TestComponent', '--dir' => 'foo/bar']);
        $this->assertSame(0, $result);
    }

    public function test_it_writes_component()
    {
        $this->mock(Filesystem::class, function(MockInterface $mock) {
            // Stubs.
            $mock->allows([
                'exists' => false,
                'isDirectory' => true,
                'get' => 'template content',
            ]);

            $mock->shouldReceive('put')
                ->withArgs([App::resourcePath('js/components/TestComponent.js'), 'template content'])
                ->once();
        });

        $result = Artisan::call('react:component', ['name' => 'TestComponent']);
        $this->assertSame(0, $result);
    }

    public function test_it_uses_jsx_extension()
    {
        $this->mock(Filesystem::class, function(MockInterface $mock) {
            // Stubs.
            $mock->allows([
                'exists' => false,
                'isDirectory' => true,
                'get' => 'template content',
            ]);

            $mock->shouldReceive('put')
                ->withArgs([App::resourcePath('js/components/TestComponent.jsx'), 'template content'])
                ->once();
        });

        $result = Artisan::call('react:component', ['name' => 'TestComponent', '--jsx' => true]);
        $this->assertSame(0, $result);
    }

 }