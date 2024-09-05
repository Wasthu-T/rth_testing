<?php

namespace App\Models\Traits;


trait HasUuid
{
    protected static function bootHasUuid()
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = self::generateNumericUuid();
                return $model;
            }
        });
    }

    protected static function generateNumericUuid()
    {
        $timestamp = (int)(microtime(true) * 10); // Mengubah menjadi integer dan mengalikan dengan 10
        $timestampString = substr((string)$timestamp, 0, 7); // Ambil 7 digit pertama dari timestamp
        $randomInt = random_int(1000, 9999); // 4 digit acak
        return $timestampString . (string)$randomInt;
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}
