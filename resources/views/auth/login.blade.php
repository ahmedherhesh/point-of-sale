@extends('base')
@section('content')
    <form action="" class="ctm-form">
        <div class="logo flex justify-center">
            <img src="{{asset('imgs/logo-80.png')}}" alt="">
        </div>
        <h4 class="text-center text-2xl py-6">تسجيل الدخول</h4>
        <div>
            <label class="label" for="username">اسم المستخدم :</label>
            <input type="text" name="username" class="input input-indigo" id="username" >
        </div>
        <div>
            <label class="label" for="username">كلمة السر :</label>
            <input type="password" name="password" class="input input-indigo" >
        </div>
        <button class="btn btn-indigo w-full">تسجيل دخول</button>
    </form>
@endsection
