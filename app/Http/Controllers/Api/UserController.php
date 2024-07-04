<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($flag)
    {
        //p("Get api is working");
        $users = User::select('name', 'email')->where('status', 1)->where('pincode', '<>', null)->where('id', $flag)->get();
        //p($users);
        if (count($users) > 0) {
            $response = [
                'message' => count($users) . ' users found',
                'status' => 1,
                'data' => $users
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'message' => 'No user found',
                'status' => 0
            ];
            return response()->json($response, 200);
        }
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
        //p($request->all());
        $validator = validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6', 'confirmed'],
            'password_confirmation' => ['required']

        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        } else {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ];
            DB::beginTransaction();
            try {
                $user = user::create($data);
                DB::commit();
            } catch (\Exception $e) {
                //DB::rollBack();
                //p($e->getMessage());
                $user = null;
            }
            if ($user != null) {
                return response()->json([
                    'message' => 'User registered successfully'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Internal server error'
                ], 500);
            }
        }
        //p($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            $response = [
                'message' => 'No user found',
                'status' => 0
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'message' => 'user found',
                'status' => 1,
                'data' => $user
            ];
            return response()->json($response, 200);
        }
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
