@section('title', 'نوتیفیکیشن ها')
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
        <h3>همه‌ی نوتیفیکیشن ها</h3>
        <div class="d-flex flex-row-reverse">
            <input autocomplete="off" type="text" class="col-md-2 form-control text-right mx-1"
                wire:model.lazy='filter_text' placeholder="جستجو" id="filter_text" name="filter_text">
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered text-center" dir="rtl">
            <thead>
                <tr>
                    <th scope="col">شناسه</th>
                    <th scope="col">توضیح</th>
                    <th scope="col">خوانده شده</th>
                    <th scope="col">حذف</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($notifications as $notification)
                    <tr>
                        <th scope="row">{{ $notification->id }}</th>
                        <td class="text-right">{{ $notification->description }}</td>
                        <td>
                            <input class="form-check-input" type="checkbox" {{($notification->is_seen) ? 'checked' : ''}} wire:change="$emit('seenNotification',{{ $notification}},$event.target.value)">
                        </td>
                        <td>
                            <a data-toggle="modal" data-target="#deleteModal" class="btn btn-sm btn-outline-danger"
                                wire:click="setNotification({{ $notification }})">حذف</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $notifications->links() }}
    </div>
    {{-- delete modal --}}
    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
        aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">افزودن نوتیفیکیشن</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    آیا از حذف این نوتیفیکیشن اطمینان دارید؟
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"
                        wire:click="resetInputs">لغو</button>
                    <button type="button" class="btn btn-outline-primary" wire:click='delete'
                        data-dismiss="modal">حذف</button>
                </div>
            </div>
        </div>
    </div>
</div>
