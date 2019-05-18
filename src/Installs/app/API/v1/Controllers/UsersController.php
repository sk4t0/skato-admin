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

use App\User;
use App\Transformers\UsersTransformer;


/**
 * User resource representation.
 *
 * @Resource("Users", uri="/users")
 */
class UsersController extends Controller
{
    use Helpers;

    /**
     * Display a listing of the Users.
     *
     * Get a JSON representation of all the registered users.
     *
     * @Get("")
     * @Versions({"v1"})
     * @Response(200, body={"id": "id", "name": "name", "email": "email", "type": "type"})
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {

        $users = User::all();
        return $this->response->collection($users, new UsersTransformer);

    }

    /**
     * Display the specified user.
     *
     * Get a JSON representation of the single user.
     *
     * @Get("/{id}")
     * @Versions({"v1"})
     * @Response(200, body={"id": "id", "name": "name", "email": "email", "type": "type"})
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="The id for the user")
     * })
     *
     * @param  int  $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {

        $users = User::findOrFail($id);
        return $this->response->item($users, new UsersTransformer);

    }

    /**
     *  Store a new user
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        //
    }

    /**
     *  Update an user
     *
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     *  Destroy an user
     *
     * @param $id
     */
    public function destroy($id)
    {
        //
    }

}