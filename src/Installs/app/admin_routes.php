<?php

/* ================== Homepage ================== */
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::auth();

/* ================== Access Uploaded Files ================== */
Route::get('files/{hash}/{name}', 'SK\UploadsController@get_file');

/*
|--------------------------------------------------------------------------
| Admin Application Routes
|--------------------------------------------------------------------------
*/

$as = "";
if(\Skato\SkatoAdmin\Helpers\skHelper::laravel_ver() == 5.3) {
	$as = config('skato-admin.adminRoute').'.';
	
	// Routes for Laravel 5.3
	Route::get('/logout', 'Auth\LoginController@logout');
}

Route::group(['as' => $as, 'middleware' => ['auth', 'permission:ADMIN_PANEL']], function () {
	
	/* ================== Dashboard ================== */
	
	Route::get(config('skato-admin.adminRoute'), 'SK\DashboardController@index');
	Route::get(config('skato-admin.adminRoute'). '/dashboard', 'SK\DashboardController@index');
	
	/* ================== Users ================== */
	Route::resource(config('skato-admin.adminRoute') . '/users', 'SK\UsersController');
	Route::get(config('skato-admin.adminRoute') . '/user_dt_ajax', 'SK\UsersController@dtajax');
	
	/* ================== Uploads ================== */
	Route::resource(config('skato-admin.adminRoute') . '/uploads', 'SK\UploadsController');
	Route::post(config('skato-admin.adminRoute') . '/upload_files', 'SK\UploadsController@upload_files');
	Route::get(config('skato-admin.adminRoute') . '/uploaded_files', 'SK\UploadsController@uploaded_files');
	Route::post(config('skato-admin.adminRoute') . '/uploads_update_caption', 'SK\UploadsController@update_caption');
	Route::post(config('skato-admin.adminRoute') . '/uploads_update_filename', 'SK\UploadsController@update_filename');
	Route::post(config('skato-admin.adminRoute') . '/uploads_update_public', 'SK\UploadsController@update_public');
	Route::post(config('skato-admin.adminRoute') . '/uploads_delete_file', 'SK\UploadsController@delete_file');
	
	/* ================== Roles ================== */
	Route::resource(config('skato-admin.adminRoute') . '/roles', 'SK\RolesController');
	Route::get(config('skato-admin.adminRoute') . '/role_dt_ajax', 'SK\RolesController@dtajax');
	Route::post(config('skato-admin.adminRoute') . '/save_module_role_permissions/{id}', 'SK\RolesController@save_module_role_permissions');
	
	/* ================== Permissions ================== */
	Route::resource(config('skato-admin.adminRoute') . '/permissions', 'SK\PermissionsController');
	Route::get(config('skato-admin.adminRoute') . '/permission_dt_ajax', 'SK\PermissionsController@dtajax');
	Route::post(config('skato-admin.adminRoute') . '/save_permissions/{id}', 'SK\PermissionsController@save_permissions');
	
	/* ================== Departments ================== */
	Route::resource(config('skato-admin.adminRoute') . '/departments', 'SK\DepartmentsController');
	Route::get(config('skato-admin.adminRoute') . '/department_dt_ajax', 'SK\DepartmentsController@dtajax');
	
	/* ================== Employees ================== */
	Route::resource(config('skato-admin.adminRoute') . '/employees', 'SK\EmployeesController');
	Route::get(config('skato-admin.adminRoute') . '/employee_dt_ajax', 'SK\EmployeesController@dtajax');
	Route::post(config('skato-admin.adminRoute') . '/change_password/{id}', 'SK\EmployeesController@change_password');
	
	/* ================== Organizations ================== */
	Route::resource(config('skato-admin.adminRoute') . '/organizations', 'SK\OrganizationsController');
	Route::get(config('skato-admin.adminRoute') . '/organization_dt_ajax', 'SK\OrganizationsController@dtajax');

	/* ================== Backups ================== */
	Route::resource(config('skato-admin.adminRoute') . '/backups', 'SK\BackupsController');
	Route::get(config('skato-admin.adminRoute') . '/backup_dt_ajax', 'SK\BackupsController@dtajax');
	Route::post(config('skato-admin.adminRoute') . '/create_backup_ajax', 'SK\BackupsController@create_backup_ajax');
	Route::get(config('skato-admin.adminRoute') . '/downloadBackup/{id}', 'SK\BackupsController@downloadBackup');

    Route::get(config('laraadmin.adminRoute') . '/file-manager', 'ElfinderControllers@showIndex');
    Route::any(config('laraadmin.adminRoute') . '/file-manager/connector', 'ElfinderControllers@showConnector');
    Route::get(config('laraadmin.adminRoute') . '/file-manager/popup/{input_id}', 'ElfinderControllers@showPopup');
    Route::get(config('laraadmin.adminRoute') . '/file-manager/filepicker/{input_id}', 'ElfinderControllers@showFilePicker');
    Route::get(config('laraadmin.adminRoute') . '/file-manager/tinymce', 'ElfinderControllers@showTinyMCE');
    Route::get(config('laraadmin.adminRoute') . '/file-manager/tinymce4', 'ElfinderControllers@showTinyMCE4');
    Route::get(config('laraadmin.adminRoute') . '/file-manager/ckeditor', 'ElfinderControllers@showCKeditor4');

    Route::get(config('laraadmin.adminRoute') .'/notifications', 'LA\UsersController@notifications');
});
