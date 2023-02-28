<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavouriteList extends Model
{
    use HasFactory;

    public function schedule()
    {
        return $this->belongsTo(RadioSchedule::class, 'schedule_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
