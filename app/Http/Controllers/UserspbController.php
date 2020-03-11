<?php

namespace App\Http\Controllers;

use App\Http\Resources\apiReturn;
use App\User;
use App\Userspb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class UserspbController extends Controller
{
    //

	/**
	 * Function to pull all the records in the PhoneBook
	 * @return apiReturn
	 */
	public function index() {
		return new apiReturn(
			Userspb::orderBy('id', 'DESC')->paginate(10)
		);

	}

	/**
	 * Function to store a new user
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(Request $request) {
//		Validate de Inputs

		$validator = Validator::make($request->all(), $this->rules());

		if($validator->fails()){
			return response()->json([
				'error'		=> 'Validation Errors',
				'details' 	=> $validator->errors()]);
		}

		try {
			$newPhoneRecord = Userspb::create($request->all());
			return new apiReturn($newPhoneRecord);
		}catch (\Exception $e) {
			return response()->json([
				'error'		=> 'Error has occurs saving the log',
				'details'	=> $e->getMessage()
			]);
		}

	}

	/**
	 * Function to pull one record base on the id
	 * @param $contact
	 * @return \Illuminate\Http\JsonResponse
	 */

	public function show($contact) {

		try{
			$contactNumber = Userspb::findOrFail($contact);
		}catch (\Exception $e) {
			return response()->json([
				'error' => 'Record not found',
				'description' 	=> $e->getMessage()
			]);
		}
		return new apiReturn($contactNumber);

	}

	/**
	 * @param Request $request
	 * @param $contact
	 * @return apiReturn|\Illuminate\Http\JsonResponse
	 */
	public function update(Request $request, $contact) {

		try{
			$contactNumber = Userspb::findOrFail($contact);
			$contactNumber->update($request->all());
			return new apiReturn($contactNumber);
		}catch(\Exception $e) {
			return response()->json([
				'error' => 'Record not found',
				'description' 	=> $e->getMessage()
			]);
		}
	}

	/**
	 * @param $contact
	 * @return apiReturn|\Illuminate\Http\JsonResponse
	 */
	public function destroy($contact) {

		try {
			$contactNumber = Userspb::findOrFail($contact);
			$contactNumber->delete();
			return new apiReturn(['message'=>'record deleted']);
		}catch(\Exception $e){
			return response()->json([
				'error' => 'Record not found',
				'description' 	=> $e->getMessage()
			]);
		}

	}

	/**
	 * @return array
	 */
	private function rules() {
		return [
			'fullName'		=>'required',
			'address' 		=> 'required',
			'phoneNumber'	=> 'required',
			'email' 		=> 'required | email:rfc,dns',
			'status'		=> 'required'
		];
	}
}
