<div class="container bg-white mt-5 rounded p-2">
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
            <input type="text" class="form-control text-right" wire:model.defer="name" id="name"
                placeholder="نام" required autocomplete="off">
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
            <input type="text" class="form-control text-right finished_at" value="{{ $finish_time }}"
                id="finished_at" required autocomplete="off">
            <input type="hidden" wire:model.defer='finished_at' class="observer-example-alt">
            @error('finished_at')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-6 text-right">
            <label for="started_at">شروع</label>
            <input type="text" class="form-control text-right started_at" value="{{ $start_time }}"
                id="started_at" required autocomplete="off">
            <input type="hidden" wire:model.defer='started_at' class="observer-example-alt">
            @error('started_at')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <button type="button" class="btn btn-outline-secondary" wire:click="$emitUp('resetInputs')">لغو</button>
    <button type="button" class="btn btn-outline-primary" wire:click='store' data-dismiss="modal">ثبت</button>
</div>
