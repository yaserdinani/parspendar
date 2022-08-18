@section('title','تقویم')
<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
        <livewire:appointments-calendar week-starts-at="6" />
    </div>
    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
        <div class="tasks-container">
            <div class="tasks-container-header px-2">
                <div class="tasks-header-left">
                    <select class="form-control" wire:model.lazy='filter_type' wire:change='filterTasks($event.target.value)'>
                        <option selected value="0">همه وظایف</option>
                        @foreach($statuses as $status)
                            <option value="{{$status->id}}">{{$status->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="tasks-header-right">
                    <i class="fa fa-bars fa-1x" aria-hidden="true"></i>
                </div>
            </div>
            <div class="tasks-items-container">
                @foreach ($all_tasks as $value)
                    <div class="tasks-items-content mx-2" style="cursor: pointer;" wire:click="$emit('setTask',{{$value}})">
                        <div class="tasks-item-top p-2">
                            <div class="tasks-item-top-left">
                                <span class="square today-square"></span>
                                <span class="label-high px-1 rounded">{{ $value->taskStatus->name }}</span>
                                <span>{{ $value->name }}</span>
                            </div>
                            <div class="tasks-item-top-right">
                                <i class="fa fa-bars fa-2x" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="tasks-item-bottom p-2">
                            <div class="tasks-item-bottom-left">
                                <span>{{ $value->description }}</span>
                            </div>
                            <div class="tasks-item-bottom-right">
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                <span>{{ \Morilog\Jalali\Jalalian::forge($value->started_at)->format('%A %d %B %Y') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="events-container mt-5">
            <div class="events-container-header px-3">
                <span>
                    <b>{{ $today }}</b>
                </span>
                <i class="fa fa-bars fa-1x" aria-hidden="true"></i>
            </div>
            <div class="events-items-container p-5">
                @if ($task_flag)
                    <dl class="text-right">
                        <dt class="text-success">
                            <b>:عنوان</b>
                        </dt>
                        <dd>{{$task->name}}</dd>
                        <dt class="text-success">
                            <b>:توضیحات</b>
                        </dt>
                        <dd>{{$task->description}}</dd>
                        <dt class="text-success">
                            <b>:وضعیت</b>
                        </dt>
                        <dd class="bg-secondary p-1 rounded d-inline text-white">{{$task->taskStatus->name}}</dd>
                        <dt class="text-success">
                            <b>:مجریان</b>
                        </dt>
                        @foreach($task->users as $user) 
                            <dd class="bg-danger p-1 rounded d-inline text-white">{{$user->name}}</dd>
                        @endforeach
                        <dt class="text-success">
                            <b>:تاریخ شروع</b>
                        </dt>
                        <dd>{{\Morilog\Jalali\Jalalian::forge($task->started_at)->format('%A %d %B %Y')}}</dd>
                        <dt class="text-danger">
                            <b>:تاریخ پایان</b>
                        </dt>
                        <dd>{{\Morilog\Jalali\Jalalian::forge($task->finished_at)->format('%A %d %B %Y')}}</dd>
                        <dt class="text-success">
                            <b>:روز باقیمانده</b>
                        </dt>
                        <dd class="text-white bg-warning p-1 rounded d-inline">{{$remaining_time}}</dd>
                    </dl>
                @else
                    <h2 class="text-center">برای نمایش جزییات هر وظیفه بر روی آن کلیک کنید</h2>
                @endif
            </div>
        </div>
    </div>
</div>
