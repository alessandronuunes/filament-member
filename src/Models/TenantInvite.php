<?php

declare(strict_types=1);

namespace AlessandroNuunes\FilamentMember\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use AlessandroNuunes\FilamentMember\Support\ConfigHelper;

class TenantInvite extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tenant_id',
        'user_id',
        'email',
        'token',
        'role',
        'expires_at',
        'accepted_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'tenant_id' => 'integer',
            'user_id' => 'integer',
            'role' => ConfigHelper::getTenantRoleEnum(),
            'expires_at' => 'timestamp',
            'accepted_at' => 'timestamp',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(ConfigHelper::getTenantModel());
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(ConfigHelper::getUserModel());
    }
}
