<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Generator extends Model
{
    use HasFactory;

    public static function generateId($model)
    {
        do {
            $start = strtoupper(substr(class_basename($model), 0, 1));
            $end = strtoupper(substr(class_basename($model), -1));
            $number = str_pad(mt_rand(1, 999999999), 9, '0', STR_PAD_LEFT);

            $id = $start . $end . $number;
        } while ($model::where('id', $id)->exists());

        return $id;
    }

    public static function generateSlug($model, $name)
    {
        $slug = Str::slug($name);
        $count = $model::where('name', $name)->count();

        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        return $slug;
    }
}
