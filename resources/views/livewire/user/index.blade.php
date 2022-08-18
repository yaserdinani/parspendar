@section('title', 'کاربران')
<div class="card">
    <div class="card-header">
      <h3>کاربران</h3>
      <div class="d-flex flex-row-reverse justify-content-between">
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
                <th scope="col">نام و نام خانوادگی</th>
                <th scope="col">شماره تماس</th>
                <th scope="col">ایمیل</th>
                <th scope="col">وضعیت</th>
                <th scope="col">ویرایش</th>
                <th scope="col">حذف</th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $user)
                <tr>
                    <th scope="row">{{$user->id}}</th>
                    <td>{{$user->name}}</td>
                    <td>{{$user->phone}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                        @if($user->is_active)
                            <a href="" class="btn btn-sm btn-outline-success">فعال</a>
                        @else
                            <a href="" class="btn btn-sm btn-outline-danger">غیرفعال</a>
                        @endif
                    </td>
                    <td>
                        <a data-toggle="modal" data-target="#updateModal" class="btn btn-sm btn-outline-warning" wire:click='setCurrentUser({{$user}})'>ویرایش</a>
                    </td>
                    <td>
                        <a data-toggle="modal" data-target="#deleteModal" class="btn btn-sm btn-outline-danger"  wire:click='setCurrentUser({{$user}})'>حذف</button>
                    </td>
                </tr>
              @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
    {{-- create modal --}}
    <div wire:ignore.self class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
        aria-hidden="true">
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
                                <div class="form-row">
                                    <div class="form-group col-md-6 text-right">
                                        <label for="phone">موبایل</label>
                                        <input type="tel" class="form-control text-right" wire:model.lazy='phone' id="phone" placeholder="موبایل" required autocomplete="off">
                                        @error('phone')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                  <div class="form-group col-md-6 text-right">
                                    <label for="name">نام و نام خانوادگی</label>
                                    <input type="text" class="form-control text-right" wire:model.lazy='name' id="name" placeholder="نام و نام خانوادگی" required autocomplete="off">
                                    @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                  </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6 text-right">
                                        <label for="role">نقش</label>
                                        <select id="role" class="form-control text-right" wire:model.lazy='roles' multiple>
                                            @foreach($all_roles as $role)
                                                <option value="{{$role->id}}">{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('roles')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6 text-right">
                                      <label for="email">ایمیل</label>
                                      <input type="email" class="form-control text-right" wire:model.lazy='email' id="email" placeholder="ایمیل" required autocomplete="off">
                                      @error('email')
                                          <div class="alert alert-danger">{{ $message }}</div>
                                      @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6 text-right">
                                        <label for="password_confirmation">تکرار رمز عبور</label>
                                        <input type="password" class="form-control text-right" wire:model.lazy='password_confirmation' id="password_confirmation" placeholder="تکرار رمز عبور" required autocomplete="off">
                                        @error('password_confirmation')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6 text-right">
                                      <label for="password">رمز عبور</label>
                                      <input type="password" class="form-control text-right" wire:model.lazy='password' id="password" placeholder="رمز عبور" required autocomplete="off">
                                      @error('password')
                                          <div class="alert alert-danger">{{ $message }}</div>
                                      @enderror
                                    </div>
                                  </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">لغو</button>
                    <button type="button" class="btn btn-outline-primary" wire:click='store'>ثبت</button>
                </div>
            </div>
        </div>
    </div>
    {{-- update modal --}}
    <div wire:ignore.self class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel"
        aria-hidden="true">
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
                                <div class="form-row">
                                    <div class="form-group col-md-6 text-right">
                                        <label for="phone">موبایل</label>
                                        <input type="tel" class="form-control text-right" wire:model.lazy='phone' id="phone" placeholder="موبایل" required autocomplete="off">
                                        @error('phone')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                  <div class="form-group col-md-6 text-right">
                                    <label for="name">نام و نام خانوادگی</label>
                                    <input type="text" class="form-control text-right" wire:model.lazy='name' id="name" placeholder="نام و نام خانوادگی" required autocomplete="off">
                                    @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                  </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6 text-right">
                                        <label for="role">نقش</label>
                                        <select id="role" class="form-control text-right" wire:model.lazy='roles' multiple>
                                            @foreach($all_roles as $role)
                                                <option value="{{$role->id}}">{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('roles')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6 text-right">
                                      <label for="email">ایمیل</label>
                                      <input type="email" class="form-control text-right" wire:model.lazy='email' id="email" placeholder="ایمیل" required autocomplete="off">
                                      @error('email')
                                          <div class="alert alert-danger">{{ $message }}</div>
                                      @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6 text-right">
                                        <label for="password_confirmation">تکرار رمز عبور</label>
                                        <input type="password" class="form-control text-right" wire:model.lazy='password_confirmation' id="password_confirmation" placeholder="تکرار رمز عبور" required autocomplete="off">
                                        @error('password_confirmation')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6 text-right">
                                      <label for="password">رمز عبور</label>
                                      <input type="password" class="form-control text-right" wire:model.lazy='password' id="password" placeholder="رمز عبور" autocomplete="off">
                                      @error('password')
                                          <div class="alert alert-danger">{{ $message }}</div>
                                      @enderror
                                    </div>
                                  </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">لغو</button>
                    <button type="button" class="btn btn-outline-primary" wire:click='update'>ثبت</button>
                </div>
            </div>
        </div>
    </div>
    {{-- delete modal --}}
    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
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
                    <button type="button" class="btn btn-outline-primary" wire:click='delete' data-dismiss="modal">حذف</button>
                </div>
            </div>
        </div>
    </div>
</div>