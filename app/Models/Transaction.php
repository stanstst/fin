<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/** @property float $amount */
/** @property string $type */
/** @property UserTransactionAccount $account */
/** @method static Transaction create(array $props) */
class Transaction extends Model
{
    use HasFactory;

    const CREDIT_TYPE = 'credit';
    const DEBIT_TYPE = 'debit';
    const TYPES = [self::CREDIT_TYPE, self::DEBIT_TYPE];

    protected $fillable = ['amount', 'type', 'account_id'];

    public function account()
    {
        return $this->belongsTo(UserTransactionAccount::class, 'account_id');
    }
}
