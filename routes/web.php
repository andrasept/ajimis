<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeliveryMasterPartController;
use App\Http\Controllers\auth\ForgotPasswordController;

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
    Route::group(['middleware' => ['guest']], function () {
      // register
      Route::get('/register', 'RegisterController@show')->name('register.show');
      Route::post('/signup', 'RegisterController@register')->name('register.perform');
    
      // forgot password
      Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
      Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
      Route::get('reset-password/{token}/{email}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
      Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
    });
    // home
    Route::get('/', 'HomeController@index')->name('home.index');
    Route::get('/dashboard', 'HomeController@dashboard')->name('home.dashboard')->middleware('auth');
    

     /**
     * delivery 
     */
      Route::group(['prefix' => 'delivery'], function() {
        // delivery super admin
        Route::group(['middleware' => ['role:delivery.superadmin']], function () {
          // delivery master part
          Route::post('/master-part-import', 'DeliveryPartController@store')->name('delivery.master.master_part.import')->middleware('auth');
          Route::get('/master-part', 'DeliveryPartController@index')->name('delivery.master.master_part')->middleware('auth');
          Route::get('/master-part/{id}/edit', 'DeliveryPartController@edit')->name('delivery.master.master_part.edit')->middleware('auth');
          Route::put('/master-part/update', 'DeliveryPartController@update')->name('delivery.master.master_part.update')->middleware('auth');
          Route::get('/master-part/create', 'DeliveryPartController@create')->name('delivery.master.master_part.create')->middleware('auth');
          Route::put('/master-part/insert', 'DeliveryPartController@insert')->name('delivery.master.master_part.insert')->middleware('auth');
          Route::get('/master-part/{id}/delete', 'DeliveryPartController@destroy')->name('delivery.master.master_part.destroy')->middleware('auth');
          Route::get('/master-part-export', 'DeliveryPartController@export')->name('delivery.master.master_part.export')->middleware('auth');
          // delvery master packaging
          Route::post('/master-packaging-import', 'DeliveryPackagingController@store')->name('delivery.master.master_packaging.import')->middleware('auth');
          Route::get('/master-packaging', 'DeliveryPackagingController@index')->name('delivery.master.master_packaging')->middleware('auth');
          Route::get('/master-packaging/{id}/edit', 'DeliveryPackagingController@edit')->name('delivery.master.master_packaging.edit')->middleware('auth');
          Route::put('/master-packaging/update', 'DeliveryPackagingController@update')->name('delivery.master.master_packaging.update')->middleware('auth');
          Route::get('/master-packaging/create', 'DeliveryPackagingController@create')->name('delivery.master.master_packaging.create')->middleware('auth');
          Route::put('/master-packaging/insert', 'DeliveryPackagingController@insert')->name('delivery.master.master_packaging.insert')->middleware('auth');
          Route::get('/master-packaging/{id}/delete', 'DeliveryPackagingController@destroy')->name('delivery.master.packaging.destroy')->middleware('auth');
          // delvery master line
          Route::post('/master-line-import', 'DeliveryLineController@store')->name('delivery.master.master_line.import')->middleware('auth');
          Route::get('/master-line', 'DeliveryLineController@index')->name('delivery.master.master_line')->middleware('auth');
          Route::get('/master-line/{id}/edit', 'DeliveryLineController@edit')->name('delivery.master.master_line.edit')->middleware('auth');
          Route::put('/master-line/update', 'DeliveryLineController@update')->name('delivery.master.master_line.update')->middleware('auth');
          Route::get('/master-line/create', 'DeliveryLineController@create')->name('delivery.master.master_line.create')->middleware('auth');
          Route::put('/master-line/insert', 'DeliveryLineController@insert')->name('delivery.master.master_line.insert')->middleware('auth');
          Route::get('/master-line/{id}/delete', 'DeliveryLineController@destroy')->name('delivery.master.line.destroy')->middleware('auth');
          // delvery customer
          Route::post('/master-customer-import', 'DeliveryCustomerController@store')->name('delivery.master.master_customer.import')->middleware('auth');
          Route::get('/master-customer', 'DeliveryCustomerController@index')->name('delivery.master.master_customer')->middleware('auth');
          Route::get('/master-customer/{id}/edit', 'DeliveryCustomerController@edit')->name('delivery.master.master_customer.edit')->middleware('auth');
          Route::put('/master-customer/update', 'DeliveryCustomerController@update')->name('delivery.master.master_customer.update')->middleware('auth');
          Route::get('/master-customer/create', 'DeliveryCustomerController@create')->name('delivery.master.master_customer.create')->middleware('auth');
          Route::put('/master-customer/insert', 'DeliveryCustomerController@insert')->name('delivery.master.master_customer.insert')->middleware('auth');
          Route::get('/master-customer/{id}/delete', 'DeliveryCustomerController@destroy')->name('delivery.master.customer.destroy')->middleware('auth');
          // delvery part card
          Route::post('/master-partcard-import', 'DeliveryPartcardController@store')->name('delivery.master.master_partcard.import')->middleware('auth');
          Route::get('/master-partcard', 'DeliveryPartcardController@index')->name('delivery.master.master_partcard')->middleware('auth');
          Route::get('/master-partcard/{id}/edit', 'DeliveryPartcardController@edit')->name('delivery.master.master_partcard.edit')->middleware('auth');
          Route::put('/master-partcard/update', 'DeliveryPartcardController@update')->name('delivery.master.master_partcard.update')->middleware('auth');
          Route::get('/master-partcard/create', 'DeliveryPartcardController@create')->name('delivery.master.master_partcard.create')->middleware('auth');
          Route::put('/master-partcard/insert', 'DeliveryPartcardController@insert')->name('delivery.master.master_partcard.insert')->middleware('auth');
          Route::get('/master-partcard/{id}/delete', 'DeliveryPartcardController@destroy')->name('delivery.master.partcard.destroy')->middleware('auth');
          // delvery man power
          // Route::post('/master-manpower-import', 'DeliveryManpowerController@store')->name('delivery.master.master_manpower.import')->middleware('auth');
          Route::get('/master-manpower', 'DeliveryManpowerController@index')->name('delivery.master.master_manpower')->middleware('auth');
          Route::get('/master-manpower/{id}/edit', 'DeliveryManpowerController@edit')->name('delivery.master.master_manpower.edit')->middleware('auth');
          Route::put('/master-manpower/update', 'DeliveryManpowerController@update')->name('delivery.master.master_manpower.update')->middleware('auth');
          Route::get('/master-manpower/create', 'DeliveryManpowerController@create')->name('delivery.master.master_manpower.create')->middleware('auth');
          Route::put('/master-manpower/insert', 'DeliveryManpowerController@insert')->name('delivery.master.master_manpower.insert')->middleware('auth');
          Route::get('/master-manpower/{id}/delete', 'DeliveryManpowerController@destroy')->name('delivery.master.manpower.destroy')->middleware('auth');
          // delivery pickup customer
          Route::post('/pickupcustomer', 'DeliveryPrepareCustomerController@store')->name('delivery.pickupcustomer.import')->middleware('auth');
          Route::get('/pickupcustomer', 'DeliveryPrepareCustomerController@index')->name('delivery.pickupcustomer')->middleware('auth');
          Route::get('/pickupcustomer/{id}/edit', 'DeliveryPrepareCustomerController@edit')->name('delivery.pickupcustomer.edit')->middleware('auth');
          Route::put('/pickupcustomer/update', 'DeliveryPrepareCustomerController@update')->name('delivery.pickupcustomer.update')->middleware('auth');
          Route::get('/pickupcustomer/create', 'DeliveryPrepareCustomerController@create')->name('delivery.pickupcustomer.create')->middleware('auth');
          Route::put('/pickupcustomer/insert', 'DeliveryPrepareCustomerController@insert')->name('delivery.pickupcustomer.insert')->middleware('auth');
          Route::get('/pickupcustomer/{id}/delete', 'DeliveryPrepareCustomerController@destroy')->name('delivery.pickupcustomer.destroy')->middleware('auth');
          
          // preaparation admin
          Route::get('/preparation/create', 'DeliveryPreparationController@create')->name('delivery.preparation.create')->middleware('auth');
          Route::put('/preparation/insert', 'DeliveryPreparationController@insert')->name('delivery.preparation.insert')->middleware('auth');
          Route::put('/preparation/update', 'DeliveryPreparationController@update')->name('delivery.preparation.update')->middleware('auth');
          Route::get('/preparation/{id}/edit', 'DeliveryPreparationController@edit')->name('delivery.preparation.edit')->middleware('auth');
          Route::get('/preparation/{id}/delete', 'DeliveryPreparationController@destroy')->name('delivery.preparation.destroy')->middleware('auth');
          Route::post('/preparation-export', 'DeliveryPreparationController@export')->name('delivery.preparation.export')->middleware('auth');
          Route::get('/preparation-dashboard', 'DeliveryPreparationController@dashboard')->name('delivery.preparation.dashboard')->middleware('auth');
          // Route::get('/preparation/{id}/arrival', 'DeliveryPreparationController@arrival')->name('delivery.preparation.arrival')->middleware('auth');
          // Route::get('/preparation/{id}/departure', 'DeliveryPreparationController@departure')->name('delivery.preparation.departure')->middleware('auth');
          Route::post('/preparation', 'DeliveryPreparationController@store')->name('delivery.preparation.import')->middleware('auth');

          // delivery admin
          // Route::post('/delivery', 'DeliveryController@store')->name('delivery.delivery.import')->middleware('auth');
          // Route::get('/delivery/create', 'DeliveryController@create')->name('delivery.delivery.create')->middleware('auth');
          // Route::put('/delivery/insert', 'DeliveryController@insert')->name('delivery.delivery.insert')->middleware('auth');
          // Route::get('/delivery/{id}/edit', 'DeliveryController@edit')->name('delivery.delivery.edit')->middleware('auth');
          // Route::put('/delivery/update', 'DeliveryController@update')->name('delivery.delivery.update')->middleware('auth');
          // Route::get('/delivery/{id}/delete', 'DeliveryController@destroy')->name('delivery.delivery.destroy')->middleware('auth');
          
          // claim admin
          Route::get('/claim', 'DeliveryClaimController@index')->name('delivery.claim.claim')->middleware('auth');
          Route::get('/claim/create', 'DeliveryClaimController@create')->name('delivery.claim.create')->middleware('auth');
          Route::put('/claim/insert', 'DeliveryClaimController@insert')->name('delivery.claim.insert')->middleware('auth');
          Route::get('/claim/{id}/edit', 'DeliveryClaimController@edit')->name('delivery.claim.edit')->middleware('auth');
          Route::put('/claim/update', 'DeliveryClaimController@update')->name('delivery.claim.update')->middleware('auth');
          Route::get('/claim/{id}/delete', 'DeliveryClaimController@destroy')->name('delivery.claim.destroy')->middleware('auth');
          Route::post('/claim/get_data_part', 'DeliveryClaimController@get_data_part')->name('delivery.claim.get_data_part')->middleware('auth');
          Route::get('/claim/dashboard', 'DeliveryClaimController@dashboard')->name('delivery.claim.dashboard')->middleware('auth');
          
          // surat jalan / delivery note admin
          Route::post('/delivery_note', 'DeliveryNoteController@store')->name('delivery.delivery_note.import')->middleware('auth');
          Route::get('/delivery_note', 'DeliveryNoteController@index')->name('delivery.delivery_note')->middleware('auth');
          Route::get('/delivery_note/create', 'DeliveryNoteController@crcleareate')->name('delivery.delivery_note.create')->middleware('auth');
          Route::put('/delivery_note/insert', 'DeliveryNoteController@insert')->name('delivery.delivery_note.insert')->middleware('auth');
          Route::post('/delivery_note/check', 'DeliveryNoteController@check')->name('delivery.delivery_note.check')->middleware('auth');
          
          // master skills
          Route::get('/skills', 'DeliverySkillsController@index')->name('delivery.skills')->middleware('auth');
          Route::get('/skills/create', 'DeliverySkillsController@create')->name('delivery.skills.create')->middleware('auth');
          Route::put('/skills/insert', 'DeliverySkillsController@insert')->name('delivery.skills.insert')->middleware('auth');
          Route::get('/skills/{id}/edit', 'DeliverySkillsController@edit')->name('delivery.skills.edit')->middleware('auth');
          Route::put('/skills/update', 'DeliverySkillsController@update')->name('delivery.skills.update')->middleware('auth');
          Route::get('/skills/{id}/delete', 'DeliverySkillsController@destroy')->name('delivery.skills.destroy')->middleware('auth');
          
          // skill matrix
          Route::get('/skillmatrix', 'DeliverySkillMatrixController@index')->name('delivery.skillmatrix')->middleware('auth');
          Route::get('/skillmatrix/create', 'DeliverySkillMatrixController@create')->name('delivery.skillmatrix.create')->middleware('auth');
          Route::put('/skillmatrix/insert', 'DeliverySkillMatrixController@insert')->name('delivery.skillmatrix.insert')->middleware('auth');
          Route::get('/skillmatrix/{npk}/edit', 'DeliverySkillMatrixController@edit')->name('delivery.skillmatrix.edit')->middleware('auth');
          Route::put('/skillmatrix/update', 'DeliverySkillMatrixController@update')->name('delivery.skillmatrix.update')->middleware('auth');
          Route::get('/skillmatrix/{npk}/delete', 'DeliverySkillMatrixController@destroy')->name('delivery.skillmatrix.destroy')->middleware('auth');
          Route::post('/skillmatrix/get_data_skillmatrix', 'DeliverySkillMatrixController@get_data_skillmatrix')->name('delivery.skillmatrix.get_data_skillmatrix')->middleware('auth');
          
          // henkaten layout area
          Route::put('/layout_area/insert', 'DeliveryLayoutAreaController@insert')->name('delivery.layout_area.insert')->middleware('auth');
          Route::get('/layout_area/create', 'DeliveryLayoutAreaController@create')->name('delivery.layout_area.create')->middleware('auth');
          Route::get('/layout_area', 'DeliveryLayoutAreaController@index')->name('delivery.layout_area')->middleware('auth');
          Route::get('/layout_area/{id}/edit', 'DeliveryLayoutAreaController@edit')->name('delivery.layout_area.edit')->middleware('auth');
          Route::put('/layout_area/update', 'DeliveryLayoutAreaController@update')->name('delivery.layout_area.update')->middleware('auth');
          Route::get('/layout_area/{id}/delete', 'DeliveryLayoutAreaController@destroy')->name('delivery.layout_area.destroy')->middleware('auth');
          Route::post('/layout_area/get_mp_with_same_position', 'DeliveryLayoutAreaController@get_mp_with_same_position')->name('delivery.layout_area.get_mp_with_same_position')->middleware('auth');
          Route::post('/layout_area/get_mp_where_area', 'DeliveryLayoutAreaController@get_mp_where_area')->name('delivery.layout_area.get_mp_where_area')->middleware('auth');
          
          // delivery planning refreshment
          Route::get('/planning_refreshment/create', 'DeliveryPlanningRefreshmentController@create')->name('delivery.planning_refreshment.create')->middleware('auth');
          Route::get('/planning_refreshment', 'DeliveryPlanningRefreshmentController@index')->name('delivery.planning_refreshment')->middleware('auth');
          Route::get('/planning_refreshment/{id}/edit', 'DeliveryPlanningRefreshmentController@edit')->name('delivery.planning_refreshment.edit')->middleware('auth');
          Route::put('/planning_refreshment/update', 'DeliveryPlanningRefreshmentController@update')->name('delivery.planning_refreshment.update')->middleware('auth');
          Route::put('/planning_refreshment/insert', 'DeliveryPlanningRefreshmentController@insert')->name('delivery.planning_refreshment.insert')->middleware('auth');
          Route::get('/planning_refreshment/{id}/delete', 'DeliveryPlanningRefreshmentController@destroy')->name('delivery.planning_refreshment.destroy')->middleware('auth');
          Route::get('/planning_refreshment/{id}/update_status', 'DeliveryPlanningRefreshmentController@update_status')->name('delivery.planning_refreshment.update_status')->middleware('auth');
         
        //  henkaten history detail
          Route::get('/henkaten_detail', 'DeliveryHenkatenDetailController@index')->name('delivery.henkaten_detail')->middleware('auth');

        // dashboard 
          Route::get('/dashboard_delivery', 'DeliveryDashboardController@index')->name('delivery.dashboard')->middleware('auth');
          Route::get('/dashboard_claim_graph', 'DeliveryDashboardController@claim')->name('delivery.claim.graph')->middleware('auth');
          Route::get('/dashboard_henkaten', 'DeliveryDashboardController@henkaten')->name('delivery.henkaten')->middleware('auth');
        
        });
        // delivery member
        Route::get('/delivery', 'DeliveryController@index')->name('delivery.delivery')->middleware('auth');

        // preaparation member
        Route::post('/preparation/get_data_pic', 'DeliveryPreparationController@getDataPic')->name('delivery.preparation.get_data_pic')->middleware('auth');
        Route::get('/preparation', 'DeliveryPreparationController@index')->name('delivery.preparation')->middleware('auth');
        Route::get('/preparation/member', 'DeliveryPreparationController@member')->name('delivery.preparation.member')->middleware('auth');
        Route::post('/preparation/get_data_detail_pickup', 'DeliveryPreparationController@get_data_detail_pickup')->name('delivery.preparation.get_data_detail_pickup')->middleware('auth');
        Route::get('/preparation/{id}/start', 'DeliveryPreparationController@start')->name('delivery.preparation.start_preparation')->middleware('auth');
        Route::get('/preparation/{id}/end', 'DeliveryPreparationController@end')->name('delivery.preparation.end_preparation')->middleware('auth');
        Route::post('/preparation/update_delay', 'DeliveryPreparationController@update_delay')->name('delivery.preparation.update_delay')->middleware('auth');
        
        // preparation / delivery security
        Route::get('/preparation/security', 'DeliveryPreparationController@security')->name('delivery.preparation.security')->middleware('auth');
        Route::get('/preparation/security/history', 'DeliveryPreparationController@history_milkrun')->name('delivery.preparation.security.history')->middleware('auth');
        Route::post('/preparation/arrival', 'DeliveryPreparationController@arrival')->name('delivery.preparation.arrival')->middleware('auth');
        Route::get('/preparation/{id}/departure', 'DeliveryPreparationController@departure')->name('delivery.preparation.departure')->middleware('auth');
        Route::get('/preparation/{id}/hold', 'DeliveryPreparationController@hold')->name('delivery.preparation.hold')->middleware('auth');
        
        
      });
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
           * Post Routesphp artisan serve
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
           * User Routes
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
          
        });
  /*
  |--------------------------------------------------------------------------
  | Akhir Routes Andra
  |--------------------------------------------------------------------------
  |
  |
  */
});