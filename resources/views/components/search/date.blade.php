<div
    wire:ignore
    x-data="{
        instance: null,
        value: @entangle($attributes->get('name')),
        init() {
            $watch('value', value => instance.setDate(value, true));
            instance = flatpickr($refs.{{ $attributes->get('ref') ?? 'input' }}, {
                enableTime: {{ $attributes->has('enableTime') ? 'true' : 'false' }},
                dateFormat: '{{ $attributes->get('dateFormat') ?? 'Y-m-d' }}',
                @if($attributes->get('minDate'))
                minDate: '{{ $attributes->get('minDate') }}',
                @endif
                mode: '{{ $attributes->get('mode') ?? 'single' }}',
                onClose: function(selectedDates, dateStr, instance) {
                    @this.set('{{ $attributes->get('name') }}', dateStr)
                },
                defaultDate: @this.{{ $attributes->get('name')}} ?? null
            })
        }
    }"
>
    <x-input.text x-ref="{{ $attributes->get('ref') ?? 'input' }}" {{$attributes->except(['ref', 'enableTime', 'dateFormat', 'minDate', 'mode'])}}></x-input.text>
</div>
