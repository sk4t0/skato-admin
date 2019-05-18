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

use App\Role;
use App\Transformers\RolesTransformer;


/**
 * Roles resource representation.
 *
 * @Resource("Roles", uri="/roles")
 */
class RolesController extends Controller
{
    use Helpers;

    /**
     * Display a listing of the Roles.
     *
     * Get a JSON representation of all the Roles.
     *
     * @Get("")
     * @Versions({"v1"})
     * @Response(200, body={"id": "id", "name": "name", "display_name": "display_name", "parent": "parent", "dept": "dept"})
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {

        $permissions = Role::all();
        return $this->response->collection($permissions, new RolesTransformer);

    }

    /**
     * Display the specified Role.
     *
     * Get a JSON representation of the single Role.
     *
     * @Get("/{id}")
     * @Versions({"v1"})
     * @Response(200, body={"id": "id", "name": "name", "display_name": "display_name", "parent": "parent", "dept": "dept"})
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="The id for the Role")
     * })
     *
     * @param  int  $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {

        $permission = Role::findOrFail($id);
        return $this->response->item($permission, new RolesTransformer);

    }

    /**
     * Store a new Role
     *
     * Register a new Role with a `name` .
     *
     * @Post("")
     * @Versions({"v1"})
     * @Request({"name": "name", "display_name": "display_name", "parent": "parent", "dept": "dept"})
     * @Response(200, body={"id": "id", "name": "name", "display_name": "display_name", "parent": "parent", "dept": "dept"})
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(Request $request)
    {
        $permission = Role::create($request->all());
        return $this->response->item($permission, new RolesTransformer);
    }

    /**
     * Update a Role
     *
     * Update a Role with a `name` .
     *
     * @Put("/{id}")
     * @Versions({"v1"})
     * @Request({"name": "name", "display_name": "display_name", "parent": "parent", "dept": "dept"})
     * @Response(200, body={"id": "id", "name": "name", "display_name": "display_name", "parent": "parent", "dept": "dept"})
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="The id for the Role")
     * })
     *
     * @param Request $request
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function update(Request $request, $id)
    {
        $permission = Role::findOrFail($id)->update($request->all());
        return $this->response->item($permission, new RolesTransformer);
    }

    /**
     * Destroy an Role
     *
     * Destroy a single Permission. No content returned
     *
     * @Delete("/{id}")
     * @Versions({"v1"})
     * @Response(204)
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="The id for the Role")
     * })
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function destroy($id)
    {
        $permission = Role::findOrFail($id)->delete();
        return $this->response->noContent();
    }

}