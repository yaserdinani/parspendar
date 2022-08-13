@section('title', 'همه‌ی وظایف')
<div class="card">
    <div class="card-header">
      <h3>همه‌ی وظایف</h3>
      <div class="d-flex flex-row justify-content-between">
          <div>
            <a href="{{route('livewire.tasks.create')}}" class="btn btn-success">افزودن</a>
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
                @if(auth()->user()->is_admin)
                <th scope="col">حذف</th>
                @endif
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
                        <a href="{{route('livewire.tasks.edit',$task)}}" class="btn btn-sm btn-outline-warning">ویرایش</a>
                    </td>
                    @if(auth()->user()->is_admin)
                        <td>
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('آیا از حذف این وظیفه اطمینان دارید؟')" wire:click="delete({{$task}})">حذف</button>
                        </td>
                    @endif
                </tr>
              @endforeach
            </tbody>
        </table>
    </div>
</div>