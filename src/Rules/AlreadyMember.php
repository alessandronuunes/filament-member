<?php

declare(strict_types=1);

namespace AlessandroNuunes\FilamentMember\Rules;

use Closure;
use AlessandroNuunes\FilamentMember\Support\ConfigHelper;
use Filament\Facades\Filament;
use Illuminate\Contracts\Validation\ValidationRule;

class AlreadyMember implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $tenant = Filament::getTenant();

        if (! $tenant) {
            return;
        }

        $userModel = ConfigHelper::getUserModel();
        $user = $userModel::where('email', $value)->first();

        if (! $user) {
            return;
        }

        $isMember = $tenant->users()
            ->where('users.id', $user->id)
            ->exists();

        if ($isMember) {
            $fail(__('filament-member::default.validation.already_member'));
        }
    }
}
