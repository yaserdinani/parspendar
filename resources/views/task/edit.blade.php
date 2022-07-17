@extends('layouts.app')
@section('title', 'ویرایش وظیفه')
@section('content')
<div class="card">
    <div class="card-header text-center">
      <h3>ویرایش وظیفه</h3>
    </div>
    <div class="card-body">
        <form action="{{route('tasks.update',$task)}}" method="post">
            @csrf
            @method('put')
            <div class="form-row">
                <div class="form-group col-md-6 text-right">
                    <label for="description">توضیحات</label>
                    <textarea class="form-control text-right" id="description" name="description" rows="3" required>
                        {{$task->description}}    
                    </textarea>
                    @error('description')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror              
                </div>
              <div class="form-group col-md-6 text-right">
                <label for="name">نام</label>
                <input type="text" class="form-control text-right" name="name" id="name" placeholder="نام" required autocomplete="off" value="{{$task->name}}">
                @error('name')
                  <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6 text-right">
                    @if(auth()->user()->is_admin)
                        <label for="users">کاربران</label>
                        <select multiple class="form-control" id="users" name="users[]">
                            @foreach($users as $user)
                                <option value="{{$user->id}}" {{($task->users()->where('user_id',$user->id)->exists()) ? "selected" : ""}}>{{$user->name}}</option>  
                            @endforeach
                        </select>
                    @endif
                </div>
                <div class="form-group col-md-6 text-right">
                    <label for="role">وضعیت</label>
                    <select id="role" class="form-control text-right" name="status">
                      <option value="0" {{($task->status ==0) ? 'selected' : ''}}>انجام نشده</option>
                      <option value="1" {{($task->status ==1) ? 'selected' : ''}}>در حال انجام</option>
                      <option value="2" {{($task->status ==2) ? 'selected' : ''}}>انجام شده</option>
                    </select>
                    @error('role')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6 text-right">
                <label for="finished_at">پایان</label>
                <input type="date" class="form-control text-right" name="finished_at" id="finished_at"  required autocomplete="off" value="{{date('Y-m-d', strtotime($task->finished_at))}}">
                @error('finished_at')
                  <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>
              <div class="form-group col-md-6 text-right">
                <label for="started_at">شروع</label>
                <input type="date" class="form-control text-right" name="started_at" id="started_at"  required autocomplete="off" value="{{date('Y-m-d', strtotime($task->started_at))}}">
                @error('started_at')
                  <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <button type="submit" class="btn btn-success" onclick="return confirm('آیا از ویرایش این وظیفه اطمینان دارید؟')">ویرایش</button>
        </form>
    </div>
</div>
@endsection