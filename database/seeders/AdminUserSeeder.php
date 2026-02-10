<?php

namespace Database\Seeders;

use App\Enum\ProfileEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        DB::transaction(function () use ($now) {

            $profileId = ProfileEnum::ADMIN->id();

            $email = env('ADMIN_DEFAULT_EMAIL', 'admin@admin.com');

            $userId = DB::table('users')->where('email', $email)->value('id');

            if ($userId) {
                DB::table('users')->where('id', $userId)->update([
                    'login' => 'admin',
                    'password' => Hash::make(env('ADMIN_DEFAULT_PASSWORD', '123123')),
                    'profile_id' => $profileId,
                    'updated_at' => $now,
                ]);
            } else {
                DB::table('users')->insert([
                    'login' => 'admin',
                    'email' => $email,
                    'password' => Hash::make(env('ADMIN_DEFAULT_PASSWORD', '123123')),
                    'profile_id' => $profileId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            $moduleIds = DB::table('modules')->pluck('id')->toArray();
            DB::table('profiles_modules')->where('profile_id', $profileId)->delete();

            $profilesModulesInserts = [];
            foreach ($moduleIds as $moduleId) {
                $profilesModulesInserts[] = [
                    'profile_id' => $profileId,
                    'module_id' => $moduleId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            if (!empty($profilesModulesInserts)) {
                DB::table('profiles_modules')->insert($profilesModulesInserts);
            }

            $functionalityIds = DB::table('functionalities')->pluck('id')->toArray();

            DB::table('profile_functionalities')->where('profile_id', $profileId)->delete();

            $profileFunctionalitiesInserts = [];
            foreach ($functionalityIds as $funcId) {
                $profileFunctionalitiesInserts[] = [
                    'profile_id' => $profileId,
                    'functionality_id' => $funcId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            if (!empty($profileFunctionalitiesInserts)) {
                DB::table('profile_functionalities')->insert($profileFunctionalitiesInserts);
            }
        });
    }
}
