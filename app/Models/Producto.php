<?php
namespace App\Models;

use App\Models\Categoria;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    // Relación muchos a uno
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }


    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }


    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function averageRating()
    {
        $average = $this->ratings()->avg('puntuacion');
        return $average ? round($average, 1) : null;
    }


    public function scopeSearch($query, $searchTerm)
{
    return $query->where('nombre', 'LIKE', "%{$searchTerm}%")
                 ->orWhereHas('categoria', function ($query) use ($searchTerm) {
                     $query->where('nombre', 'LIKE', "%{$searchTerm}%");
                 });
}


    protected $fillable = [
        'nombre',
        'precio',
        'stock',
        'categoria_id',
        'imagen',
        'descripcion',

    ];
}
