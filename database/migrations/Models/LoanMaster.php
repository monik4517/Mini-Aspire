<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanMaster extends Model
{
    use HasFactory;

    /**
     *The database table used by the model.
     *
     * @var string
     */
    protected $table = 'loan_master';

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'loan_type',
        'amount',
        'loan_term',
        'loan_date',
        'status'
    ];

    /**
     * select field
     *
     * @var string[]
     */
    protected $selectable = ['id', 'customer_id', 'loan_type', 'amount', 'loan_term', 'loan_date','status'];
}
