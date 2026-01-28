<?php

declare(strict_types=1);

namespace AlessandroNuunes\FilamentMember;

use AlessandroNuunes\FilamentMember\Support\ConfigHelper;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Illuminate\Support\Facades\Route;

class MemberPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-member';
    }

    public function register(Panel $panel): void
    {
        $tenantMembersPage = ConfigHelper::getView('pages', 'tenant_members');
        $acceptInvitePage = ConfigHelper::getView('pages', 'accept_invite');

        $panel->pages([
            $tenantMembersPage,
        ])
            ->routes(function () use ($acceptInvitePage): void {
                $path = ConfigHelper::getRoute('invite_accept_path');
                $name = ConfigHelper::getRoute('invite_accept_name');
                $middleware = ConfigHelper::getRoute('invite_accept_middleware');

                Route::get($path, $acceptInvitePage)
                    ->middleware($middleware)
                    ->name($name);
            });
    }

    public function boot(Panel $panel): void
    {
    }

    public static function make(): self
    {
        return new self();
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(resolve(static::class)->getId());

        return $plugin;
    }
}
