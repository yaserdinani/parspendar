@extends('layouts.auth')
@section('title','ورود')
@section('content')
<div class="d-flex flex-column justify-content-center" style="height: 100vh;">
    @if(session('message'))
        <div class="alert alert-danger text-center">{{session('message')}}</div>
    @endif
    <div class="text-center">
        <form class="form-signin" method="post" action="{{route('auth.login')}}">
            @csrf
            <img class="mb-4" src="{{asset('images/logo.jpeg')}}" alt="هولدینگ پارس پندار نهاد">
            <h1 class="h3 mb-3 font-weight-normal">ورود مدیریت</h1>
            <input type="tel" id="phone" class="form-control" name="phone" placeholder="شماره موبایل" required autocomplete="off">
            @error('phone')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <input type="password" id="password" class="form-control mt-3" name="password" placeholder="رمز عبور" required autocomplete="off">
            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <button class="btn btn-lg btn-danger btn-block mt-4" type="submit">ورود</button>
        </form>
    </div>
</div>    
@endsection