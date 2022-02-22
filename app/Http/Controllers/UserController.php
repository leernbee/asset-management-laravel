<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use App\Location;
use App\Check;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('permission:List users|Create users|Edit users|Delete users', ['only' => ['index', 'show']]);
        $this->middleware('permission:Create users', ['only' => ['create', 'store']]);
        $this->middleware('permission:Edit users', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Delete users', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $roleList = Role::all()->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)->pluck('name', 'name')->prepend('Show all Roles', '');

        $role = $request->get('role') != '' ? $request->get('role') : '';
        $search = $request->get('search');
        $field = $request->get('field') != '' ? $request->get('field') : 'id';
        $sort = $request->get('sort') != '' ? $request->get('sort') : 'asc';

        if ($field == "name") {
            $data = User::orderBy('first_name', $sort)->orderBy('last_name', $sort);
        } else {
            $data = User::orderBy($field, $sort);
        }


        if ($role != '') {
            $data = $data
                ->orWhere(DB::raw("CONCAT(`first_name`, ' ', `last_name`, ' ', `email`)"), 'LIKE', "%" . $search . "%")
                ->role($role)
                ->paginate(10)
                ->withPath('?search=' . $search . '&role=' . $role . '&field=' . $field . '&sort=' . $sort);
        } else {
            $data = $data
                ->orWhere(DB::raw("CONCAT(`first_name`, ' ', `last_name`, ' ', `email`)"), 'LIKE', "%" . $search . "%")
                ->paginate(10)
                ->withPath('?search=' . $search . '&role=' . $role . '&field=' . $field . '&sort=' . $sort);
        }

        return view('users.index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 10)
            ->with('roleList', $roleList)->with('role', $role)
            ->withPath('?search=' . $search . '&role=' . $role . '&field=' . $field . '&sort=' . $sort);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $roles = Role::pluck('name', 'name')->all();
        $locations = Location::pluck('name', 'id')->prepend('Select a Location', '');
        return view('users.create', compact('roles', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
            'birth_date' => 'nullable|date_format:m-d-Y',
            'contact_no' => 'nullable|regex:/639[0-9]{9}/',
            'employee_id' => 'required|string',
            'job_title' => 'nullable|string',
            'location_id' => 'required'
        ]);


        $input = $request->all();
        $input['password'] = Hash::make($input['password']);


        $user = User::create($input);
        $user->assignRole($request->input('roles'));


        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $user = User::find($id);
        $machines = Check::whereHasMorph('checkable', ['App\Machine'], function ($query) use ($user) {
            $query->where('targetable_id', $user->id)
                ->where('action_done', 0)
                ->where('action', 'checkout');
        })->latest()->get();

        return view('users.show', compact('user', 'machines'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        $locations = Location::pluck('name', 'id')->prepend('Select a Location', '');

        return view('users.edit', compact('user', 'roles', 'userRole', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            'roles' => 'required',
            'birth_date' => 'nullable|date_format:m-d-Y',
            'contact_no' => 'nullable|regex:/639[0-9]{9}/',
            'employee_id' => 'required|string',
            'job_title' => 'nullable|string',
            'location_id' => 'required'
        ]);


        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = array_except($input, array('password'));
        }


        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();


        $user->assignRole($request->input('roles'));


        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if ($user->id == 1) {
            abort(403);
        } else {
            $user->delete();
        }

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }

    public function AuthRouteAPI(Request $request)
    {
        return $request->user();
    }
}
