@props([
    'message' => '',
    'hint' => null,
    ])

<div class="chat-message">
    <div class="flex items-end justify-end">
        <div class="flex flex-col space-y-2 text-lg max-w-xs mx-2 order-1 items-end">
            <div><span class="px-4 py-2 rounded-lg inline-block rounded-br-none bg-indigo-600 text-white">{{$message}}</span></div>
        </div>
    </div>
    @if($hint)
        <div class="flex items-end justify-end mx-2 text-sm">{{$hint}}</div>
    @endif
</div>
