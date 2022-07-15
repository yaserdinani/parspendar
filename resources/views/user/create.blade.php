@extends('layouts.app')
@section('title', 'افزودن کاربر')
@section('content')
<div class="card">
    <div class="card-header text-center">
      <h3>ساخت کاربر جدید</h3>
    </div>
    <div class="card-body">
        <form action="{{route('users.store')}}" method="post">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-6 text-right">
                    <label for="phone">موبایل</label>
                    <input type="tel" class="form-control text-right" name="phone" id="phone" placeholder="موبایل" required autocomplete="off" value="{{old('phone')}}">
                </div>
              <div class="form-group col-md-6 text-right">
                <label for="name">نام و نام خانوادگی</label>
                <input type="text" class="form-control text-right" name="name" id="name" placeholder="نام و نام خانوادگی" required autocomplete="off" value="{{old('name')}}">
              </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6 text-right">
                    <label for="role">نقش</label>
                    <select id="role" class="form-control text-right" name="role">
                      <option value="0" selected>کاربر عادی</option>
                      <option value="1">مدیر</option>
                    </select>
                </div>
                <div class="form-group col-md-6 text-right">
                  <label for="email">ایمیل</label>
                  <input type="email" class="form-control text-right" name="email" id="email" placeholder="ایمیل" required autocomplete="off" value="{{old('email')}}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6 text-right">
                    <label for="password_confirmation">تکرار رمز عبور</label>
                    <input type="password" class="form-control text-right" name="password_confirmation" id="password_confirmation" placeholder="تکرار رمز عبور" required autocomplete="off">
                </div>
                <div class="form-group col-md-6 text-right">
                  <label for="password">رمز عبور</label>
                  <input type="password" class="form-control text-right" name="password" id="password" placeholder="رمز عبور" required autocomplete="off">
                </div>
              </div>
            <button type="submit" class="btn btn-success">افزودن</button>
        </form>
    </div>
</div>
@endsection