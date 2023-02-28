<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $casts=[
        "audio_file"=>"array",
        "audio_link"=>"array"
    ];
    protected $appends=['on_date'];
    public function getOnDateAttribute(){
        return $this->created_at->toFormattedDateString();
    }
}
