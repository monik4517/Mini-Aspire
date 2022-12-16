<?php

namespace App\Scopes;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class LoanScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if (Auth::hasUser()) {
            if (auth()->user()->roles == config('constants.role.customer')) {
                $builder->select($model->getSelectable())
                    ->where('customer_id', auth()->user()->id);
            }
        }
    }
}
