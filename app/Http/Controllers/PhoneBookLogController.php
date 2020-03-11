<?php

namespace App\Http\Controllers;

use App\Http\Resources\apiReturn;
use App\PhoneBookLog;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class PhoneBookLogController extends Controller
{
    //

	/**
	 * @return apiReturn
	 */
	public function index(){

		$phoneBookList =
			PhoneBookLog::with(['from' => function($q) {
				$q->select(['id','fullName']);
			}])
				->with(['to' => function($q) {
					$q->select(['id','fullName']);
				}])
				->orderBy('id', 'DESC')->get();
		$phoneBookListN = $this->normalizeOutPut($phoneBookList);
		return new apiReturn($phoneBookListN);
	}

	/**
	 * @param Request $request
	 * @return apiReturn|\Illuminate\Http\JsonResponse
	 */
	public function store(Request $request) {

		$validator = Validator::make($request->all(), $this->rules());

		if($validator->fails()){
			return response()->json([
				'error'		=> 'Validation Errors',
				'details' 	=> $validator->errors()]);
		}

		try{
			$newPhoneBookLog = PhoneBookLog::create($request->all());
			$invertRecord = $this->saveInvert($request);
			return new apiReturn([$newPhoneBookLog,$invertRecord]);
		}catch (\Exception $e) {
			return response()->json([
				'error'		=> 'Error has occurs saving the log',
				'details'	=> $e->getMessage()
			]);

		}

	}

	/**
	 * @return array
	 */
	private function rules() {
		return [
			'idFrom'		=> 'required',
			'idTo'			=> 'required',
			'transaction'	=> ['required',Rule::in(['inbound','outbound'])],
			'status'		=> ['required',Rule::in('ok','VM')]
		];
	}

	/**
	 * @param $request
	 * @return PhoneBookLog
	 */
	private function saveInvert($request){

		$invertRecord = new PhoneBookLog;

		$invertRecord->idFrom 	= $request->idTo;
		$invertRecord->idTo		= $request->idFrom;
		$invertRecord->status	= $request->status;

		switch ($request->transaction) {
			case 'inbound':
				$invertRecord->transaction = 'outbound';
				break;
			case 'outbound':
				$invertRecord->transaction = 'inbound';
		}

		$invertRecord->save();

		return $invertRecord;
	}

	/**
	 * @param $results
	 * @return array
	 */
	private function normalizeOutPut($results) {
		$responses = array();

		foreach ($results as $result) {
			$response['id']				= $result->id;
			$response['from']			= $result->from->fullName;
			$response['to']				= $result->to->fullName;
			$response['transaction']	= $result->transaction;
			$response['status']			= $result->status;
			$response['created_at']		= $result->created_at;
			$response['updated_at']		= $result->updated_at;

			$responses[] = $response;
		}

		return $responses;
	}

}
