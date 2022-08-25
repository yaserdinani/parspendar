@section('title', 'نظرات')
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
    <div class="card-header text-center">
        <h3>نظرات وظیفه {{ $task->name }}</h3>
    </div>
    <div class="card-body">
        <form wire:submit.prevent='store' class="mb-3">
            <div class="form-row">
                <div class="form-group col-12 text-right">
                    <label for="description">متن یادداشت</label>
                    <textarea rows="5" class="form-control text-right" wire:model='description' id="description" required
                        autocomplete="off" style="text-direction:rtl;">
                    </textarea>
                    @if ($showUsersFlag)
                        <select class="form-control col-md-2 mx-2" style="margin-top:-6%;" wire:model.defer="mention_list" id="mention_list" wire:change='userChoosed($event.target.value)'>
                            <option value="0">انتخاب کنید</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    @endif
                    @error('description')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            @if (!$showUsersFlag)
            <button type="submit mt-3" class="btn btn-outline-primary">ثبت یادداشت</button>
            @endif
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
