@extends('layouts.app')
@section('title', 'پروفایل کاربر')
@section('content')
<div class="card">
    <div class="card-header text-center">
      <h3>{{$user->name}} پروفایل کاربری</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered" dir="rtl">
            <thead>
              <tr>
                <th scope="col">شناسه</th>
                <th scope="col">نام و نام خانوادگی</th>
                <th scope="col">شماره تماس</th>
                <th scope="col">ایمیل</th>
                <th scope="col">نقش</th>
                <th scope="col">وضعیت</th>
                <th scope="col">ویرایش</th>
                <th scope="col">نمایش</th>
                <th scope="col">حذف</th>
              </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">{{$user->id}}</th>
                    <td>{{$user->name}}</td>
                    <td>{{$user->phone}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                        @if($user->is_admin)
                            مدیر
                        @else
                            کاربر
                        @endif
                    </td>
                    <td>
                        @if($user->is_active)
                            <a href="" class="btn btn-sm btn-outline-success">فعال</a>
                        @else
                            <a href="" class="btn btn-sm btn-outline-danger">غیرفعال</a>
                        @endif
                    </td>
                    <td>
                        <a href="{{route('users.edit',$user)}}" class="btn btn-sm btn-outline-warning">ویرایش</a>
                    </td>
                    <td>
                        <a href="{{route('users.show',$user)}}" class="btn btn-sm btn-outline-info">نمایش</a>
                    </td>
                    <td>
                        <form action="{{route('users.destroy',$user)}}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-outline-danger">حذف</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection