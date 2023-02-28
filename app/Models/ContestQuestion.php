<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContestQuestion extends Model
{
    use HasFactory;
    public function contest_list(){
        return $this->hasMany(ParticipantList::class,"contest_question_id","id");
    }
}
