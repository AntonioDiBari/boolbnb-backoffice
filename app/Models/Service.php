<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    /* un servizio può avere uno o più appartamenti collegati */
    public function apartments()
    {
        return $this->belongsToMany(Apartment::class);
    }
}
