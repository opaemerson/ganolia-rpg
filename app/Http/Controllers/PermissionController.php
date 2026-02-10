<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfilePermissionsRequest;
use App\Models\Functionality;
use App\Models\Module;
use App\Models\Profile;
use Illuminate\Http\JsonResponse;

class PermissionController
{
    public function index()
    {
        return view('permissions.index');
    }

    public function profiles(): JsonResponse
    {
        $profiles = Profile::orderBy('name')->whereNot('name', 'Superadmin')->get(['id', 'name']);

        return response()->json($profiles);
    }

    public function show(Profile $profile): JsonResponse
    {
        $modules = Module::query()
            ->where('is_active', true)
            ->with([
                'functionalities' => function ($q) {
                    $q->orderBy('order');
                }
            ])
            ->orderBy('order')
            ->get(['id', 'name', 'slug', 'order', 'is_active']);

        $moduleIds = $profile->modules()->pluck('modules.id')->values();
        $functionalityIds = $profile->functionalities()->pluck('functionalities.id')->values();

        return response()->json([
            'profile' => $profile->only(['id', 'name']),
            'modules' => $modules,
            'module_ids' => $moduleIds,
            'functionality_ids' => $functionalityIds,
        ]);
    }

    public function update(UpdateProfilePermissionsRequest $request, Profile $profile): JsonResponse
    {
        $moduleIds = $request->input('module_ids', []);
        $functionalityIds = $request->input('functionality_ids', []);

        $validFunctionalityIds = [];
        if (!empty($functionalityIds)) {
            $validFunctionalityIds = Functionality::query()
                ->when(!empty($moduleIds), function ($q) use ($moduleIds) {
                    $q->whereIn('module_id', $moduleIds);
                })
                ->whereIn('id', $functionalityIds)
                ->pluck('id')
                ->values()
                ->all();
        }

        if (empty($moduleIds) && !empty($validFunctionalityIds)) {
            $moduleIds = Functionality::query()
                ->whereIn('id', $validFunctionalityIds)
                ->pluck('module_id')
                ->unique()
                ->values()
                ->all();
        }

        $profile->modules()->sync($moduleIds);
        $profile->functionalities()->sync($validFunctionalityIds);

        return response()->json([
            'message' => 'Permissões atualizadas com sucesso.',
        ]);
    }
}
