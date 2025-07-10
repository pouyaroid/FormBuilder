<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormResponseItem extends Model
{
    protected $fillable = ['form_response_id', 'field_name', 'field_value'];

    public function response()
    {
        return $this->belongsTo(FormResponse::class, 'form_response_id');
    }
}
