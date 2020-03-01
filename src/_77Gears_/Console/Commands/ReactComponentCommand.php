<?php

namespace _77Gears_\ReactMake\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ReactComponentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'react:component {name} {--x|jsx} {--d|dir=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new React component';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    protected function getPath(string $name) : string
    {
        $subDir = $this->option('dir') ? "{$this->option('dir')}/" : '';
        return base_path("/resources/js/components/{$subDir}{$name}.{$this->getExtension()}");
    }

    protected function getExtension() : string {
        return $this->option('jsx') ? 'jsx' : 'js';
    }

    protected function getStub() : string
    {
        return realpath(__DIR__ . '/../../../stubs/react.stub');
    }

    protected function makeDirectory(string $path) : string
    {
        if (! $this->files->isDirectory(dirname($path))) {
            return $this->files->makeDirectory(dirname($path), 0777, true, true);
        }

        return $path;
    }

    protected function buildComponent(string $name) : string
    {
        $stub = $this->files->get($this->getStub()) ;

        return str_replace('DummyComponent', $name, $stub);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        $path = $this->getPath($name);

        if ($this->files->exists($path) && ! $this->confirm("Overwrite existing component {$name}?")) {
            return;
        }

        $this->makeDirectory($path);
        $this->files->put($this->getPath($name), $this->buildComponent($name));
        $this->info($name . ' created successfully');
    }
}
