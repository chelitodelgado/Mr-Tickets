<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->get();
        if (request()->ajax()) {

            return datatables()->of($users)
                ->addColumn('action', function ($data) {
                    $button = '<a style="cursor:pointer; color: green;" name="edit" id="' . $data->id . '"
                    class="edit"><i class="fa fa-edit"></i></a> ';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a style="cursor:pointer; color: red;" name="delete" id="' . $data->id . '"
                    class="delete"><i class="fa fa-trash"></i></a> ';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);

        }

        return view('layouts.users.usuarios', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $users = User::latest()->get();

        $request->validate([
            'name'        => 'required|string|max:255',
            'username'    => 'required|string|max:255',
            'email'       => 'required|string|max:255',
            'password'    => 'required|string|max:255',
            'status'      => 'required|string|max:255',
            'role'        => 'required|string|max:255',
            'profile_pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->profile_pic) {
            $file = $request->file('profile_pic');
            $imagePath = $request->profile_pic;
            $imageName = $imagePath->getClientOriginalName();

            // $path = $request->profile_pic->storeAs('uploads', $imageName, 'public');
            $path = public_path('/fotos');
            $file->move($path, $imageName);

        }

        $form_data = array(
            'name'        => $request->name,
            'username'    => $request->username,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'status'      => $request->status,
            'role'        => $request->role,
            'profile_pic' => $imageName
        );

        User::create($form_data);


        return response()->json(['success' => 'OK' ]);
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ( request()->ajax() ) {
            $data = User::findOrFail($id);
            return response()->json(['data' => $data]);
        }
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

        if ($request->profile_pic) {
            $file = $request->file('profile_pic');
            $imagePath = $request->profile_pic;
            $imageName = $imagePath->getClientOriginalName();

            // $path = $request->profile_pic->storeAs('uploads', $imageName, 'public');
            $path = public_path('/fotos');
            $file->move($path, $imageName);

        }

        $form_data = array(
            'name'        => $request->name,
            'username'    => $request->username,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'status'      => $request->status,
            'role'        => $request->role,
            'profile_pic' => $imageName
        );

        User::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'OK']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = User::findOrFail($id);
        $data->delete();
    }

    public function getUsers(){

        $users = User::latest()->get();

        return Response()->json(['data' => $users]);
    }


}
