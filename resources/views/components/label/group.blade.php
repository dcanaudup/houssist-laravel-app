@props([
    'label',
    'paddingless' => false,
    'borderless' => false,
])

<div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start {{ $borderless ? '' : ' sm:border-t ' }} sm:border-gray-200 {{ $paddingless ? '' : ' sm:py-5 ' }}">
    <dt class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">{{ $label }}</dt>

    <div class="mt-1 sm:mt-0 sm:col-span-2">
        {{ $slot }}
    </div>
</div>
