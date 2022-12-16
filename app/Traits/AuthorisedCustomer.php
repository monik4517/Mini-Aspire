<?php

namespace App\Traits;

use App\Scopes\LoanScope;
use Illuminate\Support\Facades\Auth;

trait AuthorisedCustomer
{
    /**
     * Boot
     */
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $user = Auth::user();
            if ($user) {
                if (auth()->user()->roles == config('constants.role.customer')) {
                $model->customer_id = $user->id;}
            }

        });
    }

    /**
     */
    public static function bootAuthorisedCustomer()
    {
        static::addGlobalScope(new LoanScope());
    }
}
