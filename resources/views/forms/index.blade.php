<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لیست فرم‌ها</title>
    <link href="https://cdn.fontcdn.ir/Font/Persian/Vazir/Vazir.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Vazir', sans-serif;
            background: #f2f2f2;
            padding: 2rem;
        }
        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 2rem;
            border-radius: .7rem;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        th, td {
            border: 1px solid #ddd;
            padding: .8rem;
            text-align: right;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        a.button {
            padding: .4rem 1rem;
            background-color: #28a745;
            color: white;
            border-radius: .4rem;
            text-decoration: none;
        }
        a.button:hover {
            background-color: #218838;
        }
        h2 {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>لیست فرم‌های ساخته شده</h2>

        <table>
            <thead>
                <tr>
                    <th>عنوان فرم</th>
                    <th>تعداد پاسخ‌ها</th>
                    <th>مشاهده پاسخ‌ها</th>
                    <th>لینک فرم</th>
                </tr>
            </thead>
            <tbody>
                @forelse($forms as $form)
                    <tr>
                        <td>{{ $form->title }}</td>
                        <td>{{ $form->responses_count }}</td>
                        <td><a class="button" href="{{ route('forms.responses', $form->slug) }}">نمایش پاسخ‌ها</a></td>
                        <td><a href="{{ route('forms.show', $form->slug) }}" target="_blank">نمایش فرم</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">فرمی وجود ندارد.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
