<div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <a href="{{route('home.index')}}">
            <img class="mx-auto h-12 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
        </a>
        <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Create a service provider account</h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Or
            <a href="{{route('login')}}" class="font-medium text-indigo-600 hover:text-indigo-500">sign in</a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <form class="space-y-6" wire:submit.prevent="submit" method="POST">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email"
                               required class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                               placeholder="Enter your email"
                               wire:model.lazy="user.email"
                        >
                        @error('user.email')<span class="mt-1 text-sm text-red-700">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password"
                               autocomplete="current-password" required
                               class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                               placeholder="Enter your password"
                               wire:model.lazy="user.password"
                        >
                        @error('user.password')<span class="mt-1 text-sm text-red-700">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div>
                    <button type="submit" class="flex w-full justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Create Account</button>
                </div>
                <div class="items-center text-sm">
                    <p class="text-gray-500">By creating an account, you agree to Houssist's <a href="#" class="font-medium text-gray-700">Terms and Conditions</a></p>
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
    </div>
</div>
