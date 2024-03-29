<?php
/**
 * Code generated using SkatoAdmin
 * Help: http://skato-admin.com
 * SkatoAdmin is open-sourced software licensed under the MIT license.
 * Developed by: Skato IT Solutions
 * Developer Website: http://skatoitsolutions.com
 */

namespace Skato\SkatoAdmin;

use Exception;
use Illuminate\Filesystem\Filesystem;
use Skato\SkatoAdmin\Models\Module;
use Skato\SkatoAdmin\Models\ModuleFieldTypes;
use Skato\SkatoAdmin\Helpers\skHelper;
use Skato\SkatoAdmin\Models\Menu;

/**
 * Class CodeGenerator
 * @package Skato\SkatoAdmin
 *
 * This class performs the Code Generation for Controller, Model, CRUDs Views, Routes, Menu and Migrations.
 * This also generates the naming config which contains names for controllers, tables and everything required
 * to generate CRUDs.
 */
class CodeGenerator
{
    /**
     * Generate Controller file
     *
     * @param $config config object storing the Module Names
     * @param null $comm command Object
     */
    public static function createController($config, $comm = null)
    {
        
        $templateDirectory = __DIR__ . '/stubs';
        
        skHelper::log("info", "Creating controller...", $comm);
        $md = file_get_contents($templateDirectory . "/controller.stub");
        
        $md = str_replace("__controller_class_name__", $config->controllerName, $md);
        $md = str_replace("__model_name__", $config->modelName, $md);
        $md = str_replace("__module_name__", $config->moduleName, $md);
        $md = str_replace("__view_column__", $config->module->view_col, $md);
        
        // Listing columns
        $listing_cols = "'id',";
        $request_cols = '';
        $response_cols = '"id": "id", ';
        $transformer_cols = '"id" => (int) $' . $config->singularVar . '->id, ' . PHP_EOL;
        foreach($config->module->fields as $field) {

            $listing_cols .= "'" . $field['colname'] . "', ";
            $response_cols .= '"' . $field['colname'] . '": "' . $field['colname'] . '", ';
            $transformer_cols .= '            "' . $field['colname'] . '" => $' . $config->singularVar . '->' . $field['colname'] . ', ' . PHP_EOL;
            $request_cols .= '"' . $field['colname'] . '": "'. $field['colname'] . '", ';
        }
        $listing_cols = trim($listing_cols, ", ");
        $request_cols = trim($request_cols, ", ");
        $response_cols = trim($response_cols, ", ");

        $md = str_replace("__listing_cols__", $listing_cols, $md);
        $md = str_replace("__view_folder__", $config->dbTableName, $md);
        $md = str_replace("__route_resource__", $config->dbTableName, $md);
        $md = str_replace("__db_table_name__", $config->dbTableName, $md);
        $md = str_replace("__singular_var__", $config->singularVar, $md);
        
        file_put_contents(base_path('app/Http/Controllers/SK/' . $config->controllerName . ".php"), $md);

        skHelper::log("info", "Creating API controller...", $comm);
        $apimd = file_get_contents($templateDirectory . "/controller_api.stub");

        $apimd = str_replace("__controller_class_name__", $config->controllerName, $apimd);
        $apimd = str_replace("__model_name__", $config->modelName, $apimd);
        $apimd = str_replace("__listing_cols__", $listing_cols, $apimd);
        $apimd = str_replace("__request_cols__", $request_cols, $apimd);
        $apimd = str_replace("__response_cols__", $response_cols, $apimd);
        $apimd = str_replace("__singular_var__", $config->singularVar, $apimd);

        file_put_contents(base_path('app/Http/API/v1/Controllers/' . $config->controllerName . ".php"), $apimd);

        skHelper::log("info", "Creating Transformer...", $comm);
        $trmd = file_get_contents($templateDirectory . "/transformer.stub");

        $trmd = str_replace("__model_name__", $config->modelName, $trmd);
        $trmd = str_replace("__transformer_cols__", $transformer_cols, $trmd);
        $trmd = str_replace("__singular_var__", $config->singularVar, $trmd);

        file_put_contents(base_path('app/Http/API/v1/Transformers/' . $config->modelName . "sTransformer.php"), $trmd);

    }
    
    /**
     * Generate Model file
     *
     * @param $config config object storing the Module Names
     * @param null $comm command Object
     */
    public static function createModel($config, $comm = null)
    {
        
        $templateDirectory = __DIR__ . '/stubs';
        
        skHelper::log("info", "Creating model...", $comm);
        $md = file_get_contents($templateDirectory . "/model.stub");
        
        $md = str_replace("__model_class_name__", $config->modelName, $md);
        $md = str_replace("__db_table_name__", $config->dbTableName, $md);

        // Listing columns
        $listing_cols = "";
        foreach($config->module->fields as $field) {
            $listing_cols .= "'" . $field['colname'] . "', ";
        }

        $md = str_replace("__listing_cols__", $listing_cols, $md);
        
        file_put_contents(base_path('app/Models/' . $config->modelName . ".php"), $md);
    }
    
    /**
     * Generate Views for CRUD
     *
     * @param $config config object storing the Module Names
     * @param null $comm command Object
     */
    public static function createViews($config, $comm = null)
    {
        
        $templateDirectory = __DIR__ . '/stubs';
        
        skHelper::log("info", "Creating views...", $comm);
        // Create Folder
        @mkdir(base_path("resources/views/sk/" . $config->dbTableName), 0777, true);
        
        // ============================ Listing / Index ============================
        $md = file_get_contents($templateDirectory . "/views/index.blade.stub");
        
        $md = str_replace("__module_name__", $config->moduleName, $md);
        $md = str_replace("__db_table_name__", $config->dbTableName, $md);
        $md = str_replace("__controller_class_name__", $config->controllerName, $md);
        $md = str_replace("__singular_var__", $config->singularVar, $md);
        $md = str_replace("__singular_cap_var__", $config->singularCapitalVar, $md);
        $md = str_replace("__module_name_2__", $config->moduleName2, $md);
        
        // Listing columns
        $inputFields = "";
        foreach($config->module->fields as $field) {
            $inputFields .= "\t\t\t\t\t@la_input($" . "module, '" . $field['colname'] . "')\n";
        }
        $inputFields = trim($inputFields);
        $md = str_replace("__input_fields__", $inputFields, $md);
        
        file_put_contents(base_path('resources/views/sk/' . $config->dbTableName . '/index.blade.php'), $md);
        
        // ============================ Edit ============================
        $md = file_get_contents($templateDirectory . "/views/edit.blade.stub");
        
        $md = str_replace("__module_name__", $config->moduleName, $md);
        $md = str_replace("__db_table_name__", $config->dbTableName, $md);
        $md = str_replace("__controller_class_name__", $config->controllerName, $md);
        $md = str_replace("__singular_var__", $config->singularVar, $md);
        $md = str_replace("__singular_cap_var__", $config->singularCapitalVar, $md);
        $md = str_replace("__module_name_2__", $config->moduleName2, $md);
        
        // Listing columns
        $inputFields = "";
        foreach($config->module->fields as $field) {
            $inputFields .= "\t\t\t\t\t@la_input($" . "module, '" . $field['colname'] . "')\n";
        }
        $inputFields = trim($inputFields);
        $md = str_replace("__input_fields__", $inputFields, $md);
        
        file_put_contents(base_path('resources/views/sk/' . $config->dbTableName . '/edit.blade.php'), $md);
        
        // ============================ Show ============================
        $md = file_get_contents($templateDirectory . "/views/show.blade.stub");
        
        $md = str_replace("__module_name__", $config->moduleName, $md);
        $md = str_replace("__db_table_name__", $config->dbTableName, $md);
        $md = str_replace("__singular_var__", $config->singularVar, $md);
        $md = str_replace("__singular_cap_var__", $config->singularCapitalVar, $md);
        $md = str_replace("__module_name_2__", $config->moduleName2, $md);
        
        // Listing columns
        $displayFields = "";
        foreach($config->module->fields as $field) {
            $displayFields .= "\t\t\t\t\t\t@la_display($" . "module, '" . $field['colname'] . "')\n";
        }
        $displayFields = trim($displayFields);
        $md = str_replace("__display_fields__", $displayFields, $md);
        
        file_put_contents(base_path('resources/views/sk/' . $config->dbTableName . '/show.blade.php'), $md);
    }
    
    /**
     * Append module controller routes to admin_routes.php
     *
     * @param $config config object storing the Module Names
     * @param null $comm command Object
     */
    public static function appendRoutes($config, $comm = null)
    {
        
        $templateDirectory = __DIR__ . '/stubs';
        
        skHelper::log("info", "Appending routes...", $comm);
        if(\Skato\SkatoAdmin\Helpers\skHelper::laravel_ver() == 5.3) {
            $routesFile = base_path('routes/admin_routes.php');
        } else {
            $routesFile = app_path('Http/admin_routes.php');
        }
        
        $contents = file_get_contents($routesFile);
        $contents = str_replace('});', '', $contents);
        file_put_contents($routesFile, $contents);
        
        $md = file_get_contents($templateDirectory . "/routes.stub");
        
        $md = str_replace("__module_name__", $config->moduleName, $md);
        $md = str_replace("__controller_class_name__", $config->controllerName, $md);
        $md = str_replace("__db_table_name__", $config->dbTableName, $md);
        $md = str_replace("__singular_var__", $config->singularVar, $md);
        $md = str_replace("__singular_cap_var__", $config->singularCapitalVar, $md);
        
        file_put_contents($routesFile, $md, FILE_APPEND);


        skHelper::log("info", "Appending api routes...", $comm);
            $routesFileApi = app_path('Http/API/v1/api_routes.php');

        $contents = file_get_contents($routesFileApi);
        $contents = str_replace('});', '', $contents);
        file_put_contents($routesFileApi, $contents);

        $mdapi = file_get_contents($templateDirectory . "/routes_api.stub");

        $mdapi = str_replace("__module_name__", $config->moduleName, $mdapi);
        $mdapi = str_replace("__controller_class_name__", $config->controllerName, $mdapi);
        $mdapi = str_replace("__singular_var__", $config->singularVar, $mdapi);

        file_put_contents($routesFileApi, $mdapi, FILE_APPEND);
    }
    
    /**
     * Add Module to Menu
     *
     * @param $config config object storing the Module Names
     * @param null $comm command Object
     */
    public static function addMenu($config, $comm = null)
    {
        
        // $templateDirectory = __DIR__.'/stubs';
        
        skHelper::log("info", "Appending Menu...", $comm);
        if(Menu::where("url", $config->dbTableName)->count() == 0) {
            Menu::create([
                "name" => $config->moduleName,
                "url" => $config->dbTableName,
                "icon" => "fa " . $config->fa_icon,
                "type" => 'module',
                "parent" => 0
            ]);
        }
        
        // Old Method to add Menu
        // $menu = '<li><a href="{{ url(config("skato-admin.adminRoute") . '."'".'/'.$config->dbTableName."'".') }}"><i class="fa fa-cube"></i> <span>'.$config->moduleName.'</span></a></li>'."\n".'            <!-- LAMenus -->';
        // $md = file_get_contents(base_path('resources/views/sk/layouts/partials/sidebar.blade.php'));
        // $md = str_replace("<!-- LAMenus -->", $menu, $md);
        // file_put_contents(base_path('resources/views/sk/layouts/partials/sidebar.blade.php'), $md);
    }
    
    /**
     * Generate migration file
     *
     * CodeGenerator::generateMigration($table, $generateFromTable);
     *
     * @param $table table name
     * @param bool $generate true then create file from module info from DB
     * @param null $comm command Object
     * @throws Exception
     */
    public static function generateMigration($table, $generate = false, $comm = null)
    {
        $filesystem = new Filesystem();
        
        if(starts_with($table, "create_")) {
            $tname = str_replace("create_", "", $table);
            $table = str_replace("_table", "", $tname);
        }
        
        $modelName = ucfirst(str_singular($table));
        $tableP = str_plural(strtolower($table));
        $tableS = str_singular(strtolower($table));
        $migrationName = 'create_' . $tableP . '_table';
        $migrationFileName = date("Y_m_d_His_") . $migrationName . ".php";
        $migrationClassName = ucfirst(camel_case($migrationName));
        $dbTableName = $tableP;
        $moduleName = ucfirst(str_plural($table));
        
        skHelper::log("info", "Model:\t   " . $modelName, $comm);
        skHelper::log("info", "Module:\t   " . $moduleName, $comm);
        skHelper::log("info", "Table:\t   " . $dbTableName, $comm);
        skHelper::log("info", "Migration: " . $migrationName . "\n", $comm);
        
        // Reverse migration generation from table
        $generateData = "";
        $viewColumnName = "view_column_name e.g. name";
        
        // fa_icon
        $faIcon = "fa-cube";
        
        if($generate) {
            // check if table, module and module fields exists
            $module = Module::get($moduleName);
            if(isset($module)) {
                skHelper::log("info", "Module exists :\t   " . $moduleName, $comm);
                
                $viewColumnName = $module->view_col;
                $faIcon = $module->fa_icon;
                
                $ftypes = ModuleFieldTypes::getFTypes2();
                foreach($module->fields as $field) {
                    $ftype = $ftypes[$field['field_type']];
                    $unique = "false";
                    if($field['unique']) {
                        $unique = "true";
                    }
                    $dvalue = "";
                    if($field['defaultvalue'] != "") {
                        if(starts_with($field['defaultvalue'], "[")) {
                            $dvalue = $field['defaultvalue'];
                        } else {
                            $dvalue = '"' . $field['defaultvalue'] . '"';
                        }
                    } else {
                        $dvalue = '""';
                    }
                    $minlength = $field['minlength'];
                    $maxlength = $field['maxlength'];
                    $required = "false";
                    if($field['required']) {
                        $required = "true";
                    }
                    $listing_col = "false";
                    if($field['listing_col']) {
                        $listing_col = "true";
                    }
                    $values = "";
                    if($field['popup_vals'] != "") {
                        if(starts_with($field['popup_vals'], "[")) {
                            $values = $field['popup_vals'];
                        } else {
                            $values = '"' . $field['popup_vals'] . '"';
                        }
                    }
                    // $generateData .= '["'.$field['colname'].'", "'.$field['label'].'", "'.$ftype.'", '.$unique.', '.$dvalue.', '.$minlength.', '.$maxlength.', '.$required.''.$values.'],'."\n            ";
                    $generateData .= "[" .
                        "\n                \"colname\" => \"" . $field['colname'] . "\"," .
                        "\n                \"label\" => \"" . $field['label'] . "\"," .
                        "\n                \"field_type\" => \"" . $ftype . "\"," .
                        "\n                \"unique\" => " . $unique . "," .
                        "\n                \"defaultvalue\" => " . $dvalue . "," .
                        "\n                \"minlength\" => " . $minlength . "," .
                        "\n                \"maxlength\" => " . $maxlength . "," .
                        "\n                \"required\" => " . $required . ",";
                    
                    if($values != "") {
                        $generateData .= "\n                \"listing_col\" => " . $listing_col . ",";
                        $generateData .= "\n                \"popup_vals\" => " . $values . ",";
                    } else {
                        $generateData .= "\n                \"listing_col\" => " . $listing_col . "";
                    }
                    $generateData .= "\n            ], ";
                }
                $generateData = trim($generateData, ", ");
                
                // Find existing migration file
                $mfiles = scandir(base_path('database/migrations/'));
                // print_r($mfiles);
                $fileExists = false;
                $fileExistName = "";
                foreach($mfiles as $mfile) {
                    if(str_contains($mfile, $migrationName)) {
                        $fileExists = true;
                        $fileExistName = $mfile;
                    }
                }
                if($fileExists) {
                    skHelper::log("info", "Replacing old migration file: " . $fileExistName, $comm);
                    $migrationFileName = $fileExistName;
                } else {
                    // If migration not exists in migrations table
                    if(\DB::table('migrations')->where('migration', 'like', '%' . $migrationName . '%')->count() == 0) {
                        \DB::table('migrations')->insert([
                            'migration' => str_replace(".php", "", $migrationFileName),
                            'batch' => 1
                        ]);
                    }
                }
            } else {
                skHelper::log("error", "Module " . $moduleName . " doesn't exists; Cannot generate !!!", $comm);
            }
        }
        
        $templateDirectory = __DIR__ . '/stubs';
        
        try {
            skHelper::log("line", "Creating migration...", $comm);
            $migrationData = file_get_contents($templateDirectory . "/migration.stub");
            
            $migrationData = str_replace("__migration_class_name__", $migrationClassName, $migrationData);
            $migrationData = str_replace("__db_table_name__", $dbTableName, $migrationData);
            $migrationData = str_replace("__module_name__", $moduleName, $migrationData);
            $migrationData = str_replace("__model_name__", $modelName, $migrationData);
            $migrationData = str_replace("__view_column__", $viewColumnName, $migrationData);
            $migrationData = str_replace("__fa_icon__", $faIcon, $migrationData);
            $migrationData = str_replace("__generated__", $generateData, $migrationData);
            
            file_put_contents(base_path('database/migrations/' . $migrationFileName), $migrationData);

            // Load newly generated migration into environment. Needs in testing mode.
            require_once base_path('database/migrations/'.$migrationFileName);
            
        } catch(Exception $e) {
            throw new Exception("Unable to generate migration for " . $table . " : " . $e->getMessage(), 1);
        }
        skHelper::log("info", "Migration done: " . $migrationFileName . "\n", $comm);
    }
    
    /**
     * Generate naming configuration for passed module required to generate
     * CRUDs, Model, Controller and Migration files
     *
     * $config = CodeGenerator::generateConfig($module_name);
     *
     * @param $module Module table in lowercase
     * @param $icon Module icon - FontAwesome
     * @return object Config Object with different names of Module
     * @throws Exception When Migration for this Module is not done
     */
    public static function generateConfig($module, $icon)
    {
        $config = array();
        $config = (object)$config;
        
        if(starts_with($module, "create_")) {
            $tname = str_replace("create_", "", $module);
            $module = str_replace("_table", "", $tname);
        }
        
        $config->modelName = ucfirst(str_singular($module));
        $tableP = str_plural(strtolower($module));
        $tableS = str_singular(strtolower($module));
        $config->dbTableName = $tableP;
        $config->fa_icon = $icon;
        $config->moduleName = ucfirst(str_plural($module));
        $config->moduleName2 = str_replace('_', ' ', ucfirst(str_plural($module)));
        $config->controllerName = ucfirst(str_plural($module)) . "Controller";
        $config->singularVar = strtolower(str_singular($module));
        $config->singularCapitalVar = str_replace('_', ' ', ucfirst(str_singular($module)));
        
        $module = Module::get($config->moduleName);
        if(!isset($module->id)) {
            throw new Exception("Please run 'php artisan migrate' for 'create_" . $config->dbTableName . "_table' in order to create CRUD.\nOr check if any problem in Module Name '" . $config->moduleName . "'.", 1);
            return;
        }
        $config->module = $module;
        
        return $config;
    }
}
