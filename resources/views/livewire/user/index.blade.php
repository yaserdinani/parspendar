@section('title', 'کاربران')
<div class="card">
    <div class="card-header">
        <h3>کاربران</h3>
        <div class="d-flex flex-row-reverse">
            <div>
                <a data-toggle="modal" data-target="#createModal" class="btn btn-success">افزودن</a>
            </div>
            <input autocomplete="off" type="text" class="col-md-2 form-control text-right mx-1"
                wire:model.lazy='filter_text' placeholder="جستجو" id="filter_text" name="filter_text">
            <select class="col-md-2 mx-1 form-control" wire:model.lazy='filter_type'>
                <option value="2">همه</option>
                <option value="1">فعال</option>
                <option value="0">غیرفعال</option>
            </select>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered text-center" dir="rtl">
            <thead>
                <tr>
                    <th scope="col">شناسه</th>
                    <th scope="col">نام و نام خانوادگی</th>
                    <th scope="col">شماره تماس</th>
                    <th scope="col">ایمیل</th>
                    @can('change-user-status')
                        <th scope="col">وضعیت</th>
                    @endcan
                    @can('user-edit')
                        <th scope="col">ویرایش</th>
                    @endcan
                    @can('user-delete')
                        <th scope="col">حذف</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td class="text-right">{{ $user->name }}</td>
                        <td class="text-right">{{ $user->phone }}</td>
                        <td class="text-right">{{ $user->email }}</td>
                        @can('change-user-status')
                            <td>
                                <select class="form-control"
                                    wire:change="$emit('updateUserStatus',{{ $user->id }},$event.target.value)">
                                    <option value="1" {{ $user->is_active == true ? ' selected' : '' }}>فعال</option>
                                    <option value="0" {{ $user->is_active == false ? ' selected' : '' }}>غیرفعال
                                    </option>
                                </select>
                            </td>
                        @endcan
                        @can('user-edit')
                            <td>
                                <a data-toggle="modal" data-target="#updateModal" class="btn btn-sm btn-outline-warning"
                                    wire:click='setCurrentUser({{ $user }})'>ویرایش</a>
                            </td>
                        @endcan
                        @can('user-delete')
                            <td>
                                <a data-toggle="modal" data-target="#deleteModal" class="btn btn-sm btn-outline-danger"
                                    wire:click='setCurrentUser({{ $user }})'>حذف</button>
                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
    {{-- create modal --}}
    <div wire:ignore.self class="modal fade" id="createModal" tabindex="-1" role="dialog"
        aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">افزودن کاربر</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <form wire:submit.prevent='store'>
                                <div class="form-row">
                                    <div class="form-group col-md-6 text-right">
                                        <label for="phone">موبایل</label>
                                        <input type="tel" class="form-control text-right" wire:model.lazy='phone'
                                            id="phone" placeholder="موبایل" required autocomplete="off"
                                            pattern="^(\+98|0)?9\d{9}$">
                                        @error('phone')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6 text-right">
                                        <label for="name">نام و نام خانوادگی</label>
                                        <input type="text" class="form-control text-right" wire:model.lazy='name'
                                            id="name" placeholder="نام و نام خانوادگی" required autocomplete="off">
                                        @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6 text-right">
                                        <label for="role">نقش</label>
                                        <select id="role" class="form-control text-right" wire:model.lazy='roles'
                                            multiple required>
                                            @foreach ($all_roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('roles')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6 text-right">
                                        <label for="email">ایمیل</label>
                                        <input type="email" class="form-control text-right" wire:model.lazy='email'
                                            id="email" placeholder="ایمیل" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,}"
                                            required autocomplete="off">
                                        @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6 text-right">
                                        <label for="password_confirmation">تکرار رمز عبور</label>
                                        <input type="password" class="form-control text-right"
                                            wire:model.lazy='password_confirmation' id="password_confirmation"
                                            placeholder="تکرار رمز عبور" required autocomplete="off">
                                        @error('password_confirmation')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6 text-right">
                                        <label for="password">رمز عبور</label>
                                        <input type="password" class="form-control text-right"
                                            wire:model.lazy='password' id="password" placeholder="رمز عبور" required
                                            autocomplete="off">
                                        @error('password')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"
                                    wire:click="resetInputs">لغو</button>
                                <button type="submit" class="btn btn-outline-primary">ثبت</button>
                            </form>
                        </div>
                    </div>
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
                    <h5 class="modal-title" id="updateModalLabel">ویرایش کاربر</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <form wire:submit.prevent='update'>
                                <div class="form-row">
                                    <div class="form-group col-md-6 text-right">
                                        <label for="phone">موبایل</label>
                                        <input type="tel" class="form-control text-right"
                                            wire:model.lazy='phone' id="phone" placeholder="موبایل" required
                                            autocomplete="off" pattern="^(\+98|0)?9\d{9}$">
                                        @error('phone')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6 text-right">
                                        <label for="name">نام و نام خانوادگی</label>
                                        <input type="text" class="form-control text-right"
                                            wire:model.lazy='name' id="name" placeholder="نام و نام خانوادگی"
                                            required autocomplete="off">
                                        @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6 text-right">
                                        <label for="role">نقش</label>
                                        <select id="role" class="form-control text-right"
                                            wire:model.lazy='roles' multiple required>
                                            @foreach ($all_roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('roles')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6 text-right">
                                        <label for="email">ایمیل</label>
                                        <input type="email" class="form-control text-right"
                                            wire:model.lazy='email' id="email" placeholder="ایمیل" required
                                            autocomplete="off" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,}">
                                        @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6 text-right">
                                        <label for="password_confirmation">تکرار رمز عبور</label>
                                        <input type="password" class="form-control text-right"
                                            wire:model.lazy='password_confirmation' id="password_confirmation"
                                            placeholder="تکرار رمز عبور" autocomplete="off">
                                        @error('password_confirmation')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6 text-right">
                                        <label for="password">رمز عبور</label>
                                        <input type="password" class="form-control text-right"
                                            wire:model.lazy='password' id="password" placeholder="رمز عبور"
                                            autocomplete="off">
                                        @error('password')
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
        </div>
    </div>
    {{-- delete modal --}}
    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
        aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">حذف کاربر</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    آیا از حذف این کاربر اطمینان دارید؟
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
