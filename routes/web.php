<?php

use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TargetController;
use App\Models\Campaign;
use App\Models\Target;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard/home', function () {
    return view('dashboard.pages.dashboard');
});


