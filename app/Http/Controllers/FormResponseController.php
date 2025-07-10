<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\FormResponse;
use App\Models\FormResponseItem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class FormResponseController extends Controller
{
    public function store(Request $request, $slug)
    {
        $form = Form::where('slug', $slug)->firstOrFail();
        $schema = json_decode($form->schema, true);

        $response = FormResponse::create([
            'form_id' => $form->id,
        ]);

        foreach ($schema as $field) {
            $name = $field['name'] ?? Str::slug($field['label'] ?? 'field');
            $type = $field['type'] ?? 'text';
            $value = null;

            if ($type === 'file' && $request->hasFile($name)) {
                $file = $request->file($name);
                $path = $file->store('form_uploads', 'public');
                $value = $path;
            } elseif (in_array($type, ['checkbox-group'])) {
                $value = is_array($request->input($name)) ? json_encode($request->input($name)) : null;
            } else {
                $value = $request->input($name);
            }

            FormResponseItem::create([
                'form_response_id' => $response->id,
                'field_name'       => $name,
                'value'            => $value,
            ]);
        }

        return redirect()->back()->with('success', 'فرم با موفقیت ارسال شد.');
    }
}
