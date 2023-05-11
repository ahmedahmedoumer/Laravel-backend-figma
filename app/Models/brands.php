<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class brands extends Model
{
    use HasFactory;

    public function planner()
    {
        return $this->belongsTo(User::class, 'planners_id');
    }

    public function designer()
    {
        return $this->belongsTo(User::class, 'designers_id');
    }
    public function brandsCompany(){
        return $this->hasMany(brandsCompany::class,'brands_id');
    }
    public function designs(){
        return $this->hasMany(designs::class);
    }
    public function plans()
    {
        return $this->hasMany(plans::class);
    }
   
}
