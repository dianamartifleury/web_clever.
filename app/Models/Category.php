<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Customer;
use App\Models\Product;

class Category extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Define la relación inversa (Muchos-a-Muchos) con Customer.
     *
     * Esto es necesario, junto con la corrección en el modelo Customer,
     * para que el Eager Loading (->with('categories')) funcione correctamente.
     */
    public function customers(): BelongsToMany
    {
        return $this->belongsToMany(
            Customer::class,
            'customer_interests', // Tabla Pivote
            'category_id',        // Clave Foránea de Category (en la pivote)
            'customer_id'         // Clave Foránea de Customer (en la pivote)
        );
    }

    // Relación uno a muchos con Product
    public function products(): HasMany
    {
        // 👇 Se asegura de que siempre devuelva una colección, incluso si está vacía
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
