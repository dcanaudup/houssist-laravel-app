@props([
    'message' => '',
    'hint' => null,
    ])

<div class="chat-message">
    <div class="flex items-end">
        <div class="flex flex-col space-y-2 text-lg max-w-xs mx-2 order-2 items-start">
            <div><span class="px-4 py-2 rounded-lg inline-block bg-gray-300 text-gray-600">{{$message}}</span></div>
        </div>
    </div>
    @if($hint)
        <div class="mx-2 text-sm">{{$hint}}</div>
    @endif
</div>
