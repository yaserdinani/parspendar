@section('title', 'همه‌ی وظایف')
<div class="card">
    <div class="card-header">
        <h3>همه‌ی وظایف</h3>
        <div class="d-flex flex-row justify-content-between">
            <div>
                <a data-toggle="modal" data-target="#createModal" class="btn btn-success">افزودن</a>
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
                        <td>{{ $task->name }}</td>
                        <td>{{ $task->description }}</td>
                        <td>
                            <span>{{ $task->taskStatus->name }}</span>
                        </td>
                        <td>
                            {{ \Morilog\Jalali\Jalalian::forge($task->started_at)->format('%A %d %B %Y') }}
                        </td>
                        <td>
                            {{ \Morilog\Jalali\Jalalian::forge($task->finished_at)->format('%A %d %B %Y') }}
                        </td>
                        @can('task-edit')
                            <td>
                                <a data-toggle="modal" data-target="#updateModal" class="btn btn-sm btn-outline-warning"
                                    wire:click="setCurrentTask({{ $task }})">ویرایش</a>
                            </td>
                        @endcan
                        @can('task-delete')
                            <td>
                                <a data-toggle="modal" data-target="#deleteModal" class="btn btn-sm btn-outline-danger"
                                    wire:click="setCurrentTask({{ $task }})">حذف</a>
                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $tasks->links() }}
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
                    <div class="form-row">
                        <div class="form-group col-md-6 text-right">
                            <label for="description">توضیحات</label>
                            <textarea class="form-control text-right" id="description" wire:model.defer="description" rows="3" required>
                                {{ old('description') }}    
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"
                        wire:click='resetInputs'>لغو</button>
                    <button type="button" class="btn btn-outline-primary" wire:click='store'
                        data-dismiss="modal">ثبت</button>
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
                    <div class="form-row">
                        <div class="form-group col-md-6 text-right">
                            <label for="description">توضیحات</label>
                            <textarea class="form-control text-right" id="description" wire:model.lazy="description" rows="3" required>   
                                </textarea>
                            @error('description')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 text-right">
                            <label for="name">نام</label>
                            <input type="text" class="form-control text-right" wire:model.lazy="name"
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
                                <select multiple class="form-control" id="users" wire:model.lazy="users">
                                    @foreach ($all_users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            @endcan
                        </div>
                        <div class="form-group col-md-6 text-right">
                            <label for="role">وضعیت</label>
                            <select id="role" class="form-control text-right" wire:model.lazy="status">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"
                        wire:click='resetInputs'>لغو</button>
                    <button type="button" class="btn btn-outline-primary" wire:click='update'
                        data-dismiss="modal">ثبت</button>
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
            })
            $(".finished_at").persianDatepicker({
                initialValue: false,
                autoClose: true,
                onSelect: function(unix) {
                    Livewire.emit('setFinishedAt', new persianDate(unix).unix())
                },
            });
        });
    </script>
@endpush
