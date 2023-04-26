<x-slot:header>
    <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Create a service provider account</h2>
    <p class="mt-2 text-center text-sm text-gray-600">
        Or
        <a href="{{route('login')}}" class="font-medium text-indigo-600 hover:text-indigo-500">sign in</a>
    </p>
</x-slot:header>
<div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
    <form class="space-y-6" wire:submit.prevent="submit" method="POST">
        @csrf
        <x-input name="user.username" id="user.username" label="Username" type="text" placeHolder="Enter username" model="user.username"/>
        <x-input name="user.email" id="user.email" label="Email" type="text" placeHolder="Enter email" model="user.email"/>
        <x-input name="user.password" id="user.password" label="Password" type="password" placeHolder="Enter password" model="user.password"/>
        <div>
            <button type="submit" class="flex w-full justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Create Account</button>
        </div>
        <div class="items-center text-sm">
            <p class="text-gray-500">By creating an account, you agree to Houssist's <a href="{{route('terms.index')}}" class="font-medium text-gray-700" target="_blank">Terms and Conditions</a></p>
        </div>
    </form>

    <div class="mt-6">
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="bg-white px-2 text-gray-500">Are you a homeowner?</span>
            </div>
        </div>
        <div class="mt-6">
            <a href="{{route('home-owner.registration.create')}}" class="inline-flex w-full justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-500 shadow-sm hover:bg-gray-50">
                Create a homeowner account
            </a>
        </div>
    </div>
</div>
