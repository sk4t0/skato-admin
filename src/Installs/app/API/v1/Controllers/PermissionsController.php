<?php
/**
 * Created by PhpStorm.
 * User: skato
 * Date: 22/09/17
 * Time: 17.29
 */

namespace App\Http\API\Controllers;

use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use App\Http\API\Controllers\Controller;

use App\Permission;
use App\Transformers\PermissionsTransformer;


/**
 * Permissions resource representation.
 *
 * @Resource("Permissions", uri="/permissions")
 */
class PermissionsController extends Controller
{
    use Helpers;

    /**
     * Display a listing of the Permissions.
     *
     * Get a JSON representation of all the Permissions.
     *
     * @Get("")
     * @Versions({"v1"})
     * @Response(200, body={"id": "id", "name": "name", "display_name": "display_name"})
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {

        $permissions = Permission::all();
        return $this->response->collection($permissions, new PermissionsTransformer);

    }

    /**
     * Display the specified Permission.
     *
     * Get a JSON representation of the single Permission.
     *
     * @Get("/{id}")
     * @Versions({"v1"})
     * @Response(200, body={"id": "id", "name": "name", "display_name": "display_name"})
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="The id for the Permission")
     * })
     *
     * @param  int  $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {

        $permission = Permission::findOrFail($id);
        return $this->response->item($permission, new PermissionsTransformer);

    }

    /**
     * Store a new Permission
     *
     * Register a new Permission with a `name` .
     *
     * @Post("")
     * @Versions({"v1"})
     * @Request({"name": "name", "display_name": "display_name"})
     * @Response(200, body={"id": "id", "name": "name", "display_name": "display_name"})
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(Request $request)
    {
        $permission = Permission::create($request->all());
        return $this->response->item($permission, new PermissionsTransformer);
    }

    /**
     * Update an Permission
     *
     * Update a Permission with a `name` .
     *
     * @Put("/{id}")
     * @Versions({"v1"})
     * @Request({"name": "name", "display_name": "display_name"})
     * @Response(200, body={"id": "id", "name": "name", "display_name": "display_name"})
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="The id for the Permission")
     * })
     *
     * @param Request $request
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id)->update($request->all());
        return $this->response->item($permission, new PermissionsTransformer);
    }

    /**
     * Destroy an Permission
     *
     * Destroy a single Permission. No content returned
     *
     * @Delete("/{id}")
     * @Versions({"v1"})
     * @Response(204)
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="The id for the Permission")
     * })
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id)->delete();
        return $this->response->noContent();
    }

}