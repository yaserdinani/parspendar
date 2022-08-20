<div
    @if($eventClickEnabled)
        wire:click.stop="onEventClick('{{ $event['id']  }}')"
    @endif
    class="rounded-lg border-2 border-l-indigo-600 p-1 shadow-md cursor-pointer text-white" style="background-color:{{$event['color']}};">

    <p class="text-sm font-medium">
        {{ $event['title'] }}
    </p>
    <p class="mt-1 text-xs">
        {{\Illuminate\Support\Str::limit($event['description'], 10) ?? 'توضیحات ندارد' }}
    </p>
    <p class="text-sm font-medium">
        {{ \Morilog\Jalali\Jalalian::forge($event['finished_at'])->format('%A %d %B') }}
    </p>
</div>
