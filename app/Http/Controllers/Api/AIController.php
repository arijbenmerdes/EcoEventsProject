<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
class AIController extends Controller
{
public function exportData(){
    $events = Event::all();
    $users = User::with('events')->get(); // inclut interactions pivot

    // Export JSON
    return response()->json([
        'events' => $events,
        'users' => $users
    ]);
}
}
