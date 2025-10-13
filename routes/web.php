<?php

use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\TargetController;
use App\Models\Campaign;
use App\Models\Target;
use Illuminate\Support\Facades\Route;



use App\Http\Controllers\ReclamationController;
use App\Http\Controllers\ReponseController;



Route::resource('reclamations', ReclamationController::class);
Route::resource('reponses', ReponseController::class);

Route::get('/', function () {
    return view('dashboard.pages.dashboard');
})->name('dashboard');
Route::get('/landing/home', function () {
    return view('landing.pages.home');
})->name('landing');
Route::resource('events', EventController::class);
Route::get('/events/search', [EventController::class, 'search'])->name('events.search');
Route::post('/events/{event}/comment', [EventController::class, 'storeComment'])->name('events.comment');
Route::get('/events/export/pdf', [EventController::class, 'exportPdf'])->name('events.export.pdf');
Route::get('/events/export/excel', [EventController::class, 'exportExcel'])->name('events.export.excel');

Route::resource('campaigns', CampaignController::class);
Route::resource('targets', TargetController::class);
Route::patch('/targets/{id}/toggle-activation', [TargetController::class, 'toggleActivation'])
     ->name('targets.toggle-activation');
Route::get('/campagnes', [App\Http\Controllers\CampaignController::class, 'frontcampaigns'])->name('campagnes.front');
Route::get('/campagnes/{id}/partager', [App\Http\Controllers\CampaignController::class, 'showShareExperience'])->name('campagnes.share');
Route::post('/experience', [ExperienceController::class, 'store'])->name('experience.store');
