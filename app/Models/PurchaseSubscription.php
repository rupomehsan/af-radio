<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use Jenssegers\Mongodb\Eloquent\Model;

class PurchaseSubscription extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['added_on','is_favorite'];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAddedOnAttribute()
    {
        return Carbon::parse($this->created_at)->format('d M Y');
    }
}
