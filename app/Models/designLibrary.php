<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class designLibrary extends Model
{
    use HasFactory;
    protected $fillable=['designTitle', 'image', 'sourceFile'];

    public function brands()
    {
        return $this->belongsTo(brands::class, 'brands_id', 'id');
    }
}
