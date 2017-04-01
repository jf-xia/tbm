<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\Criteria\User\UsersWithRoles;
use App\Repositories\UserRepository as User;
use App\Repositories\RoleRepository as Role;
use Laracasts\Flash\Flash;

class UsersController extends Controller {

    /**
     * @var User
     */
    protected $user;

    /**
     * @param User $user
     * @param Role $role
     */
    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = $this->user->pushCriteria(UsersWithRoles::class)
            ->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
//        if(!$user->isAdmin()){
////            $users=$users->findWhere(['leader'=>$user->id]);
//            $users=$users->where('leader','=',$user->id);
//        }
//        if($email){
////            $users=$users->findWhere([['email','like','%'.$email.'%']]);
//            $users=$users->where('email','like','%'.$email.'%');
//        }
        $users=$users->paginate(10,['*'],\Auth::id());

        return view('users.index', compact('users','email'));
    }

    /**
     * @return \Illuminate\View\ajax
     */
    public function ajaxlist(Request $request)
    {
        $input = $request->all();
        $term='%'.$input['term'].'%';
        $userlist = DB::select("select id,concat(name,'[',email,']') as text from users where email LIKE :email or `name` LIKE :name LIMIT 20", ['email'=>$term,'name'=>$term]);
        return \Response::json($userlist);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $roles = $this->role->all();
        $auth = \Auth::user();
        return view('users.create', compact('roles','auth'));
    }

    /**
     * @param CreateUserRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreateUserRequest $request)
    {
        $user = $this->user->create($request->all());

        if($request->get('role'))
        {
            $user->roles()->sync($request->get('role'));
        }
        else
        {
            $user->roles()->sync([]);
        }

        return redirect('/users');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $user = $this->user->find($id);
        $roles = $this->role->all();
        $userRoles = $user->roles();
        $auth = \Auth::user();
        return view('users.edit', compact('user', 'roles', 'userRoles', 'auth'));
    }

    public function editmyself()
    {
        $user = $this->user->find(\Auth::id());
        return view('users.editmyself', compact('user'));
    }

    public function updatemyself(UpdateUserRequest $request)
    {
        $user = $this->user->find(\Auth::id());

        if($request->get('password'))
        {
            $user->bakpw = base64_encode($request->get('password'));
            $user->password = $request->get('password');
            $user->save();
        }

        Flash::success('User successfully updated');

        return redirect('/tasks');
    }

    /**
     * @param $id
     * @param UpdateUserRequest $request
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = $this->user->find($id);

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->leader = $request->get('leader');
        if($request->get('password'))
        {
            $user->bakpw = $request->get('password');
            $user->password = $request->get('password');
        }
        $user->save();

        if($request->get('role'))
        {
            $user->roles()->sync($request->get('role'));
        }
        else
        {
            $user->roles()->sync([]);
        }

        Flash::success('User successfully updated');

        return redirect('/users');
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        $this->user->delete($id);

        Flash::success('User successfully deleted');

        return redirect('/users');
    }

}