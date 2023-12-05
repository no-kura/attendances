<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UsersController; // 追記
use App\Http\Controllers\UserFollowController; // 追記
use App\Http\Controllers\AttendancesController; // 追記
use App\Http\Controllers\SummaryController; // 追記


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
    return view('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
  

require __DIR__.'/auth.php';


Route::group(['middleware' => ['auth']], function () {                                    // 追記
    Route::resource('users', UsersController::class,['only' => ['index', 'show']]);     // 追記
});

// Route::group(['middleware' => ['auth']], function () {
//     Route::get('attendances', [AttendancesController::class,'index'])->name('');
//     Route::post('attendances', [AttendancesController::class,'store'])->name('');

//     });                                                                                       // 追記


Route::group(['middleware' => ['auth']], function () {                                    // 追記
    Route::resource('users', UsersController::class,['only' => ['index', 'show']]);     // 追記
    Route::resource('attendances', AttendancesController::class, ['only' => ['index','store','show']]);
    // Route::get('attendances/index', 'AttendancesController@index')->name('attendances.index');
    // Route::post('attendances/index', 'AttendancesController@index')->name('attendances.index');
    // Route::post('attendances/store', 'AttendancesController@store')->name('atendances.store');
    // Route::get('attendances/show/{id}', 'AttendancesController@show')->name('atendances.show');
    Route::resource('summarys', SummaryController::class);
    
});                                                                                       // 追記

  /*　ここから追加　フォロー設定用　*/
 
Route::group(['middleware' => ['auth']], function () {
    Route::group(['prefix' => 'users/{id}'], function () {                                          // 追記
        Route::post('follow', [UserFollowController::class, 'store'])->name('user.follow');         // 追記
        Route::delete('unfollow', [UserFollowController::class, 'destroy'])->name('user.unfollow'); // 追記
        Route::get('following', [UsersController::class, 'following'])->name('users.following'); // 追記
        Route::get('followers', [UsersController::class, 'followers'])->name('users.followers');    // 追記
        // Route::get('', [SummaryController::class, 'index'])->name('attendances.summarys');
        // Route::post('', [SummaryController::class, 'store'])->name(''); 
    });
});
