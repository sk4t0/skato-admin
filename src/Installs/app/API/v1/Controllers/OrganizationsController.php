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

use App\Models\Organization;
use App\Transformers\OrganizationsTransformer;


/**
 * Organizations resource representation.
 *
 * @Resource("Organizations", uri="/organizations")
 */
class OrganizationsController extends Controller
{
    use Helpers;

    /**
     * Display a listing of the Organizations.
     *
     * Get a JSON representation of all the Organizations.
     *
     * @Get("")
     * @Versions({"v1"})
     * @Response(200, body={"id": "id", "name": "name", "profile_image": "profile_image", "phone": "phone", "email": "email", "website": "website", "assigned_to": "assigned_to", "city": "city"})
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {

        $organizations = Organization::all();
        return $this->response->collection($organizations, new OrganizationsTransformer);

    }

    /**
     * Display the specified Organization.
     *
     * Get a JSON representation of the single Organization.
     *
     * @Get("/{id}")
     * @Versions({"v1"})
     * @Response(200, body={"id": "id", "name": "name", "profile_image": "profile_image", "phone": "phone", "email": "email", "website": "website", "assigned_to": "assigned_to", "city": "city"})
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="The id for the Organization")
     * })
     *
     * @param  int  $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {

        $organization = Organization::findOrFail($id);
        return $this->response->item($organization, new OrganizationsTransformer);

    }

    /**
     * Store a new Organization
     *
     * Register a new Organization with a `name` .
     *
     * @Post("")
     * @Versions({"v1"})
     * @Request({"name": "name", "profile_image": "profile_image", "phone": "phone", "email": "email", "website": "website", "assigned_to": "assigned_to", "city": "city"})
     * @Response(200, body={"id": "id", "name": "name", "profile_image": "profile_image", "phone": "phone", "email": "email", "website": "website", "assigned_to": "assigned_to", "city": "city"})
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(Request $request)
    {
        $organization = Organization::create($request->all());
        return $this->response->item($organization, new OrganizationsTransformer);
    }

    /**
     * Update an Organization
     *
     * Update a Organization with a `name` .
     *
     * @Put("/{id}")
     * @Versions({"v1"})
     * @Request({"name": "name", "profile_image": "profile_image", "phone": "phone", "email": "email", "website": "website", "assigned_to": "assigned_to", "city": "city"})
     * @Response(200, body={"id": "id", "name": "name", "profile_image": "profile_image", "phone": "phone", "email": "email", "website": "website", "assigned_to": "assigned_to", "city": "city"})
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="The id for the Organization")
     * })
     *
     * @param Request $request
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function update(Request $request, $id)
    {
        $organization = Organization::findOrFail($id)->update($request->all());
        return $this->response->item($organization, new OrganizationsTransformer);
    }

    /**
     * Destroy an Organization
     *
     * Destroy a single Organization. No content returned
     *
     * @Delete("/{id}")
     * @Versions({"v1"})
     * @Response(204)
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="The id for the Organization")
     * })
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function destroy($id)
    {
        $organization = Organization::findOrFail($id)->delete();
        return $this->response->noContent();
    }

}