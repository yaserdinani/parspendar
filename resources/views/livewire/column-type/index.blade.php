@section('title', 'همه‌ی نوع ستون‌ها')
<div class="card">
    <div wire:loading.delay>
        <div style="background-color:#000;display:flex;justify-content:center;align-items:center;position:fixed;top:0px;left:0px;width:100%;height:100%;opacity:0.4;z-index:9999;">
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
    <div class="card-header">
        <h3>همه‌ی نوع ستون‌ها</h3>
        <div class="d-flex flex-row-reverse">
            <div>
                <a data-toggle="modal" data-target="#createModal" class="btn btn-success">افزودن</a>
            </div>
            <input autocomplete="off" type="text" class="col-md-2 form-control text-right mx-1"
                wire:model.lazy='filter_text' placeholder="جستجو" id="filter_text" name="filter_text">
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered text-center" dir="rtl">
            <thead>
                <tr>
                    <th scope="col">شناسه</th>
                    <th scope="col">عنوان</th>
                    @can('column-type-update')
                        <th scope="col">ویرایش</th>
                    @endcan
                    @can('column-type-delete')
                        <th scope="col">حذف</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($columnTypes as $columnType)
                    <tr>
                        <th scope="row">{{ $columnType->id }}</th>
                        <td class="text-right">{{ $columnType->name }}</td>
                        @can('column-type-update')
                            <td>
                                <a data-toggle="modal" data-target="#updateModal" class="btn btn-sm btn-outline-warning"
                                    wire:click="setCurrentTable({{ $columnType }})">ویرایش</a>
                            </td>
                        @endcan
                        @can('column-type-delete')
                            <td>
                                <a data-toggle="modal" data-target="#deleteModal" class="btn btn-sm btn-outline-danger"
                                    wire:click="setCurrentTable({{ $columnType }})">حذف</a>
                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $columnTypes->links() }}
    </div>
    {{-- create modal --}}
    <div wire:ignore.self class="modal fade" id="createModal" tabindex="-1" role="dialog"
        aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">افزودن نوع ستون</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent='store'>
                        <input type="text" class="form-control mb-2" placeholder="عنوان" wire:model.defer='name'
                            required>
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal" wire:click='resetInputs'>لغو</button>
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
                    <h5 class="modal-title" id="updateModalLabel">ویرایش نوع ستون</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent='update'>
                        <input type="text" class="form-control mb-2" placeholder="عنوان" wire:model.defer='name'
                            required>
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal" wire:click='resetInputs'>لغو</button>
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
                    <h5 class="modal-title" id="deleteModalLabel">حذف نوع ستون</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    آیا از حذف این نوع ستون اطمینان دارید؟
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
