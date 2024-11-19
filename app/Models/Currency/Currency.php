<?php

namespace App\Models\Currency;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
    ];

    /**
     * Get all conversions where this currency is the source.
     */
    public function conversionsFrom()
    {
        return $this->hasMany(Conversion::class, 'from_currency_id');
    }

    /**
     * Get all conversions where this currency is the target.
     */
    public function conversionsTo()
    {
        return $this->hasMany(Conversion::class, 'to_currency_id');
    }
}
