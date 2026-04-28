@extends('layouts.auth')

@section('title', 'تسجيل الدخول')

@section('content')

<div class="form-title">مرحباً بك 👋</div>
<p class="form-subtitle">سجّل دخولك للوصول إلى لوحة الإدارة</p>

@if(session('error'))
    <div class="alert alert-error">{{ session('error') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-error">{{ $errors->first() }}</div>
@endif

<form method="POST" action="/login">
    @csrf

    <div class="form-group">
        <label class="form-label" for="email">البريد الإلكتروني</label>
        <input class="form-input" type="email" id="email" name="email"
               placeholder="admin@example.com" value="{{ old('email') }}" required autofocus>
    </div>

    <div class="form-group">
        <label class="form-label" for="password">كلمة المرور</label>
        <input class="form-input" type="password" id="password" name="password"
               placeholder="••••••••" required>
    </div>

    <button class="btn-primary" type="submit">تسجيل الدخول</button>
</form>

<div class="auth-link">
    ليس لديك حساب؟ <a href="/new-user">إنشاء حساب جديد</a>
</div>

@endsection