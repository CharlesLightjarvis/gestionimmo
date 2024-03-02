<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorieBien extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomcategorie', 'imagecategorie'
    ];

    public function scategories()
    {
        return $this->hasMany(SousCategorieBien::class, "categorieID");
    }
}
