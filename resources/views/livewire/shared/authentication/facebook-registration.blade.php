<x-slot:header>
    <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Create your account</h2>
    <p class="mt-2 text-center text-sm text-gray-600">
        Or
        <a href="{{route('login')}}" class="font-medium text-indigo-600 hover:text-indigo-500">sign in</a>
    </p>
</x-slot:header>

<div class="bg-indigo-50 py-8 px-4 shadow sm:rounded-lg sm:px-10">
    <form class="space-y-6" wire:submit.prevent="submit" method="POST">
        @csrf
        <x-input name="username" id="username" label="Username" type="text" placeHolder="Enter username" model="username"/>
        <x-input.group for="user_type" label="User Type" :error="$errors->first('user_type')" inline>
            <x-input.select wire:model="user_type" id="user_type" placeholder="Select an option...">
                @foreach (\Spatie\LaravelOptions\Options::forArray(['home_owner' => 'Home Owner', 'service_provider' => 'Service Provider'])->toArray() as $option)
                    <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                @endforeach
            </x-input.select>
        </x-input.group>
        <div>
            <button type="submit" class="flex w-full justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Create Account</button>
        </div>
        <div class="items-center text-sm">
            <p class="text-gray-500">By creating an account, you agree to Houssist's <a href="#" class="font-medium text-gray-700">Terms and Conditions</a></p>
        </div>
    </form>
</div>
