<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate();

        return view('user.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            "name"=>["required", "min:3","max:30"],
            "phone"=>["required","regex:/^(\+98|0)?9\d{9}$/u","unique:users"],
            "email"=>["required","email","unique:users"],
            "password"=>["required","confirmed"],
            "role"=>["required","in:0,1"]
        ]);

        User::create([
            "name"=>$request->name,
            "phone"=>$request->phone,
            "email"=>$request->email,
            "password"=>Hash::make($request->password),
            "is_admin"=>($request->role == 0) ? false : true
        ]);

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('user.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('user.edit')->with("user",$user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request,[
            "name"=>["required", "min:3","max:30"],
            "phone"=>["required","regex:/^(\+98|0)?9\d{9}$/u",Rule::unique('users')->ignore($user->id)],
            "email"=>["required","email",Rule::unique('users')->ignore($user->id)],
            "password"=>["confirmed"],
            "role"=>["required","in:0,1"]
        ]);

        $user->update([
            "name"=>$request->name,
            "email"=>$request->email,
            "phone"=>$request->phone,
            "password"=>(isset($request->password) ? Hash::make($request->password) : $user->password),
            "is_admin"=>($request->role == 0) ? false : true
        ]);

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index');
    }

    public function filter(Request $request){
        $users = User::select("*")
        ->where("name","LIKE","%".$request->filter."%")
        ->orWhere("email","LIKE","%".$request->filter."%")
        ->orWhere("phone","LIKE","%".$request->filter."%")->paginate();

        return view('user.index')->with('users', $users);
    }
}
