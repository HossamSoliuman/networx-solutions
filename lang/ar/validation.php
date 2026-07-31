<?php

return [
    'required' => 'حقل :attribute مطلوب.',
    'required_if' => 'حقل :attribute مطلوب.',
    'email' => 'يرجى إدخال بريد إلكتروني صحيح.',
    'string' => 'يجب أن تكون قيمة :attribute نصًا.',
    'integer' => 'يجب أن تكون قيمة :attribute رقمًا صحيحًا.',
    'exists' => 'الخيار المحدد في :attribute غير متاح.',
    'in' => 'القيمة المحددة في :attribute غير صحيحة.',
    'regex' => 'صيغة :attribute غير صحيحة.',
    'prohibited' => 'حقل :attribute غير مسموح به.',
    'min' => [
        'string' => 'يجب ألا يقل :attribute عن :min أحرف.',
    ],
    'max' => [
        'string' => 'يجب ألا يتجاوز :attribute :max حرفًا.',
    ],
    'attributes' => [
        'name' => 'الاسم',
        'email' => 'بريد العمل',
        'phone_country' => 'رمز الدولة',
        'phone_local' => 'رقم الهاتف',
        'company' => 'الشركة',
        'subject' => 'الموضوع',
        'message' => 'الرسالة',
        'service_id' => 'الخدمة',
        'g-recaptcha-response' => 'اختبار التحقق',
    ],
];
