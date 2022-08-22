@section('title', 'نظرات')
<div class="card">
    <div wire:loading>
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
    <div class="card-header text-center">
        <h3>نظرات وظیفه {{ $task->name }}</h3>
    </div>
    <div class="card-body">
        <form wire:submit.prevent='store' class="mb-3">
            <div class="form-row">
                <div class="form-group col-md-6 text-right">
                    <label for="mention_list">منشن کاربران</label>
                    <select class="form-control" wire:model.defer="mention_list" id="mention_list" multiple="multiple">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6 text-right">
                    <label for="description">متن یادداشت</label>
                    <textarea rows="3" class="form-control text-right" wire:model.defer='description' id="description" required
                        autocomplete="off"></textarea>
                    @error('description')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-outline-primary">ثبت یادداشت</button>
        </form>
        <hr>
        <h2 class="text-center my-3">یادداشت ها</h2>
        <div style="overflow:hidden;overflow-y:scroll;height:50vh;">
            @foreach ($comments as $comment)
                <div class="rounded border border-secondary p-1 text-right m-2" style="direction: rtl;">
                    <p>
                        {{ $comment->description }}
                    </p>
                    @foreach ($comment->mentionUsers as $mention_user)
                        <small class="bg-secondary p-1 rounded d-inline text-white">{{ $mention_user->name }}</small>
                    @endforeach
                    <hr class="my-2">
                    <small>
                        ایجاد شده در روز
                    </small>
                    <small>
                        {{ \Morilog\Jalali\Jalalian::forge($comment->created_at)->format('%A %d %B %Y') }}
                    </small>
                    <small>
                        توسط
                    </small>
                    <small>
                        {{ $comment->user->name }}
                    </small>
                </div>
            @endforeach
        </div>
    </div>
</div>
