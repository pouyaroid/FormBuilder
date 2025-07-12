<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormResponseItem extends Model
{
    protected $fillable = [
        'form_response_id',
        'field_name',
        'field_label',
        'field_value',
    ];

    public $timestamps = true;

    public function response()
    {
        return $this->belongsTo(FormResponse::class);
    }
}
