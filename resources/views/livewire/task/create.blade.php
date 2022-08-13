@section('title', 'افزودن وظیفه')
    <div class="card">
        <div class="card-header text-center">
            <h3>ساخت وظیفه جدید</h3>
        </div>
        <div class="card-body">
            <form wire:submit.prevent='store'>
                <div class="form-row">
                    <div class="form-group col-md-6 text-right">
                        <label for="description">توضیحات</label>
                        <textarea class="form-control text-right" id="description" wire:model.lazy="description" rows="3" required>
                        {{ old('description') }}    
                    </textarea>
                        @error('description')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 text-right">
                        <label for="name">نام</label>
                        <input type="text" class="form-control text-right" wire:model.lazy="name" id="name"
                            placeholder="نام" required autocomplete="off">
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6 text-right">
                        @if (auth()->user()->is_admin)
                            <label for="users">کاربران</label>
                            <select multiple class="form-control" id="users" wire:model.lazy="persons">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                    <div class="form-group col-md-6 text-right">
                        <label for="role">وضعیت</label>
                        <select id="role" class="form-control text-right" wire:model.lazy="status">
                            <option value="0" selected>انجام نشده</option>
                            <option value="1">در حال انجام</option>
                            <option value="2">انجام شده</option>
                        </select>
                        @error('role')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6 text-right">
                        <label for="finished_at">پایان</label>
                        <input type="date" class="form-control text-right" wire:model.lazy="finished_at" id="finished_at" required
                            autocomplete="off">
                        @error('finished_at')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 text-right">
                        <label for="started_at">شروع</label>
                        <input type="date" class="form-control text-right" wire:model.lazy="started_at" id="started_at" required
                            autocomplete="off">
                        @error('started_at')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-success"
                    onclick="return confirm('آیا از اطلاعات وارد شده اطمینان دارید؟')">افزودن</button>
            </form>
        </div>
    </div>
