<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormResponse extends Model
{
    protected $fillable = ['form_id', 'user_ip','submitted_at'];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function items()
    {
        return $this->hasMany(FormResponseItem::class);
    }
}
