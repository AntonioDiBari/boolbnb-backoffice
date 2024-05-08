<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    /* un messaggio si riferisce ad un appartamento */

    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }

    public function getAbstract($n_chars = 15)
    {
        return (strlen($this->body) > $n_chars) ? substr($this->body, 0, $n_chars) . '...' : $this->body;
    }
}
