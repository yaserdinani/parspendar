@section('title', 'افزودن کاربر')
<div class="card">
    <div class="card-header text-center">
      <h3>ساخت کاربر جدید</h3>
    </div>
    <div class="card-body">
        <form wire:submit.prevent='store'>
            @csrf
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
                    <select id="role" class="form-control text-right" wire:model.lazy='role'>
                      <option value="0">کاربر عادی</option>
                      <option value="1">مدیر</option>
                    </select>
                    @error('role')
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
            <button type="submit" class="btn btn-success" onclick="return confirm('آیا از صحت اطلاعات وارد شده اطمینان دارید؟')">افزودن</button>
        </form>
    </div>
</div>