<?php

namespace App\Console\Commands;

use Swoole\Server;
use Illuminate\Console\Command;

class SwooleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swoole:serve {action} {--daemonize}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'swoole serve start or stop';

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
     * @return int
     */
    public function handle()
    {
        global $argv;
        $action = $this->argument('action');
        if (!in_array($action, ['start', 'stop'])) {
            $this->error('Error Arguments');
            exit;
        }
        $argv[0] = 'swoole:serve';
        $argv[1] = $action;
        $argv[2] = $this->option('daemonize') ? '-d' : '';


        $server = new \swoole_server ('127.0.0.1', 9505);
        $server->set([
                'worker_num' => 4,
                'daemonize' => true,
                'backlog' => 128,
            ]
        );
        $server->on('start', function () {
            echo "Swoole http server is started at http://127.0.0.1:9501\n";
        });
        $server->on('Receive', function () {
            echo "Swoole http server is Receive at http://127.0.0.1:9501\n";
        });
        $server->on('Close', function () {
            echo "Swoole http server is Close at http://127.0.0.1:9501\n";
        });
        $server->start();
    }
}
