@section('title', 'همه‌ی ستون‌ها')
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
    <div class="card-header">
        <h3>همه‌ی ستون‌ها</h3>
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
                    <th scope="col">جدول</th>
                    <th scope="col">نوع ستون</th>
                    <th scope="col">جدول وابسته</th>
                    @can('column-update')
                        <th scope="col">ویرایش</th>
                    @endcan
                    @can('column-delete')
                        <th scope="col">حذف</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($columns as $column)
                    <tr>
                        <th scope="row">{{ $column->id }}</th>
                        <td class="text-right">{{ $column->name }}</td>
                        <td class="text-right">{{ $column->table->name }}</td>
                        <td class="text-right">{{ $column->columnType->name }}</td>
                        @if ($column->selectTable != null)
                            <td class="text-right">{{ $column->selectTable->name }}</td>
                        @else
                            <td class="text-right text-danger">ندارد</td>
                        @endif
                        @can('column-update')
                            <td>
                                <a data-toggle="modal" data-target="#updateModal" class="btn btn-sm btn-outline-warning"
                                    wire:click="setCurrentColumn({{ $column }})">ویرایش</a>
                            </td>
                        @endcan
                        @can('column-delete')
                            <td>
                                <a data-toggle="modal" data-target="#deleteModal" class="btn btn-sm btn-outline-danger"
                                    wire:click="setCurrentColumn({{ $column }})">حذف</a>
                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $columns->links() }}
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
                        <div class="form-row my-2">
                            <div class="form-group col-md-6 text-right">
                                <label for="table_id">جدول</label>
                                <select id="table_id" class="form-control text-right" wire:model.defer="table_id">
                                    <option value="0">ندارد</option>
                                    @foreach ($tables as $table)
                                        <option value="{{ $table->id }}">{{ $table->name }}</option>
                                    @endforeach
                                </select>
                                @error('table_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 text-right">
                                <label for="name">عنوان</label>
                                <input type="text" class="form-control text-right" placeholder="عنوان"
                                    wire:model.defer='name' required id="name" autocomplete="off">
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row my-2">
                            <div class="form-group col-md-6 text-right">
                                <label for="select_table_id">جدول وابسته</label>
                                <select id="select_table_id" class="form-control text-right"
                                    wire:model.defer="select_table_id">
                                    <option value="0">ندارد</option>
                                    @foreach ($tables as $table)
                                        <option value="{{ $table->id }}">{{ $table->name }}</option>
                                    @endforeach
                                </select>
                                @error('select_table_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 text-right">
                                <label for="column_type_id">نوع ستون</label>
                                <select id="column_type_id" class="form-control text-right"
                                    wire:model.defer="column_type_id">
                                    <option value="0">ندارد</option>
                                    @foreach ($column_types as $column_type)
                                        <option value="{{ $column_type->id }}">{{ $column_type->name }}</option>
                                    @endforeach
                                </select>
                                @error('column_type_id')
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
                    <h5 class="modal-title" id="updateModalLabel">ویرایش نوع ستون</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent='update'>
                        <div class="form-row my-2">
                            <div class="form-group col-md-6 text-right">
                                <label for="table_id">جدول</label>
                                <select id="table_id" class="form-control text-right" wire:model.defer="table_id">
                                    <option value="0">ندارد</option>
                                    @foreach ($tables as $table)
                                        <option value="{{ $table->id }}">{{ $table->name }}</option>
                                    @endforeach
                                </select>
                                @error('table_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 text-right">
                                <label for="name">عنوان</label>
                                <input type="text" class="form-control text-right" placeholder="عنوان"
                                    wire:model.defer='name' required id="name">
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row my-2">
                            <div class="form-group col-md-6 text-right">
                                <label for="select_table_id">جدول وابسته</label>
                                <select id="select_table_id" class="form-control text-right"
                                    wire:model.defer="select_table_id">
                                    <option value="0">ندارد</option>
                                    @foreach ($tables as $table)
                                        <option value="{{ $table->id }}">{{ $table->name }}</option>
                                    @endforeach
                                </select>
                                @error('select_table_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 text-right">
                                <label for="column_type_id">نوع ستون</label>
                                <select id="column_type_id" class="form-control text-right"
                                    wire:model.defer="column_type_id">
                                    <option value="0">ندارد</option>
                                    @foreach ($column_types as $column_type)
                                        <option value="{{ $column_type->id }}">{{ $column_type->name }}</option>
                                    @endforeach
                                </select>
                                @error('column_type_id')
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
