<?php

namespace App\Http\Controllers;

use App\User;
use App\UserType;
use Illuminate\Http\Request;

use App\Http\Requests;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('registered');
        $this->middleware('admin');
    }


    public function edit()
    {
        $user_types = UserType::lists('name','id');
        $users = User::with('user_type')->orderBy('id', 'asc')->paginate(15);
        return view('admin.user', compact('users', 'user_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user_types = $request->user_types;
        $user = User::get();


        if(!empty($user_types))
            foreach($user_types as $id => $user_type)
                $user->find($id)->update(['user_type_id' => $user_type]);
        $user_types = UserType::lists('name','id');
        $users = User::with('user_type')->orderBy('id', 'asc')->paginate(15);
        return view('admin.user', compact('users', 'user_types'));
    }
}
