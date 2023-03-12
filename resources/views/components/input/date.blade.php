<div
    wire:ignore
    x-data
    x-init="
        flatpickr($refs.{{ $attributes->get('ref') ?? 'input' }}, {
            enableTime: {{ $attributes->has('enableTime') ? 'true' : 'false' }},
            dateFormat: '{{ $attributes->get('dateFormat') ?? 'Y-m-d' }}',
            minDate: '{{ $attributes->get('minDate') ?? 'null' }}',
            mode: '{{ $attributes->get('mode') ?? 'single' }}'
        })
    "
>
    <x-input.text x-ref="{{ $attributes->get('ref') ?? 'input' }}" {{$attributes->except(['ref', 'enableTime', 'dateFormat', 'minDate', 'mode'])}}></x-input.text>
</div>
