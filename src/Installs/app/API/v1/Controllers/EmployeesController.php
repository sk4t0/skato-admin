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

use App\Models\Employee;
use App\Transformers\EmployeesTransformer;


/**
 * Employees resource representation.
 *
 * @Resource("Employees", uri="/employees")
 */
class EmployeesController extends Controller
{
    use Helpers;

    /**
     * Display a listing of the Employees.
     *
     * Get a JSON representation of all the Employees.
     *
     * @Get("")
     * @Versions({"v1"})
     * @Response(200, body={"id": "id", "name": "name", "designation": "designation", "mobile": "mobile", "email": "email", "dept": "dept"})
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {

        $employees = Employee::all();
        return $this->response->collection($employees, new EmployeesTransformer);

    }

    /**
     * Display the specified employee.
     *
     * Get a JSON representation of the single employee.
     *
     * @Get("/{id}")
     * @Versions({"v1"})
     * @Response(200, body={"id": "id", "name": "name", "designation": "designation", "mobile": "mobile", "email": "email", "dept": "dept"})
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="The id for the employee")
     * })
     *
     * @param  int  $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {

        $employee = Employee::findOrFail($id);
        return $this->response->item($employee, new EmployeesTransformer);

    }

    /**
     * Store a new employee
     *
     * Register a new employee with a `name` .
     *
     * @Post("")
     * @Versions({"v1"})
     * @Request({"name": "name", "designation": "designation", "mobile": "mobile", "email": "email", "dept": "dept"})
     * @Response(200, body={"id": "id", "name": "name", "designation": "designation", "mobile": "mobile", "email": "email", "dept": "dept"})
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(Request $request)
    {
        $employee = Employee::create($request->all());
        return $this->response->item($employee, new EmployeesTransformer);
    }

    /**
     * Update an employee
     *
     * Update a employee with a `name` .
     *
     * @Put("/{id}")
     * @Versions({"v1"})
     * @Request({"name": "name", "designation": "designation", "mobile": "mobile", "email": "email", "dept": "dept"})
     * @Response(200, body={"id": "id", "name": "name", "designation": "designation", "mobile": "mobile", "email": "email", "dept": "dept"})
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="The id for the employee")
     * })
     *
     * @param Request $request
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id)->update($request->all());
        return $this->response->item($employee, new EmployeesTransformer);
    }

    /**
     * Destroy an employee
     *
     * Destroy a single employee. No content returned
     *
     * @Delete("/{id}")
     * @Versions({"v1"})
     * @Response(204)
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="The id for the employee")
     * })
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id)->delete();
        return $this->response->noContent();
    }

}