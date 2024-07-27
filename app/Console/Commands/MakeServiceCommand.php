<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $servicePath = $this->getServicePath($name);

        if (File::exists($servicePath)) {
            $this->error("Service {$name} already exists!");
            return;
        }

        $this->makeDirectory(dirname($servicePath));

        $stubContent = File::get(base_path('stubs/service.stub'));
        $content = $this->replaceNamespace($stubContent, $name);

        File::put($servicePath, $content);

        $this->info("Service {$name} created successfully!");
    }

    protected function getServicePath($name)
    {
        return app_path('Services/' . str_replace('\\', '/', $name) . '.php');
    }

    protected function makeDirectory($path)
    {
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
    }

    protected function replaceNamespace($stub, $name)
    {
        $name = str_replace('/', '\\', $name);
        $namespace = 'App\\Services\\' . dirname(str_replace('\\', '/', $name));
        $class = basename($name);

        $stub = str_replace('{{ namespace }}', $namespace, $stub);
        return str_replace('{{ class }}', $class, $stub);
    }
}
