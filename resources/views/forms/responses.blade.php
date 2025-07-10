<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>پاسخ‌های فرم {{ $form->title }}</title>
    <link href="https://cdn.fontcdn.ir/Font/Persian/Vazir/Vazir.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Vazir', sans-serif;
            padding: 2rem;
            background: #f8f9fa;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
        }
        th, td {
            border: 1px solid #ccc;
            padding: .7rem;
            text-align: right;
        }
        th {
            background: #007bff;
            color: white;
        }
        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 2rem;
            border-radius: .5rem;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>پاسخ‌های فرم: {{ $form->title }}</h2>

    @forelse($responses as $response)
        <h4>پاسخ #{{ $response->id }} (IP: {{ $response->user_ip }})</h4>
        <table>
            <thead>
                <tr>
                    <th>فیلد</th>
                    <th>پاسخ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($response->items as $item)
                    <tr>
                        <td>{{ $item->field_name }}</td>
                        <td>
                            @if(Str::endsWith($item->field_value, ['.jpg', '.png', '.jpeg', '.pdf']))
                                <a href="{{ asset('storage/' . $item->field_value) }}" target="_blank">مشاهده فایل</a>
                            @else
                                {{ $item->field_value }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @empty
        <p>هنوز هیچ پاسخی ثبت نشده است.</p>
    @endforelse
</div>

</body>
</html>
