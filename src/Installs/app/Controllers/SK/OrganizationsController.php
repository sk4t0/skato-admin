<?php
/**
 * Controller genrated using SkatoAdmin
 * Help: http://skato-admin.com
 */

namespace App\Http\Controllers\SK;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;
use Validator;
use Datatables;
use Collective\Html\FormFacade as Form;
use Skato\SkatoAdmin\Models\Module;
use Skato\SkatoAdmin\Models\ModuleFields;
use Dingo\Api\Routing\Helpers;

use App\Models\Organization;

class OrganizationsController extends Controller
{
    use Helpers;
	public $show_action = true;
	public $view_col = 'name';
	public $listing_cols = ['id', 'profile_image', 'name', 'email', 'phone', 'website', 'assigned_to', 'city'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Skato\SkatoAdmin\Helpers\skHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Organizations', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Organizations', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Organizations.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Organizations');
		
		if(Module::hasAccess($module->id)) {
			return View('sk.organizations.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('skato-admin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new organization.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created organization in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Organizations", "create")) {
		
			$rules = Module::validateRules("Organizations", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Organizations", $request);
			
			return redirect()->route(config('skato-admin.adminRoute') . '.organizations.index');
			
		} else {
			return redirect(config('skato-admin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified organization.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Organizations", "view")) {
			
			$organization = $this->api->get('api/organizations/' . $id);
			if(isset($organization->id)) {
				$module = Module::get('Organizations');
				$module->row = $organization;
				
				return view('sk.organizations.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('organization', $organization);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("organization"),
				]);
			}
		} else {
            return redirect(config('skato-admin.adminRoute') . "/");
        }
	}

	/**
	 * Show the form for editing the specified organization.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Organizations", "edit")) {
			$organization = $this->api->get('api/organizations/' . $id);
			if(isset($organization->id)) {
				$organization = Organization::find($id);
				
				$module = Module::get('Organizations');
				
				$module->row = $organization;
				
				return view('sk.organizations.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('organization', $organization);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("organization"),
				]);
			}
		} else {
			return redirect(config('skato-admin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified organization in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Organizations", "edit")) {
			
			$rules = Module::validateRules("Organizations", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Organizations", $request, $id);
			
			return redirect()->route(config('skato-admin.adminRoute') . '.organizations.index');
			
		} else {
			return redirect(config('skato-admin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified organization from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Organizations", "delete")) {
            $this->api->delete('api/organizations/' . $id);
			
			// Redirecting to index() method
			return redirect()->route(config('skato-admin.adminRoute') . '.organizations.index');
		} else {
			return redirect(config('skato-admin.adminRoute')."/");
		}
	}
	
	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	public function dtajax()
	{
		$values = DB::table('organizations')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Organizations');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) {
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && $fields_popup[$col]->field_type_str == "Image") {
					if($data->data[$i][$j] != 0) {
						$img = \App\Models\Upload::find($data->data[$i][$j]);
						if(isset($img->name)) {
							$data->data[$i][$j] = '<img src="'.$img->path().'?s=50">';
						} else {
							$data->data[$i][$j] = "";
						}
					} else {
						$data->data[$i][$j] = "";
					}
				}
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('skato-admin.adminRoute') . '/organizations/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Organizations", "edit")) {
					$output .= '<a href="'.url(config('skato-admin.adminRoute') . '/organizations/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Organizations", "delete")) {
					$output .= Form::open(['route' => [config('skato-admin.adminRoute') . '.organizations.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($data);
		return $out;
	}
}
