<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Customer\CreateLoanRequest;
use App\Services\LoanService;

class LoansController extends Controller
{
    public function __construct(LoanService $service)
	{
        $this->service = $service;
	}

    public function loan_requests(){
        $result = $this->service->loan_list();
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

    public function approve_loan($id){
        $row = $this->service->approve_loan($id);
        if($row){
            return response()->json(['error' => false, 'message' => 'Success', 'data' => $row], 200);
        }else{
            return response()->json(['error' => true, 'message' => 'No data found'], 401);
        }
    }
}
