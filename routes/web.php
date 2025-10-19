<?php

use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\TargetController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Api\EventRecommendationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReclamationController;
use App\Http\Controllers\ReponseController;
use App\Http\Controllers\Api\AIController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes publiques
|--------------------------------------------------------------------------
*/

Route::view('/ai', 'ai');
Route::post('/chat-ai', [AIController::class, 'chat']);

Route::resource('reclamations', ReclamationController::class);
Route::resource('reponses', ReponseController::class);

Route::get('/landing/home', fn() => view('landing.pages.home'))->name('landing');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Auth
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

/*
|--------------------------------------------------------------------------
| Routes ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', fn() => view('dashboard.pages.dashboard'))->name('admin.dashboard');
});

/*
|--------------------------------------------------------------------------
| Routes UTILISATEUR
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:user'])->group(function () {
    // Dashboard utilisateur avec les événements
    Route::get('/user/dashboard', function () {
        $events = \App\Models\Event::all();
        return view('user.dashboard', compact('events'));
    })->name('user.dashboard');

    // Routes événements utilisateur
    Route::get('/user/events', [UserController::class, 'index'])->name('user.events.index');
    Route::get('/user/events/{event}', [UserController::class, 'showEvent'])->name('user.events.show');
    Route::get('/user/events/search', [UserController::class, 'searchUserEvents'])->name('user.events.search');
Route::post('/user/events/{event}/comment', [UserController::class, 'storeComment'])->name('user.events.comment');

// Supprimer un commentaire
Route::delete('/user/events/{event}/comment/{comment}', [UserController::class, 'destroyComment'])
    ->name('user.events.comment.destroy');

// Modifier un commentaire (afficher formulaire et mettre à jour)
Route::get('/user/events/{event}/comment/{comment}/edit', [UserController::class, 'editComment'])
    ->name('user.events.comment.edit');
Route::put('/user/events/{event}/comment/{comment}', [UserController::class, 'updateComment'])
    ->name('user.events.comment.update');

});

/*
|--------------------------------------------------------------------------
| Routes ADMIN (événements)
|--------------------------------------------------------------------------
*/
Route::resource('events', EventController::class);
Route::get('/events/search', [EventController::class, 'search'])->name('events.search');
Route::post('/events/{event}/comment', [EventController::class, 'storeComment'])->name('events.comment');
Route::get('/events/export/pdf', [EventController::class, 'exportPdf'])->name('events.export.pdf');
Route::get('/events/export/excel', [EventController::class, 'exportExcel'])->name('events.export.excel');

/*
|--------------------------------------------------------------------------
| Autres routes (campagnes, cibles, expériences)
|--------------------------------------------------------------------------
*/
Route::resource('campaigns', CampaignController::class);
Route::resource('targets', TargetController::class);
Route::patch('/targets/{id}/toggle-activation', [TargetController::class, 'toggleActivation'])
    ->name('targets.toggle-activation');

Route::get('/campagnes', [CampaignController::class, 'frontcampaigns'])->name('campagnes.front');
Route::get('/campagnes/{id}/partager', [CampaignController::class, 'showShareExperience'])->name('campagnes.share');
Route::post('/experience', [ExperienceController::class, 'store'])->name('experience.store');
Route::get('/experiences', [ExperienceController::class, 'index'])->name('experiences.index');
Route::get('/campagnes/{id}/experiences', [ExperienceController::class, 'campaignExperiences'])->name('campagnes.experiences');
Route::post('/experiences/{id}/generate-summary', [ExperienceController::class, 'generateSummary'])->name('experiences.generate-summary');
