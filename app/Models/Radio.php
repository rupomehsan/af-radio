<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Radio extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function top_listens()
    {
        return $this->hasMany(TopListen::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }



}
