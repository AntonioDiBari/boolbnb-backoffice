<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;

    /* un appartamento appartiene ad uno user */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /* un appartamento ha uno o più messaggi */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /* un appartamento ha uno o più visualizzazini */

    public function views()
    {
        return $this->hasMany(View::class);
    }
}
