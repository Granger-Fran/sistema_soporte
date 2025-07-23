<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $fillable = [
    'title',
    'content',
    'image',
    'is_active',
];

public function getImageUrlAttribute()
{
    if (!$this->image) return null;

    // Si el valor ya tiene "notices/" dentro
    if (str_starts_with($this->image, 'notices/')) {
        return asset('storage/' . $this->image);
    }

    // Si solo es el nombre
    return asset('storage/notices/' . $this->image);
}



}

