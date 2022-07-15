@extends('layouts.app')
@section('title', 'کاربران')
@section('content')
<div class="card">
    <div class="card-header">
      <h3>کاربران</h3>
      <div class="d-flex flex-row justify-content-between">
          <div>
            <a href="{{route('users.create')}}" class="btn btn-success">افزودن</a>
          </div>
          <div>
            <form action="{{route('users.filter')}}" method="post" class="d-flex">
                @csrf
                <button type="submit" class="btn btn-primary">جستجو</button>
                <input type="text" class="form-control text-right" name="filter" placeholder="جستجو">
            </form>
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
                <th scope="col">نمایش</th>
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
              @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
</div>
@endsection