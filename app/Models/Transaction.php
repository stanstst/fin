<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/** @property float $amount */
/** @property string $type */
/** @property UserTransactionAccount $account */
class Transaction extends Model
{
    use HasFactory;

    const CREDIT_TYPE = 'credit';
    const DEBIT_TYPE = 'debit';

    public function account()
    {
        return $this->belongsTo(UserTransactionAccount::class, 'account_id');
    }
}
