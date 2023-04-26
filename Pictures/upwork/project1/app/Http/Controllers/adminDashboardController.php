<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\notification;

class adminDashboardController extends Controller
{
    public function adminDashboard(){
        $notificationReader=new notification();
        $notificationReader=$notificationReader::where('status','notread')->get();
    }
}
