<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class brandsCompany extends Model
{
    use HasFactory;
    protected $table='brands_companies';

    public function brands(){
        return $this->belongsTo(brands::class,'brands_id');
    }
}
