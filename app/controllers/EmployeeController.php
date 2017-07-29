<?php

class EmployeeController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /employee
	 *
	 * @return Response
	 */
	
	public function index()
	{
		$users = Profile::all();
		return View::make('employee.index')
						->with('title', 'List of All Employees')
						->with('employees', $users);
	}

	public function create()
	{
		$bg = [ 
			'A+' => 'A+',
			 'B+' => 'B+',
			 'AB+' => 'AB+',
			 'O+' => 'O+',
			 'A-' => 'A-',
			 'B-' => 'B-',
			 'AB-' => 'AB-',
			 'O-' => 'O-'
		];
		return View::make('employee.add')
						->with('title', 'Add an Employee')
						->with('bg', $bg);
	}


	public function store()
	{
		$rules = [

					'first_name'      => 'required',
					'last_name' => 'required',
					'nid' => 'required|numeric',
					'email' => 'required|email',
					'sex' => 'required',
					'blood_group' => 'required',
					'dob' => 'required',
					'contact' => 'required',
					'marital_status' => 'required'

		];

		$data = Input::all();

		$validator = Validator::make($data,$rules);

		if($validator->fails()){
			return Redirect::back()->withInput()->withErrors($validator);
		}

		$img_link = 'uploads/default.jpg';


		if(Input::hasFile('img_link')) {
			$file = Input::file('img_link');

			$destination = public_path().'/uploads/photos/';
			$filename = time().'_'.$file->getClientOriginalName();
			$file->move($destination, $filename);
			$img_link = '/uploads/photos/'.$filename;
		}
		
		$previousUser = DB::table('users')->orderBy('id', 'desc')->get();
		$previousEmployeeID = $previousUser[0]->employeeID;
		//$previousEmployeeID = User::('id', $previousUser->id)->pluck('employeeID'); */
		$user = new User();
		$user->employeeID = Profile::rand_uniq();
		$user->email = $data['email'];
		$password = str_random(6);
		$user->password = Hash::make($password);
		$user->employeeID = $previousEmployeeID+1;
		if($user->save()){
			$user_id = $user->id;
			$profile = new Profile();
			$profile->user_id = $user_id;
			$profile->first_name = $data['first_name'];
			$profile->last_name = $data['last_name'];
			$profile->national_id = $data['nid'];
			$profile->sex = $data['sex'];
			$profile->blood_group = $data['blood_group'];
			$profile->birth_date = $data['dob'];
			$profile->marital_status= $data['marital_status'];
			$profile->phone = $data['contact'];
			$profile->photo = $img_link;

			if($profile->save()){

				Mail::send('accountCreationMail', ['name' => $data['first_name'], 'password' => $password, 'mail' => $data['email'] ], function($message){
					$message->to(Input::get('email'))
							->cc('richardiyama@yahoo.com')
							->cc('Richard')
							->subject('Cittanuvola. || Account Creation'); // it does not work except Input::get();
				});

				return Redirect::route('employee.index')->with('success',"New Employee Added Successfully");
			} else {
				return Redirect::route('employee.index')->with('error',"Something went wrong.Try again");
			}
		} else {
			return Redirect::route('employee.index')->with('error',"Something went wrong.Try again");
		}

		
	}

	public function edit($id)
	{

		try{
			$bg = [ 
				'A+' => 'A+',
				 'B+' => 'B+',
				 'AB+' => 'AB+',
				 'O+' => 'O+',
				 'A-' => 'A-',
				 'B-' => 'B-',
				 'AB-' => 'AB-',
				 'O-' => 'O-'
			];

			
			$user= User::find($id);
			$email = $user->email;
			$employee = Profile::where('user_id', $id)->first();
			$selectedbg = $employee->blood_group;
			return View::make('employee.edit')
						->with('employee',$employee)
						->with('title','Edit Employee Info')
						->with('email', $email)
						->with('blood_group', $bg)
						->with('user_id', $id)
						->with('selectedbg', $selectedbg);
		}catch(Exception $ex){
			return Redirect::route('employee.index')->with('error','Something went wrong.Try Again.');
		}
	}

	public function update($id)
	{
		$rules = [
					'first_name'      => 'required',
					'last_name'       => 'required',
					'email'           => 'required',
					'national_id'     => 'required',
					'birth_date'      => 'required',
					'blood_group'     => 'required',
					'sex'             => 'required',
					'marital_status'  => 'required'		
				];

		$data = Input::all();

		$validator = Validator::make($data,$rules);

		if($validator->fails()){
			return Redirect::back()->withInput()->withErrors($validator);
		}
		//return $id;
		
		// get the previous photo link 
		 $img_link = Profile::find($id)->photo;


		if(Input::hasFile('img_link')) {
			$file = Input::file('img_link');

			$destination = public_path().'/uploads/photos/';
			$filename = time().'_'.$file->getClientOriginalName();
			$file->move($destination, $filename);
			$img_link = '/uploads/photos/'.$filename;
		}
		
		$user = User::find($data['user_id']);
		
		$user->email = $data['email'];
		if($user->save()){
			$user_id = $user->id;
			$profile = Profile::find($id); // passed from edit.blade.php
			$profile->user_id = $user_id;
			$profile->first_name = $data['first_name'];
			$profile->last_name = $data['last_name'];
			$profile->national_id = $data['national_id'];
			$profile->sex = $data['sex'];
			$profile->blood_group = $data['blood_group'];
			$profile->birth_date = $data['birth_date'];
			$profile->marital_status= $data['marital_status'];
			$profile->phone = $data['phone'];
			$profile->photo = $img_link;

			if($profile->save()){
				return Redirect::route('employee.index')->with('success',"Employee Profile Updated Successfully");
			} else {
				return Redirect::route('employee.index')->with('error',"Something went wrong.Try again");
			}
		} else {
			return Redirect::route('employee.index')->with('error',"Something went wrong.Try again");
		}
		
	}

	public function destroy($id)
	{

		$allInput = Input::all();
		$data = Input::get('password');
		$rules['password'] = 'required';
		$validator = Validator::make($allInput,$rules);

		if($validator->fails()){
			return $this->errorResponse("Password Required", 400);
		}

		if(Hash::check($data,Auth::user()->password)) {
			// return 'succes';
			$user_id = Profile::find($id)->user_id;
			User::destroy($user_id);

			return $this->response('Employee Deleted Successfully.', 201);
		} else {
			return $this->errorResponse('Password did not match', 400);
		}
	}

	public function search() {
		$id = Input::get('id');
		if(is_numeric($id)) {
			if(!User::where('employeeID', $id)->exists()) {
				return Redirect::route('dashboard')->withErrors('The Employee ID you provided does not exist. Please, Search with a valid ID');
			}
			$status = User::where('employeeID', $id)->first(); // $d is employee id here
			$id = User::where('employeeID', $id)->pluck('id'); // this is user id 
		} else {
			$profile= Profile::where('first_name', 'LIKE', '%'.$id.'%')->orWhere('last_name', 'LIKE', '%'.$id.'%')->first();
			if(!$profile){
				return Redirect::route('dashboard')->withErrors('The Employee Name you provided does not exist. Please, Search with a valid Name');
			}
			$id = $profile->user_id;
			$status = User::find($id);
		}
		
		$salary = Helper::calculation($id);
		return View::make('calculation.show')
						->with('status', $status)
						->with('title', 'Info of')
						->with('salary', $salary);
	}

	


	// code for json response to 
	private function response($message, $status = 200){
		return Response::json([
						'data' => $message,
						'status_code' => $status
						
					],$status);
	}
	private function errorResponse($message, $status = 400){
		return Response::json([
						'error' => $message,
						'status_code' => $status
						
					], $status);
	}

}
