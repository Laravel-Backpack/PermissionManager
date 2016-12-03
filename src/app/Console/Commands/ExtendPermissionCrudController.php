<?php

namespace Backpack\PermissionManager\app\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class ExtendPermissionCrudController extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'backpack:extend:permission-crud-controller';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backpack:extend:permission-crud-controller {name} {--user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a Backpack CRUD Permission controller';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';

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
        return $this->laravel['path'].'/'.$name.'CrudController.php';
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('user')) {
            return __DIR__.'/../stubs/crud-controller-user.stub';
        }
        return __DIR__.'/../stubs/crud-controller-permission.stub';
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
        return $rootNamespace.'\Http\Controllers\Admin';
    }

    /**
     * Replace the table name for the given stub.
     *
     * @param string $stub
     * @param string $name
     *
     * @return string
     */
    protected function replaceNameStrings(&$stub, $name)
    {
        $table = ltrim(strtolower(preg_replace('/[A-Z]/', '_$0', str_replace($this->getNamespace($name).'\\', '', $name))), '_').'s';

        $stub = str_replace('DummyTable', $table, $stub);
        $stub = str_replace('dummy_class', strtolower(str_replace($this->getNamespace($name).'\\', '', $name)), $stub);

        return $this;
    }

    /**
     * Build the class with the given name.
     *
     * @param string $name
     *
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)->replaceNameStrings($stub, $name)->replaceClass($stub, /*'Extended'.*/$name);
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
