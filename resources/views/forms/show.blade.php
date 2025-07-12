<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>{{ $form->title }}</title>
  <link href="https://cdn.fontcdn.ir/Font/Persian/Vazir/Vazir.css" rel="stylesheet">
  <style>
    body { font-family: 'Vazir', sans-serif; background: #f2f2f2; padding: 2rem; direction: rtl; }
    .form-wrapper { background: white; max-width: 700px; margin: auto; padding: 2rem; border-radius: 1rem; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    input, select, textarea { width: 100%; padding: .7rem; margin-bottom: 1rem; border: 1px solid #ccc; border-radius: .5rem; font-family: 'Vazir'; }
    input[type="radio"], input[type="checkbox"] { width: auto; margin-left: 0.5rem; }
    label { display: block; margin-bottom: .3rem; font-weight: bold; }
    button { background: #28a745; color: white; padding: .7rem 2rem; border: none; border-radius: .5rem; cursor: pointer; }
    button:hover { background: #218838; }
    .error { color: red; font-size: 0.9rem; margin-top: -0.5rem; margin-bottom: 0.5rem; }
  </style>
</head>
<body>

<div class="form-wrapper">
  <h2>{{ $form->title }}</h2>

  @if ($errors->any())
    <div class="error">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('forms.submit', $form->slug) }}" enctype="multipart/form-data">
    @csrf

    @php
      $fields = json_decode($form->schema, true);
    @endphp

    @foreach($fields as $field)
      @php
        $name = $field['name'] ?? \Illuminate\Support\Str::slug($field['label'] ?? 'field');
        $required = isset($field['required']) && $field['required'] ? 'required' : '';
      @endphp

      <label for="{{ $name }}">{{ $field['label'] ?? 'بدون عنوان' }}</label>

      @switch($field['type'])
          @case('textarea')
              <textarea name="{{ $name }}" id="{{ $name }}" {{ $required }}>{{ old($name) }}</textarea>
              @break

          @case('select')
              <select name="{{ $name }}" id="{{ $name }}" {{ $required }}>
                  <option value="">-- انتخاب کنید --</option>
                  @foreach($field['values'] ?? [] as $option)
                      <option value="{{ $option['value'] }}" {{ old($name) == $option['value'] ? 'selected' : '' }}>{{ $option['label'] }}</option>
                  @endforeach
              </select>
              @break

          @case('radio-group')
              @foreach($field['values'] ?? [] as $option)
                  <div>
                      <input type="radio" id="{{ $name }}_{{ $loop->index }}" name="{{ $name }}" value="{{ $option['value'] }}" {{ old($name) == $option['value'] ? 'checked' : '' }} {{ $required }}>
                      <label for="{{ $name }}_{{ $loop->index }}">{{ $option['label'] }}</label>
                  </div>
              @endforeach
              @break

          @case('checkbox-group')
              @foreach($field['values'] ?? [] as $option)
                  <div>
                      <input type="checkbox" id="{{ $name }}_{{ $loop->index }}" name="{{ $name }}[]" value="{{ $option['value'] }}" {{ is_array(old($name)) && in_array($option['value'], old($name)) ? 'checked' : '' }}>
                      <label for="{{ $name }}_{{ $loop->index }}">{{ $option['label'] }}</label>
                  </div>
              @endforeach
              @break

          @case('file')
              <input type="file" name="{{ $name }}" id="{{ $name }}" {{ $required }}>
              @break

          @default
              <input type="{{ $field['type'] ?? 'text' }}" name="{{ $name }}" id="{{ $name }}" value="{{ old($name, $field['defaultValue'] ?? '') }}" {{ $required }}>
      @endswitch

    @endforeach

    <button type="submit">ارسال</button>
  </form>
</div>

</body>
</html>
