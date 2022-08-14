<?php

namespace App\Services;

use App\Repositories\LoanRepository;

/**
 * supplier class to handle operator interactions.
 */

class LoanService
{
    public function __construct(LoanRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create_loan_request($request)
    {
        return $this->repository->create_loan_request($request);
    }

    public function loan_list($user_id=null){
        return $this->repository->loan_list($user_id);
    }

    public function loand_detail($id){
        return $this->repository->loand_detail($id);
    }

    public function approve_loan($id){
        return $this->repository->approve_loan($id);
    }

    public function loand_repayment($request){
        return $this->repository->loand_repayment($request);
    }

    
}