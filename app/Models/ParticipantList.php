<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipantList extends Model
{
    use HasFactory;
    protected $appends=['on_date'];
    public function getOnDateAttribute(){
        return $this->created_at->toFormattedDateString();
    }
}
