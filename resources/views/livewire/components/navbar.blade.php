<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand text-danger" href="#">سامانه مدیریت وظایف</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        @if(auth()->user()->is_admin)
            <li class="nav-item {{(Illuminate\Support\Facades\Request::route()->getName() == 'users.index') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('livewire.users.index')}}">کاربران</a>
            </li>
        @endif
        <li class="nav-item {{(Illuminate\Support\Facades\Request::route()->getName() == 'tasks.index') ? 'active' : ''}}">
            <a class="nav-link" href="{{route('livewire.tasks.index')}}">همه‌ی وظایف</a>
        </li>
      </ul>
      <a class="btn btn-outline-danger" wire:click="logout">خروج</a>
    </div>
</nav>