@extends('layouts.app')
@section('title', 'ویرایش کاربر')
@section('content')
<div class="card">
    <div class="card-header text-center">
      <h3>ویرایش کاربر</h3>
    </div>
    <div class="card-body">
        <form action="{{route('users.update',$user)}}" method="post">
            @csrf
            @method('put')
            <div class="form-row">
                <div class="form-group col-md-6 text-right">
                    <label for="phone">موبایل</label>
                    <input type="tel" class="form-control text-right" name="phone" id="phone" placeholder="موبایل" required autocomplete="off" value="{{$user->phone}}">
                </div>
              <div class="form-group col-md-6 text-right">
                <label for="name">نام و نام خانوادگی</label>
                <input type="text" class="form-control text-right" name="name" id="name" placeholder="نام و نام خانوادگی" required autocomplete="off" value="{{$user->name}}">
              </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6 text-right">
                    <label for="role">نقش</label>
                    <select id="role" class="form-control text-right" name="role">
                      <option value="0" {{($user->is_admin) ? "" : "selected"}}>کاربر عادی</option>
                      <option value="1" {{($user->is_admin) ? "selected" : ""}}>مدیر</option>
                    </select>
                </div>
                <div class="form-group col-md-6 text-right">
                  <label for="email">ایمیل</label>
                  <input type="email" class="form-control text-right" name="email" id="email" placeholder="ایمیل" required autocomplete="off" value="{{$user->email}}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6 text-right">
                    <label for="password_confirmation">تکرار رمز عبور</label>
                    <input type="password" class="form-control text-right" name="password_confirmation" id="password_confirmation" placeholder="تکرار رمز عبور" autocomplete="off">
                </div>
                <div class="form-group col-md-6 text-right">
                  <label for="password">رمز عبور</label>
                  <input type="password" class="form-control text-right" name="password" id="password" placeholder="رمز عبور" autocomplete="off">
                </div>
              </div>
            <button type="submit" class="btn btn-success">ویرایش</button>
        </form>
    </div>
</div>
@endsection