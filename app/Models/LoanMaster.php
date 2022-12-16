<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\AuthorisedCustomer;
class LoanMaster extends Model
{
    use HasFactory,AuthorisedCustomer;

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

    /**
     * Get Select field in Loan query
     */
    public function getSelectable()
    {
        return $this->selectable;
    }
       /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Installments()
    {
        return $this->hasMany(LoanInstallment::Class, 'loan_id', 'id');
    }
}
