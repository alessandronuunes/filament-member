<?php

declare(strict_types=1);

namespace AlessandroNuunes\FilamentMember;

use AlessandroNuunes\FilamentMember\Console\Commands\InstallCommand;
use AlessandroNuunes\FilamentMember\Events\TenantInviteCreated;
use AlessandroNuunes\FilamentMember\Listeners\SendTenantInviteNotification;
use Illuminate\Support\Facades\Event;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentMemberServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-member';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasConfigFile()
            ->hasTranslations()
            ->hasViews()
            ->hasCommands([
                InstallCommand::class,
            ])
            ->hasMigrations([
                'create_tenants_table',
                'create_tenant_user_table',
                'create_tenant_invites_table',
            ]);
    }

    public function packageBooted(): void
    {
        Event::listen(
            TenantInviteCreated::class,
            SendTenantInviteNotification::class
        );
    }
}
