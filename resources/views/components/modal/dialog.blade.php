@props(['id' => null, 'maxWidth' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="px-6 py-4 text-lg">
        {{ $title }}
    </div>

    <div class="px-6 py-4 flex-1 overflow-y-hidden md:overflow-y-scroll mt-4">
        {{ $content }}
    </div>

    <div class="px-6 py-4 bg-gray-100 text-right">
        {{ $footer }}
    </div>
</x-modal>
