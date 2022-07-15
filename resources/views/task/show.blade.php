@extends('layouts.app')
@section('title', 'نمایش وظیفه')
@section('content')
<div class="card">
    <div class="card-header text-center">
      <h3>{{$task->name}} نمایش</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered" dir="rtl">
            <thead>
              <tr>
                <th scope="col">شناسه</th>
                <th scope="col">نام</th>
                <th scope="col">توضیحات</th>
                <th scope="col">وضعیت</th>
                <th scope="col">تاریخ شروع</th>
                <th scope="col">تاریخ پایان</th>
                <th scope="col">ویرایش</th>
                <th scope="col">نمایش</th>
                <th scope="col">حذف</th>
              </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">{{$task->id}}</th>
                    <td>{{$task->name}}</td>
                    <td>{{$task->description}}</td>
                    <td>
                        @switch($task->status)
                            @case(0)
                                <span class="text-danger">انجام نشده</span>
                                @break
                            @case(1)
                                <span class="text-primary">در حال انجام</span>
                                @break
                            @case(2)
                                <span class="text-success">انجام شده</span>
                                @break
                            @default
                                <span class="text-danger">انجام نشده</span>
                        @endswitch
                    </td>
                    <td>
                        {{\Morilog\Jalali\Jalalian::forge($task->started_at)->format('%A %d %B %Y')}}
                    </td>
                    <td>
                        {{\Morilog\Jalali\Jalalian::forge($task->finished_at)->format('%A %d %B %Y')}}
                    </td>
                    <td>
                        <a href="{{route('tasks.edit',$task)}}" class="btn btn-sm btn-outline-warning">ویرایش</a>
                    </td>
                    <td>
                        <a href="{{route('tasks.show',$task)}}" class="btn btn-sm btn-outline-info">نمایش</a>
                    </td>
                    <td>
                        <form action="{{route('tasks.destroy',$task)}}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-outline-danger">حذف</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
        <hr>
        <div class="text-center">
            افراد مشارکت کننده
        </div>
        <hr>
        <table class="table table-bordered" dir="rtl">
            <thead>
              <tr>
                <th scope="col">شناسه</th>
                <th scope="col">نام و نام خانوادگی</th>
                <th scope="col">شماره تماس</th>
                <th scope="col">ایمیل</th>
                <th scope="col">نقش</th>
                <th scope="col">وضعیت</th>
                @if(auth()->user()->is_admin)
                    <th scope="col">ویرایش</th>
                    <th scope="col">نمایش</th>
                    <th scope="col">حذف</th>
                @endif
              </tr>
            </thead>
            <tbody>
              @foreach($task->users()->get() as $user)
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
                    @if(auth()->user()->is_admin)
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
                    @endif
                </tr>
              @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection