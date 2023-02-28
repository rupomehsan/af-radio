<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PopulerProgram extends Model
{
    use HasFactory;

    public function radio()
    {
        return $this->belongsTo(Radio::class);
    }

    public function schedule()
    {
        return $this->belongsTo(RadioSchedule::class, 'schedule_id', 'id');
    }
}
