<?php

use App\DataTables\RoomDataTable;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationsController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ReceptionistsController;

use  App\Http\Controllers\Auth\AdminLoginController;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home', function(RoomDataTable $dataTable) {
  ///dd(Auth::user()->roles->first()->name);
	$role = Auth::user()->roles->first()->name;
	if($role == 'manager') {
		return view('manager.dashboard');
	}else if($role == 'admin'){
		return view('admin.dashboard');
	}else if($role=='client'){
        return $dataTable->render('reservations.index');
    }else if($role=='recep'){
        return view('receptionist.index');
    }
})->name('home');

/************************************************************** */
/*
Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/superadmin_dashboard', function(){
      return view('admin.dashboard');
    })->name('super_admin_dashboard');
  });

  Route::group(['middleware' => ['role:user']], function () {
    Route::get('/user_dashboard', function(){
      return view('user_dashboard');
    })->name('user_dashboard');
  });  
*/

// Route::resource('articles', ArticleController::class);
Route::get('get-rooms', [ReservationsController::class, 'getAvailableRooms'])->name('get-rooms');
Route::get('/rooms', [RoomController::class, 'index'])->name('room.index');
Route::get('/rooms/create',[RoomController::class, 'create'])->name('room.create');
Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('room.show');
Route::post('/rooms',[RoomController::class, 'store'])->name('room.store');
Route::get('/rooms/{room}/rent', [ReservationController::class, 'store'])->name('reservation.store');



Route::get('reservations/all',[ReservationsController::class, 'index'])->name('reservation.list');
Route::get('reservations',[ReservationsController::class,'index']);          //show available rooms
Route::get('reservations/{room}',[ReservationsController::class,'create'])->name('reservation.create');
Route::post('reservations',[ReservationsController::class, 'store'])->name('reservation.store');



//================  Multi Authentication ====================//
/*Route::prefix('admin')->group(function(){

    Route::get('/login',[AdminLoginController::class,'showLoginForm'])->name('admin.login'); 
    Route::post('/login',[AdminLoginController::class,'login'])->name('admin.login.submit'); 
    Route::get('/',[adminController::class,'dash']);
});*/
 

Route::get('receptionist/all',[ReceptionistsController::class, 'index'])->name('receptionist.index');
Route::get('receptionist/showNonApprovedClients',[ReceptionistsController::class, 'showNonApprovedClients'])->name('receptionist.showNonApprovedClients');




// Route::get('students', [StudentController::class, 'index']);
// Route::get('students/list', [StudentController::class, 'getStudents'])->name('students.list');


