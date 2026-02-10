<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class PermissionService
{
    public static function findOrFailWithPermission(string $modelClass, int $id, string $column = 'id', $adminValue = 99): Model 
    {
        $model = $modelClass::findOrFail($id);
        $authUser = Auth::user();

        $idColumn = $model->{$column} ?? null;
        $isSelf = $authUser->id === $idColumn;
        $isAdmin = $authUser->license_id == $adminValue;

        if (!$isSelf && !$isAdmin) {
            abort(403, 'Você não tem permissão para acessar este recurso.');
        }

        return $model;
    }
}
