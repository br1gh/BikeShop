<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parameter extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    public static function getTypes(): array
    {
        return [
            'integer' => 'Integer',
            'integer with unit' => 'Integer with unit',
            'float' => 'Float',
            'float with unit' => 'Float with unit',
            'text' => 'Text',
            'text with unit' => 'Text with unit',
            'checkbox' => 'Checkbox',
            'part' => 'Part',
        ];
    }
}
