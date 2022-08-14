<?php

namespace App\Repositories;
use App\Models\CustomerLoanHeader;
use App\Models\CustomerLoanInstallment;
use Carbon\Carbon;

/**
 * Repository class for model.
 */
class LoanRepository extends BaseRepository
{
    /**
     * Creating Loan Request
     *
     * @param $request
     *
     * @return mixed
     */
    public function create_loan_request($request)
    {
    	$user = auth()->user();
        $loan_header = new CustomerLoanHeader();
        $loan_header->user_id = $user->id;
        $loan_header->loan_amount = $request->loan_amount;
        $loan_header->loan_term = $request->loan_term;
        $loan_header->save();

        $date = Carbon::now();
        $installment_amt = $request->loan_amount/$request->loan_term;

        for($i = 1; $i <= $request->loan_term; $i++){
            $loan_detail = new CustomerLoanInstallment();
            $loan_detail->customer_loan_header_id = $loan_header->id;
            $loan_detail->installment_amt = $installment_amt;
            $loan_detail->remaining_amt = $installment_amt;
            $loan_detail->installment_date = Carbon::now()->addWeeks($i)->toDateString();
            $loan_detail->save();
        }

        $loan_header->loan_number = 'Aspire_'.str_pad($loan_header->id,6,0,STR_PAD_LEFT);
        $loan_header->save();

        return $loan_header;
    }
    

    /**
     * Loan List
     *
     * @param $user_id
     *
     * @return mixed
     */

    public function loan_list($user_id = null){
        $result_obj = CustomerLoanHeader::with('installments','user');
        if($user_id != ''){
            $result_obj->where('user_id',$user_id);
        }
        $result = $result_obj->get();

        return $result;
    }

    public function loand_detail($id){
        $row = CustomerLoanHeader::with('installments','user')->find($id);
        return $row;
    }

    public function approve_loan($id){
        $row = CustomerLoanHeader::find($id);
        $row->status = 'Approved';
        $row->save();
        return $row;
    }


    public function loand_repayment($request){
        $user = auth()->user();
        $amount = $request->amount;
        $loan_number = $request->loan_number;

        $isLoanNumberApproved = CustomerLoanHeader::where('loan_number',$loan_number)->first();
        if($isLoanNumberApproved->status == 'Pending'){
            return ['error' => true, 'message' => 'Loan request has not been approved yet'];
        }

        if($isLoanNumberApproved->status == 'Paid'){
            return ['error' => true, 'message' => 'Loan is already closed'];
        }

        $CheckInstallmentAmount = $this->unpaidinstallment($isLoanNumberApproved->id);
        if($CheckInstallmentAmount){
            $installment_amt = $CheckInstallmentAmount->installment_amt;
            if($amount < $installment_amt){
                return ['error' => true, 'message' => 'Amount can not be less then installment amouont'];
            }
        }

        $result = $this->UpdateUnpaidInstallment($isLoanNumberApproved->id,$amount);
        $this->UpdateLoanStatus($isLoanNumberApproved->id);

        return $result;

    }

    private function unpaidinstallment($id){
        $row = CustomerLoanInstallment::where('customer_loan_header_id',$id)->where('status','Pending')->first();
        return $row;
    }

    private function UpdateUnpaidInstallment($customer_loan_header_id,$amount){
        $UnpaidInstallment = $this->unpaidinstallment($customer_loan_header_id);
        
        if($UnpaidInstallment){
            $installment_amt = $UnpaidInstallment->installment_amt;
            $remaining_amt = $UnpaidInstallment->remaining_amt;
            $new_remaining_amt = $remaining_amt - $amount;
            $UnpaidInstallment->remaining_amt = $new_remaining_amt;
            if($new_remaining_amt <= 0){
                $UnpaidInstallment->status = 'Paid';
                $UnpaidInstallment->remaining_amt = 0;
            }
            $UnpaidInstallment->save();

            if($new_remaining_amt < 0){
               return $this->UpdateUnpaidInstallment($customer_loan_header_id,abs($new_remaining_amt));
            }
        }
        
        return ['error' => false, 'message' => 'Success'];
    }

    private function UpdateLoanStatus($id){
        $UnpaidInstallments = $this->unpaidinstallment($id);
        if(!$UnpaidInstallments){
            $CLH = CustomerLoanHeader::find($id);
            $CLH->status = 'Paid';
            $CLH->save();           
        }
    }
}