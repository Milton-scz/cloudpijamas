<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class Role extends Model
{

    use HasFactory;
    /**
     * Relación muchos a muchos con usuarios.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id');
    }

    protected $fillable = [
        'nombre',
        'descripcion',

    ];
}
