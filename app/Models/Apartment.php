<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apartment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['title_desc', 'user_id', 'n_rooms', 'n_bathrooms', 'n_beds', 'square_mts', 'img', 'visible', 'latitude', 'longitude', 'deleted_at'];

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

    /* un appartamento ha uno o più servizi */
    public function services()
    {
        return $this->belongsToMany(Service::class);
    }
    /* un appartamento ha uno o più sponsorizzazioni */
    public function sponsors()
    {
        return $this->belongsToMany(Sponsor::class);
    }
}