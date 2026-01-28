<?php

declare(strict_types=1);

namespace AlessandroNuunes\FilamentMember\Events;

use AlessandroNuunes\FilamentMember\Models\TenantInvite;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TenantInviteCreated
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        public TenantInvite $invite
    ) {
    }
}
