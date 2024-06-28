 <?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MysqlController;
use App\Http\Controllers\SendMediaController;
use App\Http\Controllers\SettingsController;

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


Route::get('storeAuth',[AuthController::class,'storeAuth'])->name('storeAuth');
Route::get('storeAuth/callback',[AuthController::class,'callback'])->name('callback');







// modal route
Route::get('inject-modal.js', [App\Http\Controllers\ModalController::class, 'injectModalScript']);



// settings route
Route::post('settings-form',[SettingsController::class,'index'])->name('settings-form');




// send media
Route::post('send-media',[SendMediaController::class,'index'])->name('send-media');


Route::get('mysql',[MysqlController::class,'index'])->name('mysql');


