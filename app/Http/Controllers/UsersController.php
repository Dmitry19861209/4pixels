<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * Users page
     */
    public function index()
    {
        return view('users.index');
    }
    /**
     * Get all users
     *
     * @return User[]
     */
    public function getAllUsers()
    {
        return User::all();

    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $now = Carbon::now();

        User::validate($request);

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'email_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return redirect(route('users'));
    }

    /**
     * Show the User form for editing.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('users.edit', [
            'userId' => $id
        ]);
    }

    /**
     * Get user by id
     *
     * @param $id
     * @return User
     */
    public function getUserById($id)
    {
        return User::find($id);
    }

    /**
     * Update user by id.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $now = Carbon::now();
        $user = User::find($id);
        $email = $request->input('email');
        User::validate($request, $user);

        $updateData = [
            'name' => $request->input('name'),
            'password' => bcrypt($request->input('password')),
            'updated_at' => $now,
        ];

        if ($email !== $user->email) {
            $updateData['email'] = $email;
        }

        $user->update($updateData);

        return redirect(route('users.edit', $id));
    }

    /**
     * Remove user by id.
     *
     * @param  int $id
     * @return void
     */
    public function destroy($id): void
    {
        $user = User::find($id);
        $user->delete();
    }
}
