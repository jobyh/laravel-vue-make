<?php

use Illuminate\Support\Facades\Artisan;
use Orchestra\Testbench\TestCase;
use Illuminate\Filesystem\Filesystem;
use Mockery\MockInterface;
use _77Gears_\ReactMake\Support\CommandsProvider;

class ReactComponentCommandTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [CommandsProvider::class];
    }

    public function test_it_requires_name_parameter()
    {
        $this->expectErrorMessage('missing: "name"');

        Artisan::call('react:component');
    }

    public function test_it_writes_to_components_directory()
    {

        $this->mock(Filesystem::class, function(MockInterface $mock) {
            $filepath = resource_path('js/components') . '/TestComponent.js';
            $mock->shouldReceive('put')->with($filepath, '');
        });

        Artisan::call('react:component', ['name' => 'TestComponent']);
    }
 }