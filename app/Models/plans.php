<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class plans extends Model
{
    use HasFactory;
    protected $fillable=['textOnPost','caption','hashTag'];
    
    public function planner()
    {
        return $this->belongsTo(User::class, 'planner','id');
    }
}
