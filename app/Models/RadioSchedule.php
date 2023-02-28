<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadioSchedule extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $casts=[
        "days"=>"array",
//        "start_time" => 'datetime',
//        "end_time" => 'datetime',
    ];
    protected $appends=['is_favorite'];

//    public function getStartDateAttribute(){
//        return $this->start_time->toFormattedDateString();
//    }
//
//    public function getEndDateAttribute(){
//        return $this->end_time->toFormattedDateString();
//    }

    public function favourite_lists()
    {
        return $this->hasMany(FavouriteList::class,'schedule_id','id');
    }

    public function populer_programs()
    {
        return $this->hasMany(PopulerProgram::class,'schedule_id','id');
    }

    public function getIsFavoriteAttribute()
    {
//         dd( request()->user('sanctum')['id']);
        if(request()->user('sanctum')){
            return (bool)FavouriteList::where([
                'schedule_id' => $this->id,
                'user_id' => request()->user('sanctum')['id']
            ])->count();
        }else{
            return false;
        }

    }

}
