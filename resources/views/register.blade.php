@extends('layouts.auth')

@section('title', 'إنشاء حساب')

@section('content')

<div class="form-title">إنشاء حساب جديد 🚀</div>
<p class="form-subtitle">أنشئ حسابك للبدء في إدارة المدونة</p>

@if($errors->any())
    <div class="alert alert-error">
        @foreach($errors->all() as $error)
            <div>• {{ $error }}</div>
        @endforeach
    </div>
@endif

<form method="POST" action="/register">
    @csrf

    <div class="form-group">
        <label class="form-label" for="name">الاسم الكامل</label>
        <input class="form-input" type="text" id="name" name="name"
               placeholder="أدخل اسمك" value="{{ old('name') }}" required autofocus>
    </div>

    <div class="form-group">
        <label class="form-label" for="email">البريد الإلكتروني</label>
        <input class="form-input" type="email" id="email" name="email"
               placeholder="admin@example.com" value="{{ old('email') }}" required>
    </div>

    <div class="form-group">
        <label class="form-label" for="password">كلمة المرور</label>
        <input class="form-input" type="password" id="password" name="password"
               placeholder="••••••••" required>
    </div>

    <button class="btn-primary" type="submit">إنشاء الحساب</button>
</form>

<div class="auth-link">
    لديك حساب بالفعل؟ <a href="/">تسجيل الدخول</a>
</div>

@endsection