<?php

namespace Backpack\PermissionManager\app\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class ExtendPermissionCrudRequest extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'backpack:extend:permission-crud-request';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backpack:extend:permission-crud-request {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a Backpack CRUD Permission request';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Request';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/../stubs/crud-request-permission.stub';
    }

    /**
     * Get the destination class path.
     *
     * @param string $name
     *
     * @return string
     */
    protected function getPath($name)
    {
        // Get relative path name
        $name = str_replace_first($this->laravel->getNamespace(), '', $name);
        $name = str_replace('\\', '/', $name);

        // Pull expected filename from path
        $name_array = explode('/', $name);
        $file = array_pop($name_array);
        // Replace with Extended version
        $name_array[] = /*'Extended'.*/$file;

        // Implode array to string
        $name = implode('/', $name_array);

        // Return new path
        return $this->laravel['path'].'/'.$name.'CrudRequest.php';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Requests';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [

        ];
    }
}
