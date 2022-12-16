<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoanMaster;
use App\Http\Requests\LoanRequest;
use App\Traits\Loan;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\DataFalseResource;
use App\Http\Resources\DataTrueResource;
use App\Http\Resources\LoanResource;
use App\Http\Resources\ApproveResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AmountRequest;

class LoanController extends Controller
{
    use Loan;
    /**
     * loan_requirement
     *
     * @param  mixed $request
     * @return void
     */
    public function loan_requirement(LoanRequest $request)
    {
        DB::beginTransaction();
        try {
            $input = $request->all();
            $input['customer_id'] =  (Auth::hasUser()) ? auth()->user()->id : "";
            $input['loan_date'] =  date("Y-m-d");
            $loan_id = LoanMaster::create($input)->id;
            if (!empty($loan_id)) {
                $this->LoanInstallment($loan_id);
            }
            DB::commit();
            return new DataTrueResource(trans('messages.loan_request_success'));
        } catch (\Exception $e) {
            DB::rollback();
            return new DataFalseResource(trans('messages.something_wrong'));
        }
    }


    /**
     * display_loan_admin
     *
     * @return void
     */
    public function display_loan_admin()
    {
        $loan_data = LoanMaster::where('status', "pending")->orderBy('id', 'desc')->get();
        if (!empty($loan_data)) {
            return new LoanResource($loan_data);
        }
        return new DataFalseResource(trans('messages.no_data_found'));
    }

    /**
     * loan_approve_admin
     *
     * @param  mixed $loan
     * @return void
     */
    public function loan_approve_admin(Request $request, $id)
    {
        if (!empty($id)) {
            $loan_data = LoanMaster::where('id', $id)->where('status', 'pending')->first();
            if (!empty($loan_data)) {
                $res = $this->ApproveLoan(($loan_data));
                if (!$res) {
                    return new DataFalseResource(trans('messages.something_wrong'));
                }
                return new DataTrueResource(trans('messages.loan_approve'));
            }
        }
        return new DataFalseResource(trans('messages.no_data_found'));
    }

    /**
     * customer_view_loan   
     *
     * @return void
     */
    public function customer_view_loan()
    {
        $approve_loan = LoanMaster::where('status', "approved")->with('Installments')->get();
        if (!empty($approve_loan)) {
            return new ApproveResource($approve_loan);
        }
        return new DataFalseResource(trans('messages.no_data_found'));
    }


    /**
     * Repayment
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function Repayment(AmountRequest $request, $id)
    {
        if (!empty($id)) {
            $this->PaidInstallment($request->amount, $id);
            return new DataTrueResource(trans('messages.repayment'));
        }
        return new DataFalseResource(trans('messages.no_data_found'));
    }
}
