<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bien extends Model
{
    use HasFactory;
    protected $fillable = [
        'prix', 'nombre_chambres', 'surface', 'ville', 'adresse',
        'code_postal', 'type', 'imagebien', 'scategorieID'
    ];
    public function scategories()
    {
        return $this->belongsTo(SousCategorieBien::class, "scategorieID");
    }
}
