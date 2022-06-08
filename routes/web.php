<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;

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

 
Route::group(['namespace' => 'App\Http\Controllers'], function()
{
  /*
  |--------------------------------------------------------------------------
  | Routes Agil
  |--------------------------------------------------------------------------
  |
  |
  */
    // forgot password
    Route::group(['middleware' => ['guest']], function () {
      // register
      // Route::post('/register', [LoginController::class, 'register'])->name('registerhalaman.show');
      Route::get('/register', 'RegisterController@show')->name('register.show');
      Route::post('/signup', 'RegisterController@register')->name('register.perform');

      Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
      Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
      Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
      Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
    });
    /**
       * Home Routes
       */
      Route::get('/', 'HomeController@index')->name('home.index');
      Route::get('/dashboard', 'HomeController@dashboard')->name('home.dashboard')->middleware('auth');
    /*
  |--------------------------------------------------------------------------
  | Akhir Routes Agil
  |--------------------------------------------------------------------------
  |
  |
  */
  
 
 /*
  |--------------------------------------------------------------------------
  | Routes Andra
  |--------------------------------------------------------------------------
  |
  |
  */
  
    Route::group(['middleware' => ['guest']], function() {
      /**
       * Register Routes
       */
      
      
        /**
         * Login Routes
         */
        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@authenticate')->name('login.perform');
    });


    
    Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
    Route::group(['middleware' => ['auth', 'permission']], function() { // harus login terlebih dahulu untuk akses route2 di dalam ini
      /**
       * Logout Routes
       */

          /**
           * User Routes
           */
          Route::group(['prefix' => 'users'], function() {
            Route::get('/', 'UsersController@index')->name('users.index');
            Route::get('/create', 'UsersController@create')->name('users.create');
            Route::post('/create', 'UsersController@store')->name('users.store');
            Route::get('/{user}/show', 'UsersController@show')->name('users.show');
            Route::get('/{user}/edit', 'UsersController@edit')->name('users.edit');
            Route::patch('/{user}/update', 'UsersController@update')->name('users.update');
            Route::delete('/{user}/delete', 'UsersController@destroy')->name('users.destroy');

            Route::post('/{user}/restore', 'UsersController@restore')->name('users.restore');
            Route::delete('/{user}/force-delete', 'UsersController@forceDelete')->name('users.force-delete');
            Route::post('/restore-all', 'UsersController@restoreAll')->name('users.restore-all');
          });

          /**
           * Post Routes
           */
          Route::group(['prefix' => 'posts'], function() {
            Route::get('/', 'PostsController@index')->name('posts.index');
            // Route::get('/test', 'PostsController@index')->name('posts.index');
            Route::get('/create', 'PostsController@create')->name('posts.create');
            Route::post('/create', 'PostsController@store')->name('posts.store');
            Route::get('/{post}/show', 'PostsController@show')->name('posts.show');
            Route::get('/{post}/edit', 'PostsController@edit')->name('posts.edit');
            Route::patch('/{post}/update', 'PostsController@update')->name('posts.update');
            Route::delete('/{post}/delete', 'PostsController@destroy')->name('posts.destroy');
          });

          /**
           * Demo
           */
          Route::group(['prefix' => 'demo'], function() {
            Route::get('/', 'DemoController@index')->name('demo.index');
            Route::get('/trash', 'DemoController@trash')->name('demo.trash');
            Route::get('/create', 'DemoController@create')->name('demo.create');
            Route::post('/create', 'DemoController@store')->name('demo.store');
            Route::get('/{post}/show', 'DemoController@show')->name('demo.show');
            Route::get('/{post}/edit', 'DemoController@edit')->name('demo.edit');
            Route::patch('/{post}/update', 'DemoController@update')->name('demo.update');
            Route::delete('/{post}/delete', 'DemoController@destroy')->name('demo.destroy');
          });

          Route::resource('roles', RolesController::class);
          Route::resource('permissions', PermissionsController::class);

          // Route::get('/register', 'RegisterController@show')->name('register.show');
          // Route::post('/register', 'RegisterController@register')->name('register.perform');

          // Department
          Route::resource('departments', DepartmentController::class);
          // Route::post('/{department}/restore', 'DepartmentController@restore')->name('departments.restore');
          // Route::delete('/{department}/force-delete', 'DepartmentController@forceDelete')->name('departments.force-delete');
          // Route::post('/restore-all', 'DepartmentController@restoreAll')->name('departments.restore-all');

          // Section
          Route::resource('sections', SectionController::class);
          // Route::post('/{section}/restore', 'SectionController@restore')->name('sections.restore');
          // Route::delete('/{section}/force-delete', 'SectionController@forceDelete')->name('sections.force-delete');
          // Route::post('/restore-all', 'SectionController@restoreAll')->name('sections.restore-all');

          /**
           * File Routes
           */
          Route::group(['prefix' => 'files'], function() {
            Route::get('/', 'FilesController@index')->name('files.index');
            Route::get('/create', 'FilesController@create')->name('files.create');
            Route::post('/create', 'FilesController@store')->name('files.store');
            Route::get('/{post}/show', 'FilesController@show')->name('files.show');
            Route::get('/{post}/edit', 'FilesController@edit')->name('files.edit');
            Route::patch('/{post}/update', 'FilesController@update')->name('files.update');
            Route::delete('/{post}/delete', 'FilesController@destroy')->name('files.destroy');

            Route::get('/download', 'FilesController@download')->name('files.download');
            Route::get('/{post}/downloadfile', 'FilesController@downloadfile')->name('files.downloadfile');

            Route::get('/alldept', 'FilesController@alldept')->name('files.alldept');

              // Route::get('/files', 'FilesController@index')->name('files.index');
              // Route::get('/files/add', 'FilesController@create')->name('files.create');
              // Route::post('/files/add', 'FilesController@store')->name('files.store');
          });

          // Categories
          // Route::get('/category','CategoryController@index')->name('category.index');
          // Route::resource('categories', CategoryController::class);
          // Route::get('/categories/categorytree', 'CategoryController@categorytree');
          Route::group(['prefix' => 'categories'], function() {
            Route::get('/', 'CategoryController@index')->name('categories.index');
            Route::get('/categorytree', 'CategoryController@categorytree')->name('categories.categorytree');
            Route::get('/create', 'CategoryController@create')->name('categories.create');
            Route::post('/create', 'CategoryController@store')->name('categories.store');
            Route::get('/{post}/show', 'CategoryController@show')->name('categories.show');
            Route::get('/{post}/edit', 'CategoryController@edit')->name('categories.edit');
            Route::patch('/{post}/update', 'CategoryController@update')->name('categories.update');
            Route::delete('/{post}/delete', 'CategoryController@destroy')->name('categories.destroy');
          });

          /**
           * Log Routes
           */
          Route::group(['prefix' => 'logs'], function() {
            Route::get('/', 'LogController@index')->name('logs.index');
            Route::get('/create', 'LogController@create')->name('logs.create');
            Route::post('/create', 'LogController@store')->name('logs.store');
            Route::get('/{user}/show', 'LogController@show')->name('logs.show');
            Route::get('/{user}/edit', 'LogController@edit')->name('logs.edit');
            Route::patch('/{user}/update', 'LogController@update')->name('logs.update');
            Route::delete('/{user}/delete', 'LogController@destroy')->name('logs.destroy');
          });

          /**
           * Quality Area Routes
           */
          Route::group(['prefix' => 'quality'], function() {
            // Route::get('/dashboard', 'HomeController@dashboard')->name('quality.index')->middleware('auth');
            Route::get('/', 'HomeController@dashboard')->name('quality.index')->middleware('auth');

            Route::get('/area/', 'QualityAreaController@index')->name('quality.area.index');
            Route::get('/area/create', 'QualityAreaController@create')->name('quality.area.create');
            Route::post('/area/create', 'QualityAreaController@store')->name('quality.area.store');
            Route::get('/area/{post}/show', 'QualityAreaController@show')->name('quality.area.show');
            Route::get('/area/{post}/edit', 'QualityAreaController@edit')->name('quality.area.edit');
            Route::patch('/area/{post}/update', 'QualityAreaController@update')->name('quality.area.update');
            Route::delete('/area/{post}/delete', 'QualityAreaController@destroy')->name('quality.area.destroy');

            Route::get('/process/', 'QualityProcessController@index')->name('quality.process.index');
            Route::get('/process/create', 'QualityProcessController@create')->name('quality.process.create');
            Route::post('/process/create', 'QualityProcessController@store')->name('quality.process.store');
            Route::get('/process/{post}/show', 'QualityProcessController@show')->name('quality.process.show');
            Route::get('/process/{post}/edit', 'QualityProcessController@edit')->name('quality.process.edit');
            Route::patch('/process/{post}/update', 'QualityProcessController@update')->name('quality.process.update');
            Route::delete('/process/{post}/delete', 'QualityProcessController@destroy')->name('quality.process.destroy');

            Route::get('/model/', 'QualityModelController@index')->name('quality.model.index');
            Route::get('/model/create', 'QualityModelController@create')->name('quality.model.create');
            Route::post('/model/create', 'QualityModelController@store')->name('quality.model.store');
            Route::get('/model/{post}/show', 'QualityModelController@show')->name('quality.model.show');
            Route::get('/model/{post}/edit', 'QualityModelController@edit')->name('quality.model.edit');
            Route::patch('/model/{post}/update', 'QualityModelController@update')->name('quality.model.update');
            Route::delete('/model/{post}/delete', 'QualityModelController@destroy')->name('quality.model.destroy');

            Route::get('/part/', 'QualityPartController@index')->name('quality.part.index');
            Route::get('/part/create', 'QualityPartController@create')->name('quality.part.create');
            Route::post('/part/create', 'QualityPartController@store')->name('quality.part.store');
            Route::get('/part/{post}/show', 'QualityPartController@show')->name('quality.part.show');
            Route::get('/part/{post}/edit', 'QualityPartController@edit')->name('quality.part.edit');
            Route::patch('/part/{post}/update', 'QualityPartController@update')->name('quality.part.update');
            Route::delete('/part/{post}/delete', 'QualityPartController@destroy')->name('quality.part.destroy');

            Route::get('/monitor/', 'QualityMonitorController@index')->name('quality.monitor.index');
            Route::get('/monitor/create', 'QualityMonitorController@create')->name('quality.monitor.create');
            Route::post('/monitor/create', 'QualityMonitorController@store')->name('quality.monitor.store');
            Route::get('/monitor/{post}/show', 'QualityMonitorController@show')->name('quality.monitor.show');
            Route::get('/monitor/{post}/edit', 'QualityMonitorController@edit')->name('quality.monitor.edit');
            Route::patch('/monitor/{post}/update', 'QualityMonitorController@update')->name('quality.monitor.update');
            Route::delete('/monitor/{post}/delete', 'QualityMonitorController@destroy')->name('quality.monitor.destroy');


          });
          
        });
  /*
  |--------------------------------------------------------------------------
  | Akhir Routes Andra
  |--------------------------------------------------------------------------
  |
  |
  */
});