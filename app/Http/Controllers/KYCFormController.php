<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KYCForm;
use \Firebase\JWT\JWT;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class KYCFormController extends Controller
{
    public function getKYC()
    {
        $kyc = KYCForm::find(Auth::user()->id);
        if ($kyc) {
            return [
                "kyc" => $kyc
            ];
        } else {
            return response([
                "message" => "KYC Form is not filled"
            ], 403);
        }
    }

    public function insertKYC(Request $request)
    {
        $kyc = KYCForm::where(['user_id' => Auth::user()->id]);
        if ($kyc) {
            return response([
                "message" => "KYC form already filled."
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'father_name' => 'required',
            'mother_name' => 'required',
            'grandfather_name' => 'required',
            'occupation' => 'required',
            'district' => 'required',
            'municipality' => 'required',
            'ward_number' => 'required',
            'identity_type' => 'required',
            'identity_number' => 'required',
            'issued_date' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                "message" => $validator->messages()->first()
            ], 422);
        }

        $inputs = $request->all();

        $inputs['user_id'] = Auth::user()->id;

        $kyc = KYCForm::create($inputs);

        return [
            "message" => "KYC Form Filled",
        ];
    }
}
