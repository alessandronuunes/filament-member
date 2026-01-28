<div class="!w-full space-y-4">
    @php
        $tenantName = $isGenericInvite ? $tenant?->name : $invite?->tenant?->name;
        $roleName = $isGenericInvite
            ? __('filament-member::default.message.member')
            : $invite?->role?->getLabel() ?? __('filament-member::default.message.member');
    @endphp

    <div class="flex w-full items-center gap-4 rounded-lg bg-gray-50 p-4 dark:bg-white/5">
        <div
            class="bg-primary-600 flex h-12 w-12 shrink-0 items-center justify-center rounded-lg text-lg font-bold text-white">
            {{ substr($tenantName ?? 'O', 0, 1) }}
        </div>
        <div class="min-w-0 flex-1">
            <h3 class="font-semibold text-gray-950 dark:text-white">
                {{ $tenantName ?? __('filament-member::default.message.organization') }}
            </h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ __('filament-member::default.message.role_label') }}: {{ $roleName }}
            </p>
        </div>
    </div>

    @if (!$isGenericInvite && $invite?->email)
        <div class="rounded-lg bg-gray-50 p-3 dark:bg-white/5">
            <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                {{ __('filament-member::default.message.invite_sent_to') }}:
                <span class="font-medium text-gray-950 dark:text-white">{{ $invite->email }}</span>
            </p>
        </div>
    @endif

    <p class="text-center text-sm text-gray-500 dark:text-gray-400">
        {{ __('filament-member::default.message.to_accept_invite') }}
    </p>
</div>
