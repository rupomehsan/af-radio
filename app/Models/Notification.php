<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
class Notification extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends=['end_date'];
    protected $casts=[
        "schedule_date"=>"datetime"
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    // protected $hidden = [
    //     'updated_at',
    //     'created_at',
    // ];
    public function getEndDateAttribute(){
        return $this->schedule_date->toFormattedDateString();
    }
    public function radio(){
        return $this->belongsTo(Radio::class);
    }


}
