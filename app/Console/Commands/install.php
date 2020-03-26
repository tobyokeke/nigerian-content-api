<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:package {target}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installs different relevant things to a project.[idehelper,aws,passport]';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $target = $this->argument('target');
        switch ($target){

            case "whoops":
                exec("composer require filp/whoops");
                break;

            case "firebase":
                exec("composer require kreait/firebase-php ^4.41");
                break;

            case "idehelper":
                exec("composer require --dev barryvdh/laravel-ide-helper");
                break;

            case "aws":
                exec('composer require "league/flysystem-aws-s3-v3 ~1.0"');
                break;

            case "passport":
                exec('composer require laravel/passport');
                exec('php artisan migrate');
                exec('php artisan passport:install');
                break;
        }
    }
}
