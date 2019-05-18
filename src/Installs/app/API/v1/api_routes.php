<?php
/**
 * Created by PhpStorm.
 * User: skato
 * Date: 22/09/17
 * Time: 15.25
 */

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['namespace' => 'App\Http\API\Controllers', 'middleware' => 'auth'], function ($api) {

//  Users

    $api->get('users', 'UsersController@index');
    $api->get('users/{id}', 'UsersController@show');

//  Departments

    $api->get('departments', 'DepartmentsController@index');
    $api->post('departments', 'DepartmentsController@store');
    $api->get('departments/{id}', 'DepartmentsController@show');
    $api->put('departments/{id}', 'DepartmentsController@update');
    $api->delete('departments/{id}', 'DepartmentsController@destroy');

//  Employees

    $api->get('employees', 'EmployeesController@index');
    $api->post('employees', 'EmployeesController@store');
    $api->get('employees/{id}', 'EmployeesController@show');
    $api->put('employees/{id}', 'EmployeesController@update');
    $api->delete('employees/{id}', 'EmployeesController@destroy');

//  Organizations

    $api->get('organizations', 'OrganizationsController@index');
    $api->post('organizations', 'OrganizationsController@store');
    $api->get('organizations/{id}', 'OrganizationsController@show');
    $api->put('organizations/{id}', 'OrganizationsController@update');
    $api->delete('organizations/{id}', 'OrganizationsController@destroy');

//  Permissions

    $api->get('permissions', 'PermissionsController@index');
    $api->post('permissions', 'PermissionsController@store');
    $api->get('permissions/{id}', 'PermissionsController@show');
    $api->put('permissions/{id}', 'PermissionsController@update');
    $api->delete('permissions/{id}', 'PermissionsController@destroy');

//  Roles

    $api->get('roles', 'RolesController@index');
    $api->post('roles', 'RolesController@store');
    $api->get('roles/{id}', 'RolesController@show');
    $api->put('roles/{id}', 'RolesController@update');
    $api->delete('roles/{id}', 'RolesController@destroy');

});

