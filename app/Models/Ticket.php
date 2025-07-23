<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Ticket extends Model
{
    protected $fillable = [
        'title',
        'description',
        'department',
        'priority',
        'attachment',
        'estimated_time',
        'response',
        'status',
        'user_id',
        'technician_id',
        'user_read', 
    ];

    // Relación para acceder al técnico (usuario que responde)
    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
