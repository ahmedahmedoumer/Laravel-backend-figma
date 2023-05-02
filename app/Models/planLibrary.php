<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class planLibrary extends Model
{
    use HasFactory;
   protected $fillable=['plaTitle','planDescription','planPrompt'];
}
