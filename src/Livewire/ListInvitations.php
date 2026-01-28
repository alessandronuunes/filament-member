<?php

declare(strict_types=1);

namespace AlessandroNuunes\FilamentMember\Livewire;

use AlessandroNuunes\FilamentMember\Events\TenantInviteCreated;
use AlessandroNuunes\FilamentMember\Support\ConfigHelper;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\TableComponent;
use Illuminate\Contracts\View\View;

class ListInvitations extends TableComponent
{
    public function table(Table $table): Table
    {
        $tenant = Filament::getTenant();
        $inviteModel = ConfigHelper::getTenantInviteModel();

        return $table
            ->query(
                $inviteModel::query()
                    ->where('tenant_id', $tenant?->id)
                    ->whereNull('accepted_at')
                    ->where('expires_at', '>', now())
            )
            ->poll('2s')
            ->columns([
                TextColumn::make('email')
                    ->label(__('filament-member::default.column.email'))
                    ->searchable(),
                TextColumn::make('role')
                    ->label(__('filament-member::default.column.role'))
                    ->badge()
                    ->formatStateUsing(function ($state) {
                        $enumClass = ConfigHelper::getTenantRoleEnum();
                        if (! enum_exists($enumClass) || ! $state instanceof $enumClass) {
                            return $state?->value ?? $state ?? '-';
                        }

                        return method_exists($state, 'getLabel') ? $state->getLabel() : $state->value;
                    })
                    ->color(function ($state) {
                        $enumClass = ConfigHelper::getTenantRoleEnum();
                        if (! enum_exists($enumClass) || ! $state instanceof $enumClass) {
                            return 'gray';
                        }

                        return method_exists($state, 'getColor') ? $state->getColor() : 'gray';
                    }),
                TextColumn::make('user.name')
                    ->label(__('filament-member::default.column.invited_by'))
                    ->placeholder('-'),
                TextColumn::make('expires_at')
                    ->label(__('filament-member::default.column.expires_at'))
                    ->dateTime('d/m/Y H:i'),
            ])
            ->actions([
                Action::make('resend')
                    ->icon('heroicon-o-paper-airplane')
                    ->label(__('filament-member::default.action.resend'))
                    ->requiresConfirmation()
                    ->modalHeading(__('filament-member::default.action.resend_invite'))
                    ->modalDescription(fn ($record): string|array|null => __('filament-member::default.message.resend_invite_confirm', ['email' => $record->email]))
                    ->action(function ($record): void {
                        $record->update([
                            'expires_at' => now()->addDays(ConfigHelper::getInviteConfig('expiration_days', 7)),
                        ]);

                        event(new TenantInviteCreated($record));

                        Notification::make()
                            ->title(__('filament-member::default.notification.invite_resent'))
                            ->body(__('filament-member::default.notification.invite_resent_body', ['email' => $record->email]))
                            ->success()
                            ->send();
                    }),
                ActionGroup::make([
                    DeleteAction::make()
                        ->label(__('filament-member::default.action.cancel_invite')),
                ]),
            ]);
    }

    public function render(): View
    {
        return view('filament-member::livewire.list-invitations');
    }
}
