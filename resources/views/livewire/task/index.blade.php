@section('title', 'همه‌ی وظایف')
<div class="card">
    <div wire:loading.delay>
        <div
            style="background-color:#000;display:flex;justify-content:center;align-items:center;position:fixed;top:0px;left:0px;width:100%;height:100%;opacity:0.4;z-index:9999;">
            <div class="la-ball-spin-clockwise">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
    <livewire:task-status-boarder :sortable="true" :sortable-between-statuses="true" />
    {{-- dynamic table --}}
    <div class="card-header mt-2">
        <h3>همه‌ی وظایف</h3>
        <div class="d-flex flex-row-reverse">
            <div>
                <a data-toggle="modal" data-target="#createModal" class="btn btn-success mx-1">افزودن</a>
            </div>
            <div>
                <a data-toggle="modal" data-target="#tableModal" class="btn btn-secondary mx-1"
                    wire:click="getTableInfo">شخصی سازی جدول</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered text-center" dir="rtl">
            <thead>
                <tr>
                    @foreach (auth()->user()->columns as $key => $value)
                        <th scope="col">{{ $value->name }}</th>
                    @endforeach
                    <th scope="col">زمان صرف شده</th>
                    <th scope="col">تایمر</th>
                    <th scope="col">نظرات</th>
                    @can('task-edit')
                        <th scope="col">ویرایش</th>
                    @endcan
                    @can('task-delete')
                        <th scope="col">حذف</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        @foreach (auth()->user()->columns as $key => $value)
                            <td scope="col">
                                @switch ($value->columnType->name)
                                    @case('string')
                                        {{ $task[$value->name] }}
                                    @break

                                    @case('datetime')
                                        {{ \Morilog\Jalali\Jalalian::forge($task[$value->name])->format('%A %d %B %Y') }}
                                    @break

                                    @case('integer')
                                        @if ($value->select_table_id !== null)
                                            <select class="form-control"
                                                wire:change="$emit('updateTaskStatus',{{ $task->id }},$event.target.value)">
                                                @foreach (\Illuminate\Support\Facades\DB::table($value->selectTable->name)->get() as $status)
                                                    <option value="{{ $status->id }}"
                                                        {{ $status->id == \Illuminate\Support\Facades\DB::table($value->selectTable->name)->where('id', $task->task_status_id)->first()->id ? 'selected="selected"' : '' }}>
                                                        {{ $status->name }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            {{ $task[$value->name] }}
                                        @endif
                                    @break
                                @endswitch
                            </td>
                        @endforeach
                        <td>
                            {{ Illuminate\Support\Facades\DB::table('task_user')->where([['user_id', auth()->user()->id], ['task_id', $task->id]])->first()->time_spent ?? 0 }}
                            ثانیه
                        </td>
                        <td>
                            @if (Illuminate\Support\Facades\DB::table('task_user')->where([['user_id', auth()->user()->id], ['task_id', $task->id]])->first())
                                <i class="fa fa-pause-circle" style="cursor: pointer;"
                                    onclick="pause({{ $task->id }})"></i>
                                <span id="time.task.{{ $task->id }}">
                                    0
                                </span>
                                <i class="fa fa-play-circle" style="cursor: pointer;"
                                    onclick="play({{ $task->id }})"></i>
                            @else
                                <span>مجری نیستید</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('livewire.comments.index', $task) }}"
                                class="btn btn-sm btn-info">مشاهده</a>
                        </td>
                        @can('task-edit')
                            <td>
                                <a data-toggle="modal" data-target="#updateModal" class="btn btn-sm btn-warning"
                                    wire:click="setCurrentTask({{ $task }})">ویرایش</a>
                            </td>
                        @endcan
                        @can('task-delete')
                            <td>
                                <a data-toggle="modal" data-target="#deleteModal" class="btn btn-sm btn-danger"
                                    wire:click="setCurrentTask({{ $task }})">حذف</a>
                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $tasks->links() }}
    </div>
    {{-- end dynamic table --}}
    <div class="card-header">
        <h3>همه‌ی وظایف</h3>
        <div class="d-flex flex-row-reverse">
            <div>
                <a data-toggle="modal" data-target="#createModal" class="btn btn-success">افزودن</a>
            </div>
            <input autocomplete="off" type="text" class="col-md-2 form-control text-right mx-1"
                wire:model.lazy='filter_text' placeholder="جستجو بر اساس نام و توضیحات" id="filter_text"
                name="filter_text">
            <input autocomplete="off" type="text" class="filter_started_at col-md-2 form-control text-right mx-1"
                value="{{ $filter_started_time }}" placeholder="تاریخ شروع">
            <input type="hidden" wire:model.lazy='filter_started_at' class="observer-example-alt">
            <input autocomplete="off" type="text" class="filter_finished_at col-md-2 form-control text-right mx-1"
                value="{{ $filter_finished_time }}" placeholder="تاریخ پایان">
            <input type="hidden" wire:model.lazy='filter_finished_at' class="observer-example-alt">
            <select class="col-md-2 mx-1 form-control" wire:model.lazy='filter_type'>
                <option value="0">همه</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered text-center" dir="rtl">
            <thead>
                <tr>
                    <th scope="col">شناسه</th>
                    <th scope="col">نام</th>
                    <th scope="col">توضیحات</th>
                    <th scope="col">وضعیت</th>
                    <th scope="col">تاریخ شروع</th>
                    <th scope="col">تاریخ پایان</th>
                    <th scope="col">زمان صرف شده</th>
                    <th scope="col">تایمر</th>
                    <th scope="col">نظرات</th>
                    @can('task-edit')
                        <th scope="col">ویرایش</th>
                    @endcan
                    @can('task-delete')
                        <th scope="col">حذف</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <th scope="row">{{ $task->id }}</th>
                        <td class="text-right">{{ $task->name }}</td>
                        <td class="text-right">{{ $task->description }}</td>
                        <td>
                            <select class="form-control"
                                wire:change="$emit('updateTaskStatus',{{ $task->id }},$event.target.value)">
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}"
                                        {{ $status->id == $task->task_status_id ? 'selected="selected"' : '' }}>
                                        {{ $status->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="text-right">
                            {{ \Morilog\Jalali\Jalalian::forge($task->started_at)->format('%A %d %B %Y') }}
                        </td>
                        <td class="text-right">
                            {{ \Morilog\Jalali\Jalalian::forge($task->finished_at)->format('%A %d %B %Y') }}
                        </td>
                        <td>
                            {{ Illuminate\Support\Facades\DB::table('task_user')->where([['user_id', auth()->user()->id], ['task_id', $task->id]])->first()->time_spent ?? 0 }}
                            {{-- {{ Carbon\CarbonInterval::seconds(Illuminate\Support\Facades\DB::table('task_user')->where([['user_id', auth()->user()->id], ['task_id', $task->id]])->first()->time_spent)->cascade()->forHumans()}} --}}
                            ثانیه
                        </td>
                        <td>
                            @if (Illuminate\Support\Facades\DB::table('task_user')->where([['user_id', auth()->user()->id], ['task_id', $task->id]])->first())
                                <i class="fa fa-pause-circle" style="cursor: pointer;"
                                    onclick="pause({{ $task->id }})"></i>
                                <span id="time.task.{{ $task->id }}">
                                    0
                                </span>
                                <i class="fa fa-play-circle" style="cursor: pointer;"
                                    onclick="play({{ $task->id }})"></i>
                            @else
                                <span>مجری نیستید</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('livewire.comments.index', $task) }}"
                                class="btn btn-sm btn-info">مشاهده</a>
                        </td>
                        @can('task-edit')
                            <td>
                                <a data-toggle="modal" data-target="#updateModal" class="btn btn-sm btn-warning"
                                    wire:click="setCurrentTask({{ $task }})">ویرایش</a>
                            </td>
                        @endcan
                        @can('task-delete')
                            <td>
                                <a data-toggle="modal" data-target="#deleteModal" class="btn btn-sm btn-danger"
                                    wire:click="setCurrentTask({{ $task }})">حذف</a>
                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $tasks->links() }}
    </div>
    {{-- change table modal --}}
    <div wire:ignore.self class="modal fade" id="tableModal" tabindex="-1" role="dialog"
        aria-labelledby="tableModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tableModalLabel">شخصی سازی جدول</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent='changeTable'>
                        <select id="columns" rows="5" class="form-control text-right my-2"
                            wire:model.defer='my_columns' multiple required>
                            @foreach ($columns as $column)
                                <option value="{{ $column->id }}">{{ $column->name }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">لغو</button>
                        <button type="submit" class="btn btn-outline-primary">ثبت</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- create modal --}}
    <div wire:ignore.self class="modal fade" id="createModal" tabindex="-1" role="dialog"
        aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">افزودن وظیفه</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent='store'>
                        <div class="form-row">
                            <div class="form-group col-md-6 text-right">
                                <label for="description">توضیحات</label>
                                <textarea class="form-control text-right" id="description" wire:model.defer="description" rows="3" required>
                                   
                            </textarea>
                                @error('description')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 text-right">
                                <label for="name">نام</label>
                                <input type="text" class="form-control text-right" wire:model.defer="name"
                                    id="name" placeholder="نام" required autocomplete="off">
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 text-right">
                                @can('add-task-for-users')
                                    <label for="users">کاربران</label>
                                    <select multiple class="form-control" id="users" wire:model.defer="users">
                                        @foreach ($all_users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                @endcan
                            </div>
                            <div class="form-group col-md-6 text-right">
                                <label for="role">وضعیت</label>
                                <select id="role" class="form-control text-right" wire:model.defer="status">
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 text-right">
                                <label for="finished_at">پایان</label>
                                <input type="text" class="form-control text-right finished_at"
                                    value="{{ $finish_time }}" id="finished_at" required autocomplete="off">
                                <input type="hidden" wire:model.defer='finished_at' class="observer-example-alt">
                                @error('finished_at')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 text-right">
                                <label for="started_at">شروع</label>
                                <input type="text" class="form-control text-right started_at"
                                    value="{{ $start_time }}" id="started_at" required autocomplete="off">
                                <input type="hidden" wire:model.defer='started_at' class="observer-example-alt">
                                @error('started_at')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"
                            wire:click='resetInputs'>لغو</button>
                        <button type="submit" class="btn btn-outline-primary">ثبت</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- update modal --}}
    <div wire:ignore.self class="modal fade" id="updateModal" tabindex="-1" role="dialog"
        aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">ویرایش وظیفه</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent='update'>
                        <div class="form-row">
                            <div class="form-group col-md-6 text-right">
                                <label for="description">توضیحات</label>
                                <textarea class="form-control text-right" id="description" wire:model.defer="description" rows="3" required>   
                                </textarea>
                                @error('description')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 text-right">
                                <label for="name">نام</label>
                                <input type="text" class="form-control text-right" wire:model.defer="name"
                                    id="name" placeholder="نام" required autocomplete="off">
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 text-right">
                                @can('add-task-for-users')
                                    <label for="users">کاربران</label>
                                    <select multiple class="form-control" id="users" wire:model.defer="users">
                                        @foreach ($all_users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                @endcan
                            </div>
                            <div class="form-group col-md-6 text-right">
                                <label for="role">وضعیت</label>
                                <select id="role" class="form-control text-right" wire:model.defer="status">
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 text-right">
                                <label for="finished_at">پایان</label>
                                <input type="text" class="form-control text-right finished_at"
                                    value="{{ $finish_time }}" id="finished_at" required autocomplete="off">
                                <input type="hidden" wire:model.defer='finished_at' class="observer-example-alt">
                                @error('finished_at')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 text-right">
                                <label for="started_at">شروع</label>
                                <input type="text" class="form-control text-right started_at"
                                    value="{{ $start_time }}" id="started_at" required autocomplete="off">
                                <input type="hidden" wire:model.defer='started_at' class="observer-example-alt">
                                @error('started_at')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"
                            wire:click='resetInputs'>لغو</button>
                        <button type="submit" class="btn btn-outline-primary">ثبت</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- delete modal --}}
    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
        aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">افزودن وضعیت</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    آیا از حذف این وضعیت اطمینان دارید؟
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"
                        wire:click='resetInputs'>لغو</button>
                    <button type="button" class="btn btn-outline-primary" wire:click='delete'
                        data-dismiss="modal">حذف</button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script type="text/javascript" defer>
        var intervals = []
        const beforeUnloadListener = (event) => {
            event.preventDefault();
            return event.returnValue = "Are you sure you want to exit?";
        };

        function play(id) {
            addEventListener("beforeunload", beforeUnloadListener, {
                capture: true
            });
            var span = document.getElementById("time.task." + id);
            var counter = 1;
            intervals[id] = setInterval(function() {
                span.innerHTML = counter
                counter++
            }, 1000)
        }

        function pause(id) {
            var span = document.getElementById("time.task." + id);
            Livewire.emit('setSpentTime', id, span.innerHTML)
            clearInterval(intervals[id])
            span.innerHTML = 0
        }
        $(document).ready(function() {
            $(".started_at").click(function() {
                    $(".started_at").persianDatepicker({
                        initialValue: false,
                        autoClose: true,
                        onSelect: function(unix) {
                            Livewire.emit('setStartedAt', new persianDate(unix).unix())
                        },
                    });
                }),
                $(".started_at").persianDatepicker({
                    initialValue: false,
                    autoClose: true,
                    onSelect: function(unix) {
                        Livewire.emit('setStartedAt', new persianDate(unix).unix())
                    },
                });
            $(".finished_at").click(function() {
                    $(".finished_at").persianDatepicker({
                        initialValue: false,
                        autoClose: true,
                        onSelect: function(unix) {
                            Livewire.emit('setFinishedAt', new persianDate(unix).unix())
                        },
                    });
                }),
                $(".finished_at").persianDatepicker({
                    initialValue: false,
                    autoClose: true,
                    onSelect: function(unix) {
                        Livewire.emit('setFinishedAt', new persianDate(unix).unix())
                    },
                });
            $(".filter_finished_at").click(function() {
                    $(".filter_finished_at").persianDatepicker({
                        initialValue: false,
                        autoClose: true,
                        onSelect: function(unix) {
                            Livewire.emit('setFilterFinishedAt', new persianDate(unix).unix())
                        },
                    });
                }),
                $(".filter_finished_at").persianDatepicker({
                    initialValue: false,
                    autoClose: true,
                    onSelect: function(unix) {
                        Livewire.emit('setFilterFinishedAt', new persianDate(unix).unix())
                    },
                });
            $(".filter_started_at").click(function() {
                    $(".filter_started_at").persianDatepicker({
                        initialValue: false,
                        autoClose: true,
                        onSelect: function(unix) {
                            Livewire.emit('setFilterStartedAt', new persianDate(unix).unix())
                        },
                    });
                }),
                $(".filter_started_at").persianDatepicker({
                    initialValue: false,
                    autoClose: true,
                    onSelect: function(unix) {
                        Livewire.emit('setFilterStartedAt', new persianDate(unix).unix())
                    },
                });
            $("")

        });
    </script>
@endpush
