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

use App\Models\Department;
use App\Transformers\DepartmentsTransformer;


/**
 * Departments resource representation.
 *
 * @Resource("Departments", uri="/departments")
 */
class DepartmentsController extends Controller
{
    use Helpers;

    /**
     * Display a listing of the Departments.
     *
     * Get a JSON representation of all the Departments.
     *
     * @Get("")
     * @Versions({"v1"})
     * @Response(200, body={"id": "id", "name": "name"})
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {

        $departments = Department::all();
        return $this->response->collection($departments, new DepartmentsTransformer);

    }

    /**
     * Display the specified department.
     *
     * Get a JSON representation of the single department.
     *
     * @Get("/{id}")
     * @Versions({"v1"})
     * @Response(200, body={"id": "id", "name": "name"})
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="The id for the department")
     * })
     *
     * @param  int  $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {

        $department = Department::findOrFail($id);
        return $this->response->item($department, new DepartmentsTransformer);

    }

    /**
     * Store a new department
     *
     * Register a new department with a `name` .
     *
     * @Post("")
     * @Versions({"v1"})
     * @Request("name=name", contentType="application/x-www-form-urlencoded")
     * @Response(200, body={"id": "id", "name": "name"})
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(Request $request)
    {
        $department = Department::create($request->all());
        return $this->response->item($department, new DepartmentsTransformer);
    }

    /**
     * Update a department
     *
     * Update a department with a `name` .
     *
     * @Put("/{id}")
     * @Versions({"v1"})
     * @Request("name=name", contentType="application/x-www-form-urlencoded")
     * @Response(200, body={"id": "id", "name": "name"})
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="The id for the department")
     * })
     *
     * @param Request $request
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id)->update($request->all());
        return $this->response->item($department, new DepartmentsTransformer);
    }

    /**
     * Destroy a department
     *
     * Destroy a single department. No content returned
     *
     * @Delete("/{id}")
     * @Versions({"v1"})
     * @Response(204)
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="The id for the department")
     * })
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function destroy($id)
    {
        $department = Department::findOrFail($id)->delete();
        return $this->response->noContent();
    }

}