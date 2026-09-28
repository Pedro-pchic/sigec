<?php

namespace App\Models;

use Database\Factories\RoleFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name'])]
class Role extends Model
{
    public const string ADMINISTRATOR = 'Administrador';

    public const string HUMAN_RESOURCES = 'Recursos Humanos';

    public const string WAREHOUSE = 'Bodega';

    public const array INITIAL_ROLES = [
        self::ADMINISTRATOR,
        'Gerente',
        'Ventas',
        self::WAREHOUSE,
        'Compras',
        'Finanzas',
        self::HUMAN_RESOURCES,
    ];

    /** @use HasFactory<RoleFactory> */
    use HasFactory;

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
