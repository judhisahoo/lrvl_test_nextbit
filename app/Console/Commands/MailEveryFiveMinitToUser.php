<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Notifications\NotifyUserByEmail;

class MailEveryFiveMinitToUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:every5min';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail to client every 5 minits';

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
        $users=User::all();
        foreach ($users as $user) {
            $user->notify(new NotifyUserByEmail($user));
        }
    }
}
