<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    private $model;

    /**
     * Constructor referencing User Model.
     *
     * @return Object
     */
    public function __construct(){
        $this->model = new User();
    }


    /**
     * Display a listing of users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = $this->model->orderBy('id', 'DESC')->get();

        if( count($list) ){
            return response()->json($list);
        } else {
            return response('Not users!', 404);
        }
        
    }

    /**
     * Show the form for creating a new user.
     *
     * @param  \Illuminate\Http\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function create(UserRequest $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $create = $this->model->create(
                                          [
                                             'name'       => $request->name,
                                             'email'      => $request->email, 
                                             'phone'      => $request->phone, 
                                             'cpf'        => $request->cpf
                                          ]
                                      );
        $create->save();

        return response('User created!', 201);
    }

    /**
     * Display the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->model->find($id);

        if( $data ) {
            return response()->json($data);   
        } else {            
            return response('User not found!', 404);
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
        $update = $this->model->findOrFail($id);

        $update->update(
                          [
                            'name'       => $request->name,
                            'email'      => $request->email, 
                            'phone'      => $request->phone, 
                            'cpf'        => $request->cpf
                          ]
                        );

        return response('User updated!', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = $this->model->find($id);

        if( $delete ) {
            $delete->delete();
            return response('User deleted!', 200);
        } else {
            return response('User not found!', 404);
        }      
        
    }
}
