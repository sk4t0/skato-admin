<?php
/**
 * Code generated using SkatoAdmin
 * Help: http://skato-admin.com
 * SkatoAdmin is open-sourced software licensed under the MIT license.
 * Developed by: Dwij IT Solutions
 * Developer Website: http://skatoitsolutions.com
 */

namespace Skato\SkatoAdmin\Commands;

use Illuminate\Console\Command;

use Skato\SkatoAdmin\CodeGenerator;

/**
 * Class Migration
 * @package Skato\SkatoAdmin\Commands
 *
 * Command to generation new sample migration file or complete migration file from DB Context
 * if '--generate' parameter is used after command, it generate migration from database.
 */
class Migration extends Command
{
    // The command signature.
    protected $signature = 'sk:migration {table} {--generate}';
    
    // The command description.
    protected $description = 'Generate Migrations for SkatoAdmin';
    
    /**
     * Generate a Migration file either sample or from DB Context
     *
     * @return mixed
     */
    public function handle()
    {
        $table = $this->argument('table');
        $generateFromTable = $this->option('generate');
        if($generateFromTable) {
            $generateFromTable = true;
        }
        CodeGenerator::generateMigration($table, $generateFromTable, $this);
    }
}
