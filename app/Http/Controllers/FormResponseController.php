<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use Illuminate\Support\Str;

class FormResponseController extends Controller
{
    public function store(Request $request, $slug)
    {
        $form = Form::where('slug', $slug)->firstOrFail();
        $schema = json_decode($form->schema, true);

        $response = $form->responses()->create([
            'user_ip' => $request->ip(),
        ]);

        foreach ($schema as $field) {
            $name = $field['name'] ?? null;
            if (!$name) continue;

            $label = $field['label'] ?? $name;
            $type = $field['type'] ?? 'text';
            $value = null;

            if ($type === 'file' && $request->hasFile($name)) {
                $value = $request->file($name)->store('form_uploads', 'public');
            } elseif ($type === 'checkbox-group') {
                $value = is_array($request->input($name)) ? json_encode($request->input($name), JSON_UNESCAPED_UNICODE) : null;
            } else {
                $value = $request->input($name);
            }

            $response->items()->create([
                'field_name'  => $name,
                'field_label' => $label,
                'field_value' => $value,
            ]);
        }

        return redirect()->back()->with('success', 'پاسخ شما با موفقیت ثبت شد.');
    }
}

