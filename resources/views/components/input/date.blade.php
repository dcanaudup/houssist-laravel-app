<div
    wire:ignore
    x-data="{
        init() {
            flatpickr($refs.{{ $attributes->get('ref') ?? 'input' }}, {
                enableTime: {{ $attributes->has('enableTime') ? 'true' : 'false' }},
                dateFormat: '{{ $attributes->get('dateFormat') ?? 'Y-m-d' }}',
                @if($attributes->get('minDate'))
                minDate: '{{ $attributes->get('minDate') }}',
                @endif
                mode: '{{ $attributes->get('mode') ?? 'single' }}',
                disableMobile: true
            })
        }
    }"
>
    <x-input.text x-ref="{{ $attributes->get('ref') ?? 'input' }}" {{$attributes->except(['ref', 'enableTime', 'dateFormat', 'minDate', 'mode'])}}></x-input.text>
</div>
