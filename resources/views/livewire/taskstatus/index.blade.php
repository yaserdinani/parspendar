@section('title', 'همه‌ی وضعیت‌ها')
<div class="card">
    <div class="card-header">
        <h3>همه‌ی وضعیت‌ها</h3>
        <div class="d-flex flex-row-reverse">
            <div>
                <a data-toggle="modal" data-target="#createModal" class="btn btn-success">افزودن</a>
            </div>
            <input autocomplete="off" type="text" class="col-md-2 form-control text-right mx-1" wire:model.lazy='filter_text'
                    placeholder="جستجو" id="filter_text" name="filter_text">
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered" dir="rtl">
            <thead>
                <tr>
                    <th scope="col">شناسه</th>
                    <th scope="col">عنوان</th>
                    @can('status-edit')
                    <th scope="col">ویرایش</th>
                    @endcan
                    @can('status-delete')
                    <th scope="col">حذف</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($statuses as $status)
                    <tr>
                        <th scope="row">{{ $status->id }}</th>
                        <td>{{ $status->name }}</td>
                        @can('status-edit')
                        <td>
                            <a data-toggle="modal" data-target="#updateModal" class="btn btn-sm btn-outline-warning"
                                wire:click="edit({{ $status }})">ویرایش</a>
                        </td>
                        @endcan
                        @can('status-delete')
                        <td>
                            <a data-toggle="modal" data-target="#deleteModal" class="btn btn-sm btn-outline-danger"
                                wire:click="setStatus({{ $status }})">حذف</a>
                        </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $statuses->links() }}
    </div>
    {{-- create modal --}}
    <div wire:ignore.self class="modal fade" id="createModal" tabindex="-1" role="dialog"
        aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">افزودن وضعیت</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control" placeholder="عنوان" wire:model.lazy='name' required>
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">لغو</button>
                    <button type="button" class="btn btn-outline-primary" wire:click='store' data-dismiss="modal">ثبت</button>
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
                    <h5 class="modal-title" id="updateModalLabel">افزودن وضعیت</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control" placeholder="عنوان" wire:model.lazy='name' required>
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">لغو</button>
                    <button type="button" class="btn btn-outline-primary" wire:click='update' data-dismiss="modal">ثبت</button>
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
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">لغو</button>
                    <button type="button" class="btn btn-outline-primary" wire:click='delete'
                        data-dismiss="modal">حذف</button>
                </div>
            </div>
        </div>
    </div>
</div>
