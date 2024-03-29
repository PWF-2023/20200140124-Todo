<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TodoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('todo',TodoController::class)->except(['show']);

    // Route::get('/todo', [TodoController::class, 'index'])->name('todo.index');
    // Route::post('/todo', [TodoController::class, 'store'])->name('todo.store');
    // Route::get('/todo/create', [TodoController::class, 'create'])->name('todo.create');
    // Route::get('/todo/{todo}/edit', [TodoController::class, 'edit'])->name('todo.edit');
    // Route::patch('/todo/{todo}', [TodoController::class, 'update'])->name('todo.update');
    // Route::delete('/todo/{todo}', [TodoController::class, 'destroy'])->name('todo.destroy');

    Route::patch('/todo/{todo}/complete', [TodoController::class, 'complete'])->name('todo.complete');
    Route::patch('/todo/{todo}/incomplete', [TodoController::class, 'uncomplete'])->name('todo.uncomplete');
    Route::delete('/todo', [TodoController::class, 'destroyCompleted'])->name('todo.deleteallcompleted');

    // Route::get('/user', [UserController::class, 'index'])->name('user.index');
    // Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    // Route::patch('/user/{user}/makeadmin', [UserController::class, 'makeadmin'])->name('user.makeadmin');
    // Route::patch('/user/{user}/removeadmin', [UserController::class, 'removeadmin'])->name('user.removeadmin');

    //Get all user route and change with prefix user
    // Route::prefix($prefix 'user') ->middleware($middleware 'admin')->group($callback function(){
    //     Route::get($uri '/', $action [UserController::class, 'index'])->name( $name'user.index');
    //     Route::delete($uri '/{user}',$action [UserController::class, 'destroy'])->name(name 'user.destroy');
    //     Route::patch($uri '/{user}/makeadmin',$action [UserController::class, 'makeadmin'])->name(name 'user.makeadmin');
    //     Route::patch($uri '/{user}/removeadmin',$action [UserController::class, 'removeadmin'])->name(name 'user.removeadmin');
    // });

    Route::middleware('admin')->group(function() {
        Route::get('/user', [UserController::class, 'index'])->name('user.index');
        Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::patch('/user/{user}/makeadmin', [UserController::class, 'makeadmin'])->name('user.makeadmin');
        Route::patch('/user/{user}/removeadmin', [UserController::class, 'removeadmin'])->name('user.removeadmin');
    });
});

require __DIR__.'/auth.php';