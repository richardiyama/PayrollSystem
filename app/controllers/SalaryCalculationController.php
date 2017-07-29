<?php

class SalaryCalculationController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /address
	 *
	 * @return Response
	 */
	
	public function index()
	{
		return View::make('calculation.index')
		->with('title','Employee\'s salary');
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /address/create
	 *
	 * @return Response
	 */
	public function showStatusFull($id)
	{

		//return 'fkjf';
		//$id = Input::get('user_id');
		if(!User::where('employeeID', $id)->exists()) {
			return Redirect::route('dashboard')->withErrors('The Employee ID you provided does not exist.Please, Search with a valid ID');
		}
		$status = User::where('employeeID', $id)->first(); // $idd is employee id here
		
		$id = User::where('employeeID', $id)->pluck('id'); // this is user id 
		$salary = Helper::calculation($id);
		return View::make('calculation.show')
						->with('status', $status)
						->with('title', 'Info of')
						->with('salary', $salary);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /address
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /address/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function showStatus()
	{
		$data = Input::all();
		$id = Input::get('user_id');
		$status = User::find($id);
		$salary = Helper::calculation($id);
		return View::make('calculation.show')
						->with('status', $status)
						->with('title', 'Info of')
						->with('salary', $salary);
		//return User::find($id);
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /address/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /address/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /address/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
