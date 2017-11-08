<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Permission;

class PermissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new permission';

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
        $name = $this->ask('Permission name');
        $display_name = $this->ask('Permission Display Name');
        $description = $this->ask('Permission Description');
        Permission::insert([
            'name' => $name,
            'display_name' => $display_name,
            'description' => $description
        ]);
        $this->info('Permission created successfully');
    }
}
