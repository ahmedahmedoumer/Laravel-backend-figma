<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeService extends Command
{
    protected $signature = 'make:service {name}';

    protected $description = 'Create a new service class';

    public function handle()
    {
        $name = $this->argument('name');
        $path = app_path('Services/') . $name . '.php';

        if (file_exists($path)) {
            $this->error('Service already exists!');
            return;
        }

        $serviceTemplate = str_replace('{{name}}', $name, file_get_contents(__DIR__ . '/stubs/service.stub'));

        file_put_contents($path, $serviceTemplate);

        $this->info('Service created successfully!');
    }
}
