<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Totalsize implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $total_size = array_reduce($value, function ($sum, $item) {
            $sum += filesize($item->path());
            return $sum;
        });

        if ($total_size >(2 * 1024 * 1024)) {
            $fail('Ukuran tidak boleh melebihi 2mb.');
        }
    }
}
