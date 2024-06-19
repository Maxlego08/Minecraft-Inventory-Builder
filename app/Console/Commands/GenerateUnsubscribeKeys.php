<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\UserLog;
use App\Models\UserRole;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateUnsubscribeKeys extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-unsubscribe-keys';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate unsubscribe keys for users who do not have one';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public static function handle()
    {
        $users = User::whereNull('unsubscribe_key')->get();

        foreach ($users as $user) {
            $user->unsubscribe_key = Str::random(64);
            $user->save();
        }
        $this->info('Unsubscribe keys generated successfully');
        //
        return 0;
    }
}
