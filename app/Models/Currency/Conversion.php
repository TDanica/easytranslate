<?php

namespace App\Models\Currency;

use Illuminate\Database\Eloquent\Model;

class Conversion extends Model
{
    protected $fillable = [
        'from_currency_id',
        'to_currency_id',
        'amount',
        'rate',
        'result',
    ];

    /**
     * Get the source currency of the conversion.
     */
    public function fromCurrency()
    {
        return $this->belongsTo(Currency::class, 'from_currency_id');
    }

    /**
     * Get the target currency of the conversion.
     */
    public function toCurrency()
    {
        return $this->belongsTo(Currency::class, 'to_currency_id');
    }
}
