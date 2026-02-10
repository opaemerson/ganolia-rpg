<?php

namespace App\Enum;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

enum ProfileEnum: string
{
    case SUPERADMIN = 'Superadmin';
    case ADMIN = 'Admin';
    case USUARIO = 'Usuário';

    public function id(bool $useCache = true): ?int
    {
        $cacheKey = 'profiles.id_by_name.' . mb_strtolower($this->value);

        if (!$useCache) {
            return Profile::query()->where('name', $this->value)->value('id');
        }

        return Cache::remember($cacheKey, now()->addHours(6), function () {
            return Profile::query()->where('name', $this->value)->value('id');
        });
    }

    public function isUser(User $user): bool
    {
        $profileName = (string) ($user->profile?->name ?? '');
        return strcasecmp($profileName, $this->value) === 0;
    }

    public static function fromUser(?User $user): ?self
    {
        if (!$user) {
            return null;
        }

        $profileName = (string) ($user->profile?->name ?? '');

        foreach (self::cases() as $case) {
            if (strcasecmp($profileName, $case->value) === 0) {
                return $case;
            }
        }

        return null;
    }
}

