<?php

namespace Database\Seeders;

use App\Enum\ProfileEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperadminUserSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::transaction(function () use ($now) {
            $profileId = ProfileEnum::SUPERADMIN->id();
            $email = env('SUPERADMIN_DEFAULT_EMAIL', 'superadmin@admin.com');

            $userId = DB::table('users')->where('email', $email)->value('id');

            if ($userId) {
                DB::table('users')->where('id', $userId)->update([
                    'login' => 'superadmin',
                    'password' => Hash::make(env('SUPERADMIN_DEFAULT_PASSWORD', '123123')),
                    'profile_id' => $profileId,
                    'updated_at' => $now,
                ]);
                return;
            }

            DB::table('users')->insert([
                'login' => 'superadmin',
                'email' => $email,
                'password' => Hash::make(env('SUPERADMIN_DEFAULT_PASSWORD', '123123')),
                'profile_id' => $profileId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        });
    }
}
