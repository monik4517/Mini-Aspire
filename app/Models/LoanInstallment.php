<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanInstallment extends Model
{
    use HasFactory;


    /**
     *The database table used by the model.
     *
     * @var string
     */
    protected $table = 'loan_installment';

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
        'loan_id',
        'amount',
        'status',
        'date_installment'
    ];

    protected $selectable = ['id', 'loan_id', 'amount', 'status','date_installment'];
}
