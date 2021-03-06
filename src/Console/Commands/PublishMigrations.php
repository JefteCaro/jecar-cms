<?php

namespace Jecar\Cms\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Jecar\Core\Console\Commands\MigrationGenerator;

class PublishMigrations extends MigrationGenerator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jecar:migrations:cms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publishes CMS migrations description';

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

    public function publish()
    {
        $this->publishPage();
    }

    public function publishPage()
    {
        $this->publishing('page');
        $this->buildContent('page', 'migrations/page.stub');
    }
}
