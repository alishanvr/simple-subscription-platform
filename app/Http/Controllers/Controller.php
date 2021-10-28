<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function validator_fails(Validator $validator)
    {
        $response = [
            'statusCode' => STATUS_GENERAL_FAIL,
            'description' => $validator->errors()->first(),
            'error' => $validator->errors()
        ];

        response()
            ->json($response, STATUS_GENERAL_FAIL)->throwResponse();
    }

    public function internal_error_occurred($description = 'Some internal Error occurred!', $errors = [])
    {
        $description = 'Internal Error! ' . $description;
        if (empty($errors)){
            $errors[] = $description;
        }

        $response = [
            'statusCode' => STATUS_GENERAL_FAIL,
            'description' => $description,
            'error' => $errors
        ];

        response()
            ->json($response, STATUS_GENERAL_FAIL)->throwResponse();
    }

    public function unauthorized_response()
    {
        $response = [
            'statusCode' => STATUS_AUTHENTICATION_FAILED,
            'description' => 'You are not authorized to perform this action.',
            'error' => ['You are not authorized to perform this action.']
        ];

        response()
            ->json($response, STATUS_AUTHENTICATION_FAILED)->throwResponse();
    }

    public function not_found_response($title)
    {
        $response = [
            'statusCode' => STATUS_NOT_FOUND,
            'description' => $title . ' not found.',
            'error' => [$title . ' not found.']
        ];

        response()
            ->json($response, STATUS_NOT_FOUND)->throwResponse();
    }

    public function already_exist_response($description = 'already exist.')
    {
        $response = [
            'statusCode' => STATUS_ALREADY_EXISTS,
            'description' => $description,
            'error' => [$description]
        ];

        response()
            ->json($response, STATUS_ALREADY_EXISTS)->throwResponse();
    }

    public function success_response(Request $request, $description, $data, $extra_arr_elem = [])
    {
        $response = [
            'statusCode' => STATUS_OK,
            'description' => $description,
            'data' => $data,
            'error' => []
        ];

        if (!empty($extra_arr_elem)) {
            $response = array_merge($response, $extra_arr_elem);
        }

        return response()
            ->json($response, STATUS_OK);
    }

    public function unauthorized($description = 'You are not authorized...', array $errors_arr = [])
    {
        $response = [
            'statusCode' => STATUS_AUTHENTICATION_FAILED,
            'description' => $description
        ];

        if (empty($errors_arr)) {
            $response['error'] = [$description];
        } else {
            $response['error'] = $errors_arr;
        }

        response()
            ->json($response, STATUS_AUTHENTICATION_FAILED)->throwResponse();
    }

    public function general_fails($description, array $errors_arr = [])
    {
        $response = [
            'statusCode' => STATUS_GENERAL_FAIL,
            'description' => $description
        ];

        if (empty($errors_arr)) {
            $response['error'] = [$description];
        } else {
            $response['error'] = $errors_arr;
        }

        response()
            ->json($response, STATUS_GENERAL_FAIL)->throwResponse();
    }

    public function handle_query_exception(\Exception $ex)
    {
        $msg = 'Sorry! Some query exception occurs with Error Code: ' . $ex->getCode();

        $response = [
            'statusCode' => STATUS_GENERAL_FAIL,
            'statusDescription' => $msg,
            'error' => (config('app.debug') === true) ? [$ex->getMessage()] : [$msg]
        ];

        response()
            ->json($response, STATUS_GENERAL_FAIL)->throwResponse();
    }
}
