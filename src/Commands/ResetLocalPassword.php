<?php
namespace Zekini\Generics\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class ResetLocalPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'local:password-reset 
                                {--password= : Give a default password value to reset to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'resets the password when in local environment';

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
        
        // check the environment the app is running
        $appEnv = app()->environment();
        dump($appEnv);
        if (($appEnv != "local") && ($appEnv != "testing")) {
            $this->error(" Your application has to be in the local environment before you can reset");
            return Command::SUCCESS;
        }

        // Check users table exist
        if (! Schema::hasTable('users')) {
            $this->error(" Users table does not exists in the database");
            return Command::SUCCESS;
        }
        $faker  = \Faker\Factory::create();
        $password = $this->option('password') ?? $faker->word;

        if (! Schema::hasColumn('users', 'password')) {
            $this->error("password does not exists as a database table column");
            return Command::SUCCESS;
        }
        
        // Start Reset Password
        DB::table('users')->update(['password'=> Hash::make($password)]);

        $this->info("Success : All local passwords changed to $password");
        
        return Command::SUCCESS;
    }
}
