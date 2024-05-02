<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use HasFactory;


    /* una visualizzazione fa riferimento ad un appartamento */
    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }
}
