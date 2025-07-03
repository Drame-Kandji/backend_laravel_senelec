<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Reclamation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'description',
        'localisation',
        'date',
        'type',
        'statut',
        'technicien_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function technicien()
    {
        return $this->belongsTo(User::class, 'technicien_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($reclamation) {
            $prefix = 'R-';
            $date = now()->format('Ymd'); // ex: 20250704
            $random = strtoupper(Str::random(4)); // ex: A4F3

            $reclamation->numero = $prefix . $date . '-' . $random;
        });
    }

}
