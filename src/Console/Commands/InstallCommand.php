<?php

declare(strict_types=1);

namespace Alessandronuunes\FilamentMember\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'filament-member:install';

    protected $description = 'Install the filament member package';

    public function handle(): int
    {
        $this->call('vendor:publish', [
            '--tag' => 'filament-member-config',
            '--force' => true,
        ]);

        $this->call('vendor:publish', [
            '--tag' => 'filament-member-migrations',
            '--force' => true,
        ]);

        $this->call('vendor:publish', [
            '--tag' => 'filament-member-translations',
            '--force' => true,
        ]);

        $this->info('Filament Member was installed successfully.');

        return self::SUCCESS;
    }
}
