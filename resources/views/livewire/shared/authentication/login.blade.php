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
    @if($facebookEnabled ?? false)
    <div class="mt-6">
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="bg-white px-2 text-gray-500">Or continue with</span>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 gap-4">

            <a href="{{route('facebook.auth')}}" class="flex w-full items-center justify-center gap-3 rounded-md bg-[#1877F2] px-3 py-1.5 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1D9BF0]">
                <svg class="h-5 w-5" fill="currentColor" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title>Facebook</title><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                <span class="text-sm font-semibold leading-6">Facebook</span>
            </a>
        </div>
    </div>
    @endif
</div>
