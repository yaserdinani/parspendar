@extends('layouts.app')
@section('title', 'همه‌ی وظایف')
@section('content')
<div class="card">
    <div class="card-header">
      <h3>همه‌ی وظایف</h3>
      <div class="d-flex flex-row justify-content-between">
          <div>
            <a href="{{route('tasks.create')}}" class="btn btn-success">افزودن</a>
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
              @foreach($tasks as $task)
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
              @endforeach
            </tbody>
        </table>
        {{ $tasks->links() }}
    </div>
</div>
@endsection