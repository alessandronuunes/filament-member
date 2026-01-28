<?php

declare(strict_types=1);

namespace AlessandroNuunes\FilamentMember\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum TenantRole: string implements HasColor, HasLabel
{
    case Owner = 'owner';
    case Admin = 'admin';
    case Member = 'member';

    public function getLabel(): string
    {
        return match ($this) {
            self::Owner => __('filament-member::default.enum.role.owner'),
            self::Admin => __('filament-member::default.enum.role.admin'),
            self::Member => __('filament-member::default.enum.role.member'),
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Owner => 'danger',
            self::Admin => 'warning',
            self::Member => 'success',
        };
    }
}
