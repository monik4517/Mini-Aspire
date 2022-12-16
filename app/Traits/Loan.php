<?php

namespace App\Traits;

use App\Models\LoanInstallment;
use App\Models\LoanMaster;
use Illuminate\Support\Facades\DB;

trait Loan
{

    /**
     * LoanInstallment
     *
     * @param  mixed $loan_id
     * @return void
     */
    public function LoanInstallment($loan_id)
    {
        $term = LoanMaster::where('id', $loan_id)->select('loan_term', 'amount')->first();
        $installment_arr = [];
        if (!empty($term)) {
            $loan_term = isset($term->loan_term) ? $term->loan_term : 0;
            $amount = isset($term->amount) ? $term->amount : 0;
            for ($i = 1; $i <= $loan_term; $i++) {
                $installment_arr[$i]['loan_id'] = $loan_id;
                $installment_arr[$i]['amount'] = $amount / $loan_term;
                $installment_arr[$i]['created_at'] = now();
                $installment_arr[$i]['updated_at'] = now();
            }
            if (!empty($installment_arr)) {
                LoanInstallment::insert($installment_arr);
            }
        }
    }

    /**
     * ApproveLoan
     *
     * @param  mixed $data
     * @return void
     */
    public function ApproveLoan($data)
    {
        DB::beginTransaction();
        try {
            if (!empty($data)) {
                $data->update([
                    'status' => 'approved'
                ]);
                for ($i = 1; $i <= $data->loan_term; $i++) {
                    $date = strtotime(date("Y-m-d", strtotime($data->loan_date)) . " +" . $i . " week");
                    $date = date('Y-m-d', $date);
                    $weekly = LoanInstallment::where('loan_id', $data->id)->WhereNull('date_installment')->first();
                    if (!empty($weekly)) {
                        $weekly->update([
                            'date_installment' => $date
                        ]);
                    }
                }
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }
    
    /**
     * PaidInstallment
     *
     * @param  mixed $amount
     * @param  mixed $id
     * @return void
     */
    public function PaidInstallment($amount, $id)
    {
        $loan_status = LoanInstallment::where('id', $id)->first();
        if (!empty($loan_status)) {
            $loan_status->update([
                'status' => 'paid',
                'amount' => $amount
            ]);
            $check_paid_loan = LoanInstallment::where('loan_id', $loan_status->loan_id)->where('status', 'pending')->first();
            if (empty($check_paid_loan)) {
                $main_loan =  LoanMaster::where('id', $loan_status->loan_id)->first();
                if (!empty($main_loan)) {
                    $main_loan->update([
                        'status' => 'paid',
                    ]);
                }
            }
        }
    }
}
