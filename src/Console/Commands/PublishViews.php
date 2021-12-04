<?php

namespace Jecar\Cms\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;
use Jecar\Core\Console\Commands\MigrationGenerator;

class PublishViews extends MigrationGenerator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'jecar:views:cms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publishes CMS migrations';


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
        $this->config = Config::get('jecar', require($this->resourcePath('config/jecar.php')));
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        dd($this->argument('name'));
    }

    public function publish()
    {
        $this->publishPage();
    }

    public function publishPage()
    {

    }
}
