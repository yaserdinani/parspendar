@extends('layouts.app')
@section('title', 'افزودن وظیفه')
@section('content')
<div class="card">
    <div class="card-header text-center">
      <h3>ساخت وظیفه جدید</h3>
    </div>
    <div class="card-body">
        <form action="{{route('tasks.store')}}" method="post">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-6 text-right">
                    <label for="description">توضیحات</label>
                    <textarea class="form-control text-right" id="description" name="description" rows="3" required>
                        {{old('description')}}    
                    </textarea>                
                </div>
              <div class="form-group col-md-6 text-right">
                <label for="name">نام</label>
                <input type="text" class="form-control text-right" name="name" id="name" placeholder="نام" required autocomplete="off" value="{{old('name')}}">
              </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6 text-right">
                    @if(auth()->user()->is_admin)
                        <label for="users">کاربران</label>
                        <select multiple class="form-control" id="users" name="users[]">
                            @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>  
                            @endforeach
                        </select>
                    @endif
                </div>
                <div class="form-group col-md-6 text-right">
                    <label for="role">وضعیت</label>
                    <select id="role" class="form-control text-right" name="status">
                      <option value="0" selected>انجام نشده</option>
                      <option value="1">در حال انجام</option>
                      <option value="2">انجام شده</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6 text-right">
                <label for="finished_at">پایان</label>
                <input type="date" class="form-control text-right" name="finished_at" id="finished_at"  required autocomplete="off" value="{{old('name')}}">
              </div>
              <div class="form-group col-md-6 text-right">
                <label for="started_at">شروع</label>
                <input type="date" class="form-control text-right" name="started_at" id="started_at"  required autocomplete="off" value="{{old('started_at')}}">
              </div>
            </div>
            <button type="submit" class="btn btn-success">افزودن</button>
        </form>
    </div>
</div>
@endsection