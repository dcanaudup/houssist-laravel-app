<button
    {{ $attributes->merge([
        'type' => 'button',
        'class' => 'text-indigo-700 text-sm leading-5 font-medium hover:underline focus:outline-none focus:text-indigo-800 focus:underline transition duration-150 ease-in-out' . ($attributes->get('disabled') ? ' opacity-75 cursor-not-allowed' : ''),
    ]) }}
>
    {{ $slot }}
</button>
