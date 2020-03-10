<?php

namespace App\Http\Controllers;

use App\Http\Resources\apiReturn;
use App\Userspb;
use Illuminate\Http\Request;

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
	 * @return apiReturn
	 */
	public function store(Request $request) {
//		Validate de Inputs
//		$request->validate([
//			'fullName'		=>'required',
//			'address' 		=> 'required',
//			'phoneNumber'	=> 'required',
//			'email' 		=> 'required',
//		]);
//
		try {
			$newPhoneRecord = Userspb::create($request->all());
			return new apiReturn($newPhoneRecord);
		}catch (\Exception $ex) {
			return new apiReturn([$ex->getMessage()]);
		}

	}

	/**
	 * Function to pull one record base on the id
	 * @param $phonebook
	 * @return apiReturn
	 */

	public function show($phonebook) {

		return new apiReturn(
			Userspb::where('id',$phonebook)->get()
		);

	}

	public function update(Request $request) {

	}

	public function destroy(Request $request) {

	}
}
