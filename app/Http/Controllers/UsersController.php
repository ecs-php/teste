<?php
namespace App\Http\Controllers;

use Route;
use Illuminate\Support\Facades\Input;
use \Illuminate\Routing\Controller as BaseController;
use Request;
use App\Models\Users;

class UsersController extends BaseController{

	public function __construct(){
		#dd($this);

	}	

	public function getUser(){
		$id = Route::input('id');

		$user = Users::find($id);

		$result = [];
		if(empty($user)){
			$result['success']= false;
			$result['message']= "User with id '{$id}' is not found.";
			$result['data']= [];
		}else{

			$result['success'] = true;
			$result['message'] = "Successful request.";
			$result['data']= $user->toArray();
		}


		return response()->json($result);
		
	}


	/**
	LIST OF ALL USERS, INDEX REQUEST OF TYPE GET
	*/

	public function index(Request $request){
		

		$query = new Users;
		$limit = Input::get('limit',10);
		$page = Input::get('page',1);


		$query->take($limit)->skip($limit*($page-1));
		$count = $query->count();
		$users = $query->get();
		$result = [
			'success'=>true,
			'message'=>'Successful request.',
			'total'=>$count,
			'page'=>$page,
			'limit'=>$limit,
			'data'=>$users->toArray()

		];
		

		return response()->json($result);
		

	}


	/**
	CREATE USER, REQUEST TYPE POST
	*/


	public function createUser(){
		
		$data = [
			'name'=>Input::get('name'),
			'email'=>Input::get('email'),
			'phone'=>Input::get('phone',''),
			'password'=>  password_hash(Input::get('password'), PASSWORD_BCRYPT),
			'gender'=>Input::get('gender'),
			'birth_date'=>Input::get('birth_date'),
		];


		$user = new Users();

		$required_errors = [];
		foreach($data as $key=>$value){

			if(empty($value)){
				$required_errors[] = $key;
			}
			$user->$key = $value;
		}


		if(!empty($required_errors)){

			$result = [
				'success'=>false,
				'message'=>'Please, check required itens: '.implode(',',$required_errors)
			];
			return response()->json($result);
		}

		if(Users::where('email',$data['email'])->count() > 0){
			$result = [
				'success'=>false,
				'message'=>'User with email '.$data['email'] . ' already exists.'
			];
			return response()->json($result);	
		}


		try{
			$user->save();
		}catch(\Exception $e){
			$result = [
				'success'=>false,
				'message'=>$e->getMessage()
			];
			return response()->json($result,200);


		}

		$result = [
			'success'=>true,
			'message'=>"Request Successful. User has been created: {$user->id} - {$user->name}"
		]
		;

		return response()->json($result,200);


	}

	/**
	UPDATE USER, REQUEST TYPE PUT

	*/

	public function updateUser(){

		$id = Route::input('id');
		$user = Users::find($id);

		if(empty($user)){
			$result['success']= false;
			$result['message']= "User with id '{$id}' is not found.";
			return response()->json($result);
		}

		$data = [
			'name'=>Input::get('name'),
			#'email'=>Input::get('email'),
			'phone'=>Input::get('phone',''),
			'password'=>  password_hash(Input::get('password'), PASSWORD_BCRYPT),
			'gender'=>Input::get('gender'),
			'birth_date'=>Input::get('birth_date'),
		];


		$required_errors = [];
		foreach($data as $key=>$value){

			if(empty($value)){
				$required_errors[] = $key;
			}
			$user->$key = $value;
		}


		if(!empty($required_errors)){

			$result = [
				'success'=>false,
				'message'=>'Please, check required itens: '.implode(',',$required_errors)
			];
			return response()->json($result);
		}

		/**
		Compare if user email is different to change. Email must be unique.
		*/

		$email = Input::get('email');
		$count_user = Users::where('email',$email)->count();
		
		if($user->email != $email && $count_user > 0){

			
				$result = [
					'success'=>false,
					'message'=>'User with email '.$email . ' already exists.'
				];
				return response()->json($result);	
			
				
		}else{
			if(!empty($email)){
				$user->email = $email;	
			}
			
		}


		try{
			$user->save();
		}catch(\Exception $e){
			$result = [
				'success'=>false,
				'message'=>$e->getMessage()
			];
			return response()->json($result,200);


		}

		$result = [
			'success'=>true,
			'message'=>"Request Successful. User has been updated: {$user->id} - {$user->name}"
		];

		return response()->json($result,200);

	}
	

	public function deleteUser(){

		$id = Route::input('id');
		$user = Users::find($id);
		$result = [];
		
		if(empty($user)){
			$result['success']= false;
			$result['message']= "User with id '{$id}' not exists or has been deleted.";
			return response()->json($result);
		}

		try{
			Users::where('id',$id)->delete();
		}catch(\Exception $e){
			$result['success']= false;
			$result['message']= $e->getMessage();
			return response()->json($result);
		}



		$result['success']= true;
		$result['message']= 'Request Successful. User has been deleted.';
		return response()->json($result);
		



	}
	
}