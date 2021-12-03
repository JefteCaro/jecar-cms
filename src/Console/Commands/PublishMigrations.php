<?php

namespace Jecar\Cms\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class PublishMigrations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jecar:cms:migrations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publishes CMS migrations description';


    private $files;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->files = new Filesystem;
        $this->config = Config::get('jecar-cms', require($this->resourcePath('config/jecar-cms.php')));
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Publishing CMS Migrations');
        $this->publish();
    }

    public function resourcePath(string $res)
    {
        return __DIR__ . '../../../resources/' . $res;
    }

    public function publish()
    {
        $this->publishPage();
        $this->publishMediaFile();
    }

    public function publishPage()
    {
        $this->publishing('page');
        $this->buildContent('page', 'migrations/page.stub');
    }

    public function publishMediaFile()
    {
        $this->publishing('mediaFile');
        $this->buildContent('mediaFile', 'migrations/media_file.stub');
    }

    public function buildContent($name, $stubPath)
    {
        $stub = $this->getStub($stubPath);

        $replace = [
            'DummyMigrationClass' => $this->buildCreateClass($name),
            'DummyTableName' => $this->buildTableName($name)
        ];

        $output = str_replace(array_keys($replace), array_values($replace), $stub);

        $this->files->put($this->migrationFilePath($name), $output);
    }

    public function getPrefix(): string {

        return ($this->config['database']['table_prefix']) ?: '';
    }

    public function buildTableName(string $name)
    {
        return $this->getPrefix() . Str::plural(strtolower($name));
    }

    public function buildCreateClass(string $name)
    {
        return 'Create' . Str::plural(ucfirst($this->getPrefix() . $name)) . 'Table';
    }

    public function migrationFilePath(string $name)
    {
        return database_path('migrations/' . date('Y_m_d_His', time()) . '_' .  Str::snake($this->buildCreateClass($name))  . '.php');
    }

    public function getStub(string $path)
    {
        return $this->files->get($this->resourcePath($path));
    }

    public function publishing($name)
    {
        $this->info('Publishing '. ucfirst($name).' Migration');
    }
}
