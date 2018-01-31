<?php

namespace Maxfactor\Support;

use Illuminate\Support\Carbon;

class Format
{
    public function money($amount, $zeroValue = '0.00', $decimals = 2)
    {
        if (!is_numeric($amount) || $amount <= 0) {
            return $zeroValue;
        }

        return number_format($amount, $decimals);
    }

    public function currentYear()
    {
        return Carbon::now()->format('Y');
    }
}
