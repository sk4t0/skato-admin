<?php
/**
 * Config generated using LaraAdmin
 * Help: http://laraadmin.com
 * LaraAdmin is open-sourced software licensed under the MIT license.
 * Developed by: Dwij IT Solutions
 * Developer Website: http://dwijitsolutions.com
 */

return [
    
	/*
    |--------------------------------------------------------------------------
    | General Configuration
    |--------------------------------------------------------------------------
    */
    
	'adminRoute' => 'admin',
    
    /*
    |--------------------------------------------------------------------------
    | Uploads Configuration
    |--------------------------------------------------------------------------
    |
    | private_uploads: Uploaded file remains private and can be seen by respective owners + Super Admin only
    | default_public: Will make default uploads public / private
	| allow_filename_change: allows user to modify filenames after upload. Changes will be only in Database not on actual files.
    | 
    */
    'uploads' => [
        'private_uploads' => false,
        'default_public' => false,
        'allow_filename_change' => true
    ],

    /*
    |--------------------------------------------------------------------------
    | API Configuration
    |--------------------------------------------------------------------------
    |
    | routes_file: File containing the API endpoints
    | controllers: Directory containing the API controllers
    | transformers: Directory containing the API transformers
    |
    */

    'api' => [
        'routes_file' => 'app/http/API/v1/api_routes.php',
        'controllers' => 'app/http/API/v1/Controllers',
        'transformers' => 'app/http/API/v1/Transformers'
    ],
];