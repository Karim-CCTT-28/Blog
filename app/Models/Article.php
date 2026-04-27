<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;


class Article extends Model
{
    protected $table = 'Articles';

    protected $fillable = [
        'title',
        'content',
        'images',
        'by'
    ];

    /**
     */

    # snake_case → camelCase
    # updated_at = updatedAt
protected function updatedAt(): Attribute
{
    return Attribute::make(
        get: function ($value) {
            $date = Carbon::parse($value)
                ->locale('ar')
                ->translatedFormat('j F Y');

            $english = ['0','1','2','3','4','5','6','7','8','9'];
            $arabic  = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];

            return str_replace($english, $arabic, $date);
        }
    );
}
}