@extends('layouts.app')
@section('title', 'کاربران')
@section('content')
<div class="card">
    <div class="card-header">
      <h3>کاربران</h3>
      <div class="d-flex flex-row justify-content-between">
          <div>
            <a href="" class="btn btn-success">افزودن</a>
          </div>
          <div>
            <input type="text" class="form-control text-right" placeholder="جستجو">
          </div>
      </div>
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
                <th scope="col">حذف</th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $user)
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
                        <a href="" class="btn btn-sm btn-outline-warning">ویرایش</a>
                    </td>
                    <td>
                        <a href="" class="btn btn-sm btn-outline-danger">حذف</a>
                    </td>
                </tr>
              @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
</div>
@endsection