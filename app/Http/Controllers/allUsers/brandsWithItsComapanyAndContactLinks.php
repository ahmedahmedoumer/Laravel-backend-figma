<?php

namespace App\Http\Controllers\allUsers;

use App\Http\Controllers\Controller;
use App\Models\brands;
use Illuminate\Http\Request;

class brandsWithItsComapanyAndContactLinks extends Controller
{
  public function usersWithItsCompany(){
    $allBrandsWithItsComapany=brands::with('planner','designer','brandsCompany')->get();
  }
}
