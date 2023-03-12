<span class="inline-flex rounded-md shadow-sm">
    <a
        {{ $attributes->merge([
            'class' => 'text-white bg-indigo-600 hover:bg-indigo-500 active:bg-indigo-700 border-indigo-600 py-2 px-4 border rounded-md text-sm leading-5 font-medium focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition duration-150 ease-in-out' . ($attributes->get('disabled') ? ' opacity-75 cursor-not-allowed' : '')
        ]) }}
    >
        {{ $slot }}
    </a>
</span>
