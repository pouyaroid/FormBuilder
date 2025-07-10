<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Form;
use App\Models\FormField;

class FormController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'schema' => 'required|json',
    ]);

    $schema = json_decode($request->schema, true);

    $form = Form::create([
        'title' => $request->title,
        'slug' => Str::random(8),
        'schema' => $request->schema, // ذخیره کل JSON خام برای نمایش فرم
    ]);

    // استخراج فیلدها از schema و ذخیره دقیق همه اطلاعات
    if (!empty($schema['fields'])) {
        foreach ($schema['fields'] as $index => $field) {
            FormField::create([
                'form_id'         => $form->id,
                'label'           => $field['label'] ?? 'بدون عنوان',
                'name'            => $field['name'] ?? Str::slug($field['label'] ?? 'field'),
                'type'            => $field['type'] ?? 'text',
                'placeholder'     => $field['placeholder'] ?? null,
                'default_value'   => $field['defaultValue'] ?? null,
                'help_text'       => $field['description'] ?? null,
                'validation_rules'=> isset($field['validations']) ? implode('|', $field['validations']) : null,
                'options'         => isset($field['options']) ? json_encode($field['options']) : null,
                'order'           => $index,
                'is_required'     => $field['required'] ?? false,
            ]);
        }
    }

    return response()->json([
        'message' => 'فرم با موفقیت ذخیره شد',
        'link'    => url('/forms/' . $form->slug)
    ]);
}

    /**
     * ذخیره پاسخ فرم شامل فایل‌ها
     */
    public function submitResponse(Request $request, $slug)
    {
        $form = Form::where('slug', $slug)->firstOrFail();

        $response = $form->responses()->create([
            'user_ip' => $request->ip(),
        ]);

        foreach ($request->all() as $key => $value) {
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $path = $file->store('form_uploads', 'public');
                $value = $path;
            }

            $response->items()->create([
                'field_name'  => $key,
                'field_value' => is_array($value) ? json_encode($value) : $value,
            ]);
        }

        return response()->json([
            'message' => 'پاسخ با موفقیت ثبت شد'
        ]);
    }
    public function show($slug)
{
    $form = Form::where('slug', $slug)->firstOrFail();
    return view('forms.show', compact('form'));
}
public function responses($slug)
{
    $form = Form::where('slug', $slug)->firstOrFail();

    $responses = $form->responses()->with('items')->latest()->get();

    return view('forms.responses', compact('form', 'responses'));
}
public function index()
{
    $forms = Form::withCount('responses')->latest()->get();
    return view('forms.index', compact('forms'));
}

}
