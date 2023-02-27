<x-layouts.base>
    <div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <a href="{{route('home.index')}}">
                <div class="flex items-center justify-center mx-auto space-x-2 text-indigo-500 text-5xl">
                    <x-icon.house class="font-medium !w-12 !h-12"/>
                    <h2>Houssist</h2>
                </div>
            </a>
            {{ $header }}
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                {{ $slot }}
            </div>
        </div>
    </div>
</x-layouts.base>
