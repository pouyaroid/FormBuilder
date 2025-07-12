<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>فرم‌ساز داینامیک</title>

  <!-- فونت فارسی -->
  <link href="https://cdn.fontcdn.ir/Font/Persian/Vazir/Vazir.css" rel="stylesheet" />

  <!-- استایل فرم‌ساز -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
  <link rel="stylesheet" href="https://formbuilder.online/assets/css/form-builder.min.css" />

  <style>
    body {
      font-family: 'Vazir', sans-serif;
      background: #f7f9fb;
      direction: rtl;
      text-align: right;
      padding: 2rem;
    }

    .form-builder-container {
      background: white;
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: 0 0 10px rgb(0 0 0 / 0.1);
      max-width: 900px;
      margin: auto;
    }

    input, button {
      font-family: 'Vazir', sans-serif;
    }

    #save-form {
      background-color: #007bff;
      color: white;
      border: none;
      padding: 0.7rem 1.5rem;
      border-radius: 0.5rem;
      cursor: pointer;
      margin-top: 1rem;
    }

    #save-form:hover {
      background-color: #0056b3;
    }

    #form-response {
      margin-top: 1rem;
      padding: 1rem;
      background-color: #d4edda;
      color: #155724;
      border-radius: 0.5rem;
      display: none;
    }
  </style>
</head>
<body>

  <div class="form-builder-container">
    <h2>فرم‌ساز داینامیک</h2>

    <label for="form-title">عنوان فرم:</label>
    <input type="text" id="form-title" placeholder="مثلاً: فرم ثبت‌نام رویداد" style="width:100%;padding:0.5rem;border-radius:0.5rem;border:1px solid #ccc;margin-bottom:1rem" />

    <div id="form-builder"></div>

    <button id="save-form">ذخیره فرم</button>

    <div id="form-response"></div>
  </div>

  <!-- jQuery و jQuery UI -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

  <!-- FormBuilder -->
  <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>

  <script>
    $(function () {
      const options = {
        showActionButtons: true,
        controlOrder: [
          'header', 'paragraph', 'text', 'number', 'textarea', 'select',
          'checkbox-group', 'radio-group', 'date', 'file', 'button'
        ],
        i18n: {
          locale: 'fa',
          strings: {
            add: "افزودن",
            remove: "حذف",
            save: "ذخیره",
            edit: "ویرایش",
            cancel: "لغو",
            close: "بستن",
            required: "الزامی",
            options: "گزینه‌ها",
            label: "برچسب",
            className: "کلاس CSS",
            placeholder: "متن پیش‌فرض",
            description: "توضیحات",
            type: "نوع فیلد",
            subtype: "زیرنوع",
            text: "متن",
            textarea: "متن چندخطی",
            header: "عنوان",
            paragraph: "پاراگراف",
            number: "عدد",
            date: "تاریخ",
            select: "لیست کشویی",
            checkboxGroup: "چک‌باکس گروهی",
            radioGroup: "دکمه‌های رادیویی",
            file: "فایل",
            name: "نام فیلد",
            access: "دسترسی",
            other: "سایر",
            selectOptions: "گزینه‌های انتخابی",
            inline: "افقی",
            multiple: "چند انتخابی",
            toggle: "تغییر وضعیت",
            addOption: "افزودن گزینه",
            removeOption: "حذف گزینه",
            defaultValue: "مقدار پیش‌فرض",
            value: "مقدار",
            advanced: "پیشرفته",
            requiredField: "فیلد الزامی",
            preview: "پیش‌نمایش",
            form: "فرم",
            button: "دکمه",
            style: "استایل"
          }
        }
      };

      const formBuilder = $('#form-builder').formBuilder(options);

      $('#save-form').click(async function () {
        const title = $('#form-title').val().trim();
        if (!title) {
          alert('عنوان فرم را وارد کنید!');
          return;
        }

        const formData = formBuilder.actions.getData('json');

        try {
          const response = await fetch("{{ route('forms.store') }}", {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: JSON.stringify({
              title: title,
              schema: formData
            })
          });

          const data = await response.json();
          if (response.ok) {
            $('#form-response').text("✅ فرم با موفقیت ذخیره شد. لینک فرم: " + data.link).show();
            $('#form-title').val('');
          } else {
            alert('❌ خطا در ذخیره فرم: ' + (data.message || ''));
          }
        } catch (err) {
          alert('❌ خطا در ارتباط با سرور');
          console.error(err);
        }
      });
    });
  </script>

</body>
</html>
