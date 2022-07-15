@extends('layouts.app')
@section('title', 'داشبورد')
@section('content')
    <div class="alert alert-success mt-5 text-center " role="alert">
        @if(auth()->user()->is_admin)
            <span>خوش آمدید {{auth()->user()->name}} مدیر گرامی</span>
        @else
            <span>خوش آمدید {{auth()->user()->name}} کاربر گرامی</span>
        @endif
    </div>
@endsection