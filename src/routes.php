<?php

$as = "";
if(\Skato\SkatoAdmin\Helpers\skHelper::laravel_ver() == 5.3) {
    $as = config('skato-admin.adminRoute') . '.';
}

/**
 * Connect routes with ADMIN_PANEL permission(for security) and 'Skato\SkatoAdmin\Controllers' namespace
 * and '/admin' url.
 */
Route::group([
    'namespace' => 'Skato\SkatoAdmin\Controllers',
    'as' => $as,
    'middleware' => ['web', 'auth', 'permission:ADMIN_PANEL', 'role:SUPER_ADMIN']
], function () {
    
    /* ================== Modules ================== */
    Route::resource(config('skato-admin.adminRoute') . '/modules', 'ModuleController');
    Route::resource(config('skato-admin.adminRoute') . '/module_fields', 'FieldController');
    Route::get(config('skato-admin.adminRoute') . '/module_generate_crud/{model_id}', 'ModuleController@generate_crud');
    Route::get(config('skato-admin.adminRoute') . '/module_generate_migr/{model_id}', 'ModuleController@generate_migr');
    Route::get(config('skato-admin.adminRoute') . '/module_generate_update/{model_id}', 'ModuleController@generate_update');
    Route::get(config('skato-admin.adminRoute') . '/module_generate_migr_crud/{model_id}', 'ModuleController@generate_migr_crud');
    Route::get(config('skato-admin.adminRoute') . '/modules/{model_id}/set_view_col/{column_name}', 'ModuleController@set_view_col');
    Route::post(config('skato-admin.adminRoute') . '/save_role_module_permissions/{id}', 'ModuleController@save_role_module_permissions');
    Route::get(config('skato-admin.adminRoute') . '/save_module_field_sort/{model_id}', 'ModuleController@save_module_field_sort');
    Route::post(config('skato-admin.adminRoute') . '/check_unique_val/{field_id}', 'FieldController@check_unique_val');
    Route::get(config('skato-admin.adminRoute') . '/module_fields/{id}/delete', 'FieldController@destroy');
    Route::post(config('skato-admin.adminRoute') . '/get_module_files/{module_id}', 'ModuleController@get_module_files');
    Route::post(config('skato-admin.adminRoute') . '/module_update', 'ModuleController@update');
    Route::post(config('skato-admin.adminRoute') . '/module_field_listing_show', 'FieldController@module_field_listing_show_ajax');
    
    /* ================== Code Editor ================== */
    Route::get(config('skato-admin.adminRoute') . '/lacodeeditor', function () {
        if(file_exists(resource_path("views/sk/editor/index.blade.php"))) {
            return redirect(config('skato-admin.adminRoute') . '/laeditor');
        } else {
            // show install code editor page
            return View('sk.editor.install');
        }
    });
    
    /* ================== Menu Editor ================== */
    Route::resource(config('skato-admin.adminRoute') . '/la_menus', 'MenuController');
    Route::post(config('skato-admin.adminRoute') . '/la_menus/update_hierarchy', 'MenuController@update_hierarchy');
    
    /* ================== Configuration ================== */
    Route::resource(config('skato-admin.adminRoute') . '/sk_configs', '\App\Http\Controllers\SK\SKConfigController');
    
    Route::group([
        'middleware' => 'role'
    ], function () {
        /*
        Route::get(config('skato-admin.adminRoute') . '/menu', [
            'as'   => 'menu',
            'uses' => 'LAController@index'
        ]);
        */
    });
});
