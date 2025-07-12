<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Form;

class FormController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'schema' => 'required|json',
        ]);

        $form = Form::create([
            'title' => $request->title,
            'slug' => Str::random(8),
            'schema' => $request->schema,
        ]);

        return response()->json([
            'message' => 'فرم با موفقیت ذخیره شد.',
            'link'    => route('forms.show', $form->slug)
        ]);
    }

    public function show($slug)
    {
        $form = Form::where('slug', $slug)->firstOrFail();
        return view('forms.show', compact('form'));
    }

    public function index()
    {
        $forms = Form::withCount('responses')->latest()->get();
        return view('forms.index', compact('forms'));
    }

    public function responses($slug)
    {
        $form = Form::where('slug', $slug)->firstOrFail();
        $responses = $form->responses()->with('items')->latest()->get();
        return view('forms.responses', compact('form', 'responses'));
    }
}
