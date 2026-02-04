<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-admin {email} {--name=} {--password=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or update an admin user by email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $name = $this->option('name') ?: 'Admin';
        $password = $this->option('password');

        $user = User::where('email', $email)->first();

        if (!$user && !$password) {
            $this->error('Password is required when creating a new admin user.');
            return 1;
        }

        if (!$user) {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'is_admin' => true,
            ]);

            $this->info("Created admin user '{$user->email}'.");
            return 0;
        }

        $updates = ['is_admin' => true];

        if ($name) {
            $updates['name'] = $name;
        }

        if ($password) {
            $updates['password'] = $password;
        }

        $user->update($updates);

        $this->info("Updated admin user '{$user->email}'.");
        return 0;
    }
}
