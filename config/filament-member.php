<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    */
    'models' => [
        'user' => App\Models\User::class,
        'tenant' => AlessandroNuunes\FilamentMember\Models\Tenant::class,
        'tenant_invite' => AlessandroNuunes\FilamentMember\Models\TenantInvite::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Enums
    |--------------------------------------------------------------------------
    */

    'enums' => [
        'tenant_role' => AlessandroNuunes\FilamentMember\Enums\TenantRole::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Database Tables
    |--------------------------------------------------------------------------    |
    */
    'tables' => [
        'tenants' => 'tenants',
        'tenant_user' => 'tenant_user',
        'tenant_invites' => 'tenant_invites',
    ],

    /*
    |--------------------------------------------------------------------------
    | Relationship Columns
    |--------------------------------------------------------------------------
    */

    'relationships' => [
        'tenant_foreign_key' => 'tenant_id',
        'tenant_user_role_column' => 'role',
        'tenant_foreign_key_column' => 'tenant_id',
        'tenant_owner_column' => 'owner_id',
    ],

    // ============================================
    // FILAMENT TENANCY (Reseller: slug, owner())
    // ============================================
    'tenancy' => [
        'slug_attribute' => 'slug',
        'ownership_relationship' => 'user',
        'route_prefix' => 'tenant',
    ],

    // ============================================
    // ROUTES
    // ============================================
    'routes' => [
        'invite_accept_path' => '/invite/{token}/accept',
        'invite_accept_name' => 'invite.accept',
        'invite_accept_middleware' => ['signed'],
    ],

    // ============================================
    // VIEWS E TEMPLATES
    // ============================================
    'views' => [
        'mail' => [
            'tenant_invitation' => 'filament-member::mail.tenant-invitation',
        ],
        'pages' => [
            'tenant_members' => AlessandroNuunes\FilamentMember\Pages\TenantMembers::class,
            'accept_invite' => AlessandroNuunes\FilamentMember\Pages\AcceptInvite::class,
        ],
    ],

    // ============================================
    // CONFIG INVITES
    // ============================================
    'invites' => [
        'default_role' => 'member',
        'expiration_days' => 7,
        'allow_generic_invites' => true,
        'require_registration' => true,
    ],

    // ============================================
    // CONFIG PERMISSIONS
    // ============================================
    'permissions' => [
        'roles' => [
            'can_invite_members' => ['owner', 'admin'],
            'can_remove_members' => ['owner', 'admin'],
            'can_change_roles' => ['owner'],
        ],
        'owner_cannot_be_removed' => true,
        'owner_cannot_change_role' => true,
    ],
    /*
    |--------------------------------------------------------------------------
    | Default Values
    |--------------------------------------------------------------------------
    */

    'defaults' => [
        'tenant_status' => 'active',
        'member_role' => 'member',
    ],

    // ============================================
    // CONFIG NOTIFICATIONS
    // ============================================

    'notifications' => [
        'send_invite_email' => true,
        'invite_email_queue' => null,
        'invite_email_from_address' => config('mail.from.address'),
        'invite_email_from_name' => config('mail.from.name'),
    ],

    // ============================================
    // CONFIGURAÇÕES DE ORDENAÇÃO
    // ============================================

    'sorting' => [
        'members_default_column' => 'name',
        'members_default_direction' => 'asc',
        'members_role_priority' => ['owner', 'admin', 'member'],
    ],

    // ============================================
    // CONFIG VALIDATION
    // ============================================

    'validation' => [
        'require_role_on_invite' => true,
    ],
    // ============================================
    // NAVIGATION
    // ============================================
    'navigation' => [
        'tenant_members_page' => [
            'icon' => 'heroicon-o-users',
            'sort' => 2,
            // 'group' => null, // null = usa __('filament-member::default.navigation.group')
            // 'label' => null, // null = usa __('filament-member::default.navigation.label')
        ],
    ],
];
