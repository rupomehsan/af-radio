<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopListen extends Model
{
    use HasFactory;
    protected $guarded = [];
    /**
     * The attributes that should be hidden for serialization.
     * @var array
     */
    // protected $hidden = [
    //     'updated_at',
    //     'created_at',
    // ];
    public function radio()
    {
        return $this->belongsTo(Radio::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}