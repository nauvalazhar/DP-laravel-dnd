<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\RoleUser;
use Session;
use DB;
use Auth;
use YoHang88\LetterAvatar\LetterAvatar;
use Notifications;
use Logs;

class UsersController extends Controller
{
	public function index($user=false) {
		$users = new User();
		if(!Auth::user()->hasRole('developer')) {
			$users = $users->whereVisible(NULL);
		}
		$users = $users->paginate(config('starter.pagination'));
		$no = 1;

		return view('users.index', compact('users', 'no'));
	}

	public function create() {
		$roles = Role::all();
		return view('users.create', compact('roles'));
	}

	public function store(Request $request) {
		$this->validate($request, [
			'name' => 'required',
			'email' => 'required|email|unique:users,email',
			'password' => 'required',
			'picture' => 'nullable|mimetypes:image/*',
			'roles' => 'required'
		]);

		$input = $request->all();
		$input['password'] = bcrypt($input['password']);

		if(!$request->hasFile('picture')) {
			$filename = "user-" . uniqid() . ".png";
			$avatar = new LetterAvatar($input['name'], 'square', 250);
			$avatar->saveAs(storage_path('app') . path() . media_path() . path() . config('starter.path.images') . path() . $filename, "image/png");
			$input['picture'] = $filename;
		}else{
			$filename = "user-" . $request->file('picture')->getClientOriginalName();
			$request->file('picture')->storeAs(media_path() . path() . config('starter.path.images'), $filename);
			$input['picture'] = $filename;
		}

		$user = User::create($input);
		Notifications::create([
			'to' => $user->id,
			'title' => 'Welcome to Starter Kit',
			'content' => 'Your account is created by ' . Auth::user()->name,
			'status' => 'unread'
		]);

		foreach($request->roles as $role) {
      DB::table('role_user')->insert([
      	'user_id' => $user->id,
      	'role_id' => $role
      ]);
		}
		Session::flash('success', 'User created successfully');

		return redirect()->route('users.index');
	}

	public function edit($id) {
		$id = (int) $id;
		$user = User::find($id);
		if(Auth::user()->can('user_just_edit_itself') && ($id !== Auth::user()->id)) {return abort(403);}
		if(!Auth::user()->hasRole('developer') && ($user->visible == 0 && $user->visible !== null)) {return abort(403);}
		$roles = Role::all();
		$userRoles = [];
		foreach($user->roles as $role) {
			$userRoles[] = $role->id;
		}
		return view('users.edit', compact('user', 'roles', 'userRoles'));
	}

	public function update(Request $request, $id) {
		if(Auth::user()->can('user_just_edit_itself') && ($id !== Auth::user()->id)) {return abort(403);}
		$this->validate($request, [
			'name' => 'required',
			'email' => 'required|email|unique:users,email,'.$id,
			'picture' => 'nullable|mimetypes:image/*',
			'roles' => 'required'
		]);

		$user = User::find($id);

    $input = $request->all();
    if(!$input['password']) {
        $input['password'] = $user['password'];
    }else{
        $input['password'] = bcrypt($input['password']);
    }

		if($request->hasFile('picture')) {
			$filename = "user-" . $request->file('picture')->getClientOriginalName();
			$request->file('picture')->storeAs(media_path() . path() . config('starter.path.images'), $filename);
			$input['picture'] = $filename;
		}

		$user->update($input);

		DB::table('role_user')->whereUserId($user->id)->delete();
		foreach($request->roles as $role) {
      DB::table('role_user')->insert([
      	'user_id' => $user->id,
      	'role_id' => $role
      ]);
		}

		Session::flash('success', 'User updated successfully');
		return redirect()->route('users.index');
	}

	public function destroy($id) {
		$user = User::find($id);
		$user->delete();
		Session::flash('success', 'User deleted successfully');
		return redirect()->route('users.index');
	}

	public function notifications() {
		return view('users.notifications');
	}
}
