<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
        <livewire:appointments-calendar 
        week-starts-at="6"
        />
    </div>
    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
        <div class="tasks-container">
            <div class="tasks-container-header px-2">
                <div class="tasks-header-left">
                    <select class="form-control" wire:model.lazy='filter_type'>
                        <option value="1">همه‌ی وظایف</option>
                        <option value="2">وظایف انجام شده</option>
                        <option value="3">وظایف در حال انجام</option>
                        <option value="4">وظایف انجام نشده</option>
                        <option value="5">وظایف لغو شده</option>
                    </select>
                </div>
                <div class="tasks-header-right">
                    {{-- <select class="form-control">
                        <option value="">Hugo</option>
                    </select>
                    <i class="fa fa-plus fa-1x" aria-hidden="true"></i> --}}
                    <i class="fa fa-bars fa-1x" aria-hidden="true"></i>
                </div>
            </div>
            <div class="tasks-items-container">
                @foreach ($all_tasks as $task)
                    <div class="tasks-items-content mx-2">
                        <div class="tasks-item-top p-2">
                            <div class="tasks-item-top-left">
                                <span class="square today-square"></span>
                                <span class="label-high px-1 rounded">{{$task->taskStatus->name}}</span>
                                <span>{{$task->name}}</span>
                            </div>
                            <div class="tasks-item-top-right">
                                <i class="fa fa-bars fa-2x" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="tasks-item-bottom p-2">
                            <div class="tasks-item-bottom-left">
                                <span>{{$task->description}}</span>
                            </div>
                            <div class="tasks-item-bottom-right">
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                <span>{{\Morilog\Jalali\Jalalian::forge($task->started_at)->format('%A %d %B %Y')}}</span>
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
                <div class="events-items-contents sell-team rounded p-2">
                    <div class="event-item-left">
                        <span>9:00 - 10:00</span>
                    </div>
                    <div class="event-item-right">
                        <span>Sales team</span>
                        <div class="event-title">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span>first item</span>
                        </div>
                    </div>
                </div>
                <div class="events-items-contents programmer-team rounded p-2">
                    <div class="event-item-left">
                        <span>11:00 - 13:00</span>
                    </div>
                    <div class="event-item-right">
                        <span>Sales team</span>
                        <div class="event-title">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span>first item</span>
                        </div>
                        <div class="event-title">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span>second item</span>
                        </div>
                        <div class="event-title">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span>third item</span>
                        </div>
                    </div>
                </div>
                <div class="events-items-contents rounded p-2">
                    <div class="event-item-left">
                        <span>9:00 - 10:00</span>
                    </div>
                    <div class="event-item-right">
                        <span>Training team</span>
                        <div class="event-title">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span>first item</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
