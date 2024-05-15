<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    use HasFactory;

    /* una sponsorizzazione fa riferimento ad uno o più appartamenti */
    public function apartments()
    {
        return $this->belongsToMany(Apartment::class)->withPivot('expiry', 'created');
    }
}