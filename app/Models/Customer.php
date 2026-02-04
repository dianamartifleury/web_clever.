<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Crypt;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'country',
        'city',
        'company',
        'notes',

        // Campos de búsqueda (NO cifrados)
        'first_name_search',
        'last_name_search',
        'email_search',
        'phone_search',
    ];

    /**
     * Campos que deben ser encriptados automáticamente
     */
    protected $encrypted = [
        'first_name',
        'last_name',
        'email',
        'phone',
    ];

    /**
     * ─────────────────────────────────────────────
     * ENCRIPTACIÓN AUTOMÁTICA SET
     * ─────────────────────────────────────────────
     */
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->encrypted) && $value !== null) {

            // Evitar cifrar valores que no sean cadenas
            if (is_string($value)) {
                $value = Crypt::encryptString($value);
            }
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * ─────────────────────────────────────────────
     * DESENCRIPTACIÓN AUTOMÁTICA GET
     * ─────────────────────────────────────────────
     */
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if ($value === null || is_array($value)) {
            return $value;
        }

        if (in_array($key, $this->encrypted)) {
            try {
                return Crypt::decryptString($value);
            } catch (\Throwable $e) {
                // Si no es texto cifrado, devolver valor tal cual
                return $value;
            }
        }

        return $value;
    }

    /**
     * ─────────────────────────────────────────────
     * GENERACIÓN AUTOMÁTICA DE CAMPOS SEARCH
     * ─────────────────────────────────────────────
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {

            $model->first_name_search = $model->first_name
                ? strtolower($model->first_name)
                : null;

            $model->last_name_search = $model->last_name
                ? strtolower($model->last_name)
                : null;

            $model->email_search = $model->email
                ? strtolower($model->email)
                : null;

            $model->phone_search = $model->phone
                ? strtolower($model->phone)
                : null;
        });
    }

    /**
     * Relación 1:1 con CustomerMetadata
     */
    public function metadata()
    {
        return $this->hasOne(CustomerMetadata::class);
    }

    /**
     * Relación con las categorías de interés
     * (pivot correcto: customer_interests)
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'customer_interests');
    }
}
