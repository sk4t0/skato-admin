<?php

use Illuminate\Database\Seeder;

use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;
use Dwij\Laraadmin\Models\ModuleFieldTypes;
use Dwij\Laraadmin\Models\Menu;
use Dwij\Laraadmin\Models\LAConfigs;

use App\Role;
use App\Permission;
use App\Models\Department;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /* ================ LaraAdmin Seeder Code ================ */

        // Generating Module Menus
        $modules = Module::all();
        $teamMenu = Menu::firstOrCreate([
            "name" => "File Manager",
            "url" => "file-manager",
            "icon" => "fa-folder-open",
            "type" => 'custom',
            "parent" => 0,
            "hierarchy" => 0
        ]);
        $teamMenu = Menu::firstOrCreate([
            "name" => "Team",
            "url" => "#",
            "icon" => "fa-group",
            "type" => 'custom',
            "parent" => 0,
            "hierarchy" => 1
        ]);
        foreach ($modules as $module) {
            $parent = 0;
            if($module->name != "Backups" && $module->name != "Uploads") {
                if(in_array($module->name, ["Users", "Departments", "Employees", "Roles", "Permissions"])) {
                    $parent = $teamMenu->id;
                }
                Menu::firstOrCreate([
                    "name" => $module->name,
                    "url" => $module->name_db,
                    "icon" => $module->fa_icon,
                    "type" => 'module',
                    "parent" => $parent
                ]);
            }
        }

        // Create Administration Department
        $dept = Department::firstOrNew(["name" => "Administration"]);
        $dept->tags = "[]";
        $dept->color = "#000";
        if ($dept->id == null) {
            $dept->save();
        }
        // Create Super Admin Role
        $role = Role::firstOrNew(["name" => "SUPER_ADMIN"]);
        $role->display_name = "Super Admin";
        $role->description = "Full Access Role";
        $role->parent = 1;
        $role->dept = $dept->id;
        if ($role->id == null) {
            $role->save();
        }

        // Set Full Access For Super Admin Role
        foreach ($modules as $module) {
            Module::setDefaultRoleAccess($module->id, $role->id, "full");
        }

        // Create Admin Panel Permission
        $perm = Permission::firstOrNew(["name" => "ADMIN_PANEL"]);
        $perm->display_name = "Admin Panel";
        $perm->description = "Admin Panel Permission";
        if ($perm->id == null) {
            $perm->save();
        }
        if (! $role->perms->contains($perm->id)) {
            $role->attachPermission($perm);
        }

        // Generate LaraAdmin Default Configurations

        $laconfig = LAConfigs::firstOrNew(["key" => "sitename"]);
        $laconfig->value = "AdminBase 1.0";
        if ($laconfig->id == null) {
            $laconfig->save();
        }

        $laconfig = LAConfigs::firstOrNew(["key" => "sitename_part1"]);
        $laconfig->value = "Admin";
        if ($laconfig->id == null) {
            $laconfig->save();
        }
        $laconfig = LAConfigs::firstOrNew(["key" => "sitename_part2"]);
        $laconfig->value = "Base 1.0";
        if ($laconfig->id == null) {
            $laconfig->save();
        }
        $laconfig = LAConfigs::firstOrNew(["key" => "sitename_short"]);
        $laconfig->value = "AB";
        if ($laconfig->id == null) {
            $laconfig->save();
        }
        $laconfig = LAConfigs::firstOrNew(["key" => "site_description"]);
        $laconfig->value = "Admin Base is a base solution to have a working base admin panel with integrated CRUD booth for API and WebApp, automatic API documentation";
        if ($laconfig->id == null) {
            $laconfig->save();
        }
        // Display Configurations

        $laconfig = LAConfigs::firstOrNew(["key" => "sidebar_search"]);
        $laconfig->value = "1";
        if ($laconfig->id == null) {
            $laconfig->save();
        }
        $laconfig = LAConfigs::firstOrNew(["key" => "show_messages"]);
        $laconfig->value = "1";
        if ($laconfig->id == null) {
            $laconfig->save();
        }
        $laconfig = LAConfigs::firstOrNew(["key" => "show_notifications"]);
        $laconfig->value = "1";
        if ($laconfig->id == null) {
            $laconfig->save();
        }
        $laconfig = LAConfigs::firstOrNew(["key" => "show_tasks"]);
        $laconfig->value = "1";
        if ($laconfig->id == null) {
            $laconfig->save();
        }
        $laconfig = LAConfigs::firstOrNew(["key" => "show_rightsidebar"]);
        $laconfig->value = "1";
        if ($laconfig->id == null) {
            $laconfig->save();
        }
        $laconfig = LAConfigs::firstOrNew(["key" => "skin"]);
        $laconfig->value = "skin-green";
        if ($laconfig->id == null) {
            $laconfig->save();
        }
        $laconfig = LAConfigs::firstOrNew(["key" => "layout"]);
        $laconfig->value = "fixed";
        if ($laconfig->id == null) {
            $laconfig->save();
        }
        // Admin Configurations

        $laconfig = LAConfigs::firstOrNew(["key" => "default_email"]);
        $laconfig->value = "test@example.com";
        if ($laconfig->id == null) {
            $laconfig->save();
        }
        $modules = Module::all();
        foreach ($modules as $module) {
            $module->is_gen=true;
            $module->save();
        }
    }
}
