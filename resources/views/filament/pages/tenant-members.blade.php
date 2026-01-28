<x-filament-panels::page>
    <form wire:submit="create">
        {{ $this->form }}
    </form>

    <div class="flex flex-col gap-y-6">
        <x-filament::tabs>
            <x-filament::tabs.item :active="$activeTab === 'members'" wire:click="$set('activeTab', 'members')" icon="heroicon-m-users">
                {{ __('filament-member::default.tab.members') }}
            </x-filament::tabs.item>

            <x-filament::tabs.item :active="$activeTab === 'pending-invitations'" wire:click="$set('activeTab', 'pending-invitations')"
                icon="heroicon-m-envelope">
                {{ __('filament-member::default.tab.pending_invitations') }}

                @if (
                    $pendingCount = \AlessandroNuunes\FilamentMember\Models\TenantInvite::where(
                        'tenant_id',
                        \Filament\Facades\Filament::getTenant()?->id)->whereNull('accepted_at')->count())
                    <x-slot name="badge">
                        {{ $pendingCount }}
                    </x-slot>
                @endif
            </x-filament::tabs.item>
        </x-filament::tabs>

        @if ($activeTab === 'members')
            @livewire('tenant.list-members')
        @else
            @livewire('tenant.list-invitations')
        @endif
    </div>

    @script
        <script>
            $wire.on('copy-to-clipboard', ({
                text
            }) => {
                navigator.clipboard.writeText(text).catch(err => {
                    console.error('Failed to copy:', err);
                });
            });
        </script>
    @endscript
</x-filament-panels::page>
