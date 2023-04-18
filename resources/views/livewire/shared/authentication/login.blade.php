<x-slot:header>
    <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Sign in</h2>
    <p class="mt-2 text-center text-sm text-gray-600">
        Or
        <a href="{{route('home-owner.registration.create')}}" class="font-medium text-indigo-600 hover:text-indigo-500">register</a>
    </p>
</x-slot:header>

<div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
    <form class="space-y-6" wire:submit.prevent="submit" method="POST">
        @csrf
        <x-input name="email" id="email" label="Email" type="text" placeHolder="Enter email" model="email"/>
        <x-input name="password" id="password" label="Password" type="password" placeHolder="Enter password" model="password"/>
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember" name="remember" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" wire:model="remember">
                <label for="remember" class="ml-2 block text-sm text-gray-900">Remember me</label>
            </div>

            <div class="text-sm">
                <a href="{{route('password.request')}}" class="font-medium text-indigo-600 hover:text-indigo-500">Forgot your password?</a>
            </div>
        </div>
        <div>
            <button type="submit" class="flex w-full justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Sign In</button>
        </div>
    </form>
    <div class="mt-6">
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="bg-white px-2 text-gray-500">Or</span>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-3 gap-3">
            <div class="col-span-3">
                <a href="{{route('facebook.auth')}}" class="bg-blue-800 hover:bg-blue-900 text-white font-bold py-2 px-4 focus:outline-none focus:shadow-outline inline-flex w-full justify-center rounded-md bg-white px-4 py-2 text-gray-500 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-offset-0">
                    Login With Facebook
                </a>
            </div>
        </div>
    </div>
</div>
