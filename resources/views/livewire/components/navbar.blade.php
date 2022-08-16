<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand text-danger" href="#">سامانه مدیریت وظایف</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            {{-- @can('') --}}
                <li
                    class="nav-item {{ Illuminate\Support\Facades\Request::route()->getName() == 'livewire.users.index' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('livewire.users.index') }}">کاربران</a>
                </li>
                <li
                    class="nav-item {{ Illuminate\Support\Facades\Request::route()->getName() == 'livewire.status.index' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('livewire.status.index') }}">وضعیت‌ها</a>
                </li>
                <li
                    class="nav-item {{ Illuminate\Support\Facades\Request::route()->getName() == 'livewire.roles.index' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('livewire.roles.index') }}">نقش‌ها</a>
                </li>
                <li
                    class="nav-item {{ Illuminate\Support\Facades\Request::route()->getName() == 'livewire.permissions.index' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('livewire.permissions.index') }}">دسترسی‌ها</a>
                </li>
            {{-- @endcan --}}
            <li
                class="nav-item {{ Illuminate\Support\Facades\Request::route()->getName() == 'livewire.tasks.index' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('livewire.tasks.index') }}">همه‌ی وظایف</a>
            </li>
        </ul>
        <a class="btn btn-outline-danger" wire:click="logout">خروج</a>
    </div>
</nav>
