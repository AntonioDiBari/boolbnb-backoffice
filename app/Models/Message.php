<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = ['apartment_id', 'email', 'body', 'sent'];

    /* un messaggio si riferisce ad un appartamento */

    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }

    public function getAbstract($n_chars = 15)
    {
        return (strlen($this->body) > $n_chars) ? substr($this->body, 0, $n_chars) . '...' : $this->body;
    }

    public function getDate()
    {
        $data = $this->sent;
        $timestamp = strtotime($data);
        $soloData = date("Y-m-d", $timestamp);
        return $soloData;

    }
}