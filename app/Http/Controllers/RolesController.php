<?php namespace App\Http\Controllers;

//use App\Repositories\Criteria\Role\RolesWithPermissions;
use App\Repositories\RoleRepository as Role;
use App\Repositories\PermissionRepository as Permission;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class RolesController extends Controller {

	private $role;
	private $permission;

	public function __construct(Role $role, Permission $permission)
	{
		$this->role = $role;
		$this->permission = $permission;
	}

	public function index()
	{
		$roles = $this->role->paginate(10);
		return view('roles.index', compact('roles'));
	}

	public function create()
	{
		$permissions = $this->permission->all();
		return view('roles.create', compact('permissions'));
	}

	public function store(Request $request)
	{

		$this->validate($request, array('name' => 'required', 'display_name' => 'required', 'level' => 'required|unique:roles'));


		$role = $this->role->create($request->all());

		$role->savePermissions($request->get('perms'));

		Flash::success('Role successfully created');

		return redirect('/roles');
	}

	public function edit($id)
	{
		$role = $this->role->find($id);
		if($role->id == 1)
		{
			abort(403);
		}
		$permissions = $this->permission->all();
		$rolePerms = $role->perms();
		return view('roles.edit', compact('role', 'permissions', 'rolePerms'));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, array('name' => 'required', 'display_name' => 'required', 'level' => 'required'));

		$role = $this->role->find($id);
		$role->update($request->all());

		$role->savePermissions($request->get('perms'));

		Flash::success('Role successfully updated');

		return redirect('/roles');
	}

	public function destroy($id)
	{
		if($id == 1)
		{
			abort(403);
		}

		$this->role->delete($id);

		Flash::success('Role successfully deleted');

		return redirect('/roles');
	}

}