<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Customer\CreateLoanRequest;
use App\Services\LoanService;

class CustomerLoansController extends Controller
{
    public function __construct(LoanService $service)
	{
        $this->service = $service;
	}

    public function create_loan_request(CreateLoanRequest $request){
        $result = $this->service->create_loan_request($request);
        return response()->json(['error' => false, 'message' => 'Success', 'data' => $result], 200);
    }

    public function requested_loan_list(){
        $user = auth()->user();
        $result = $this->service->loan_list($user->id);
        if($result){
            return response()->json(['error' => false, 'message' => 'Success', 'data' => $result], 200);
        }else{
            return response()->json(['error' => true, 'message' => 'No data found'], 401);
        }
    }

    public function loand_detail($id){
        $row = $this->service->loand_detail($id);
        if($row){
            return response()->json(['error' => false, 'message' => 'Success', 'data' => $row], 200);
        }else{
            return response()->json(['error' => true, 'message' => 'No data found'], 401);
        }
    }

    public function loand_repayment(Request $request){
        $request->validate([
            'amount' => 'required|numeric',
            'loan_number' => 'required|exists:customer_loan_headers'
        ]);

        $result = $this->service->loand_repayment($request);
        if(isset($result['error']) && $result['error'] == false){
            return response()->json($result, 200);
        }else{
            return response()->json($result, 401);
        }


        
    }



}
