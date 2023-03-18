<x-layouts.base>
    <div class="h-screen flex overflow-hidden bg-cool-gray-100" x-data="{ sidebarOpen: false }"
         @keydown.window.escape="sidebarOpen = false">
        <!-- Off-canvas menu for mobile -->
        <div x-show="sidebarOpen" class="md:hidden" style="display: none;">
            <div class="fixed inset-0 flex z-40">
                <div @click="sidebarOpen = false" x-show="sidebarOpen"
                     x-description="Off-canvas menu overlay, show/hide based on off-canvas menu state."
                     x-transition:enter="transition-opacity ease-linear duration-300"
                     x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     x-transition:leave="transition-opacity ease-linear duration-300"
                     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0"
                     style="display: none;">
                    <div class="absolute inset-0 bg-gray-600 opacity-75"></div>
                </div>
                <div x-show="sidebarOpen" x-description="Off-canvas menu, show/hide based on off-canvas menu state."
                     x-transition:enter="transition ease-in-out duration-300 transform"
                     x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                     x-transition:leave="transition ease-in-out duration-300 transform"
                     x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                     class="relative flex-1 flex flex-col max-w-xs w-full bg-indigo-800" style="display: none;">
                    <div class="absolute top-0 right-0 -mr-14 p-1">
                        <button x-show="sidebarOpen" @click="sidebarOpen = false"
                                class="flex items-center justify-center h-12 w-12 rounded-full focus:outline-none focus:bg-gray-600"
                                aria-label="Close sidebar" style="display: none;">
                            <svg class="h-6 w-6 text-white" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                        <div class="flex-shrink-0 flex items-center px-4">
                            <img class="h-8 w-auto" src="/img/logos/workflow-logo-on-brand.svg" alt="Workflow">
                        </div>
                        <nav class="mt-5 px-2 space-y-1">
                            <a href="{{ route(auth()->user()->userable->dashboard_link) }}"
                               class="group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md text-white bg-indigo-900 focus:outline-none focus:bg-indigo-700 transition ease-in-out duration-150">
                                <svg
                                    class="mr-4 h-6 w-6 text-indigo-400 group-hover:text-indigo-300 group-focus:text-indigo-300 transition ease-in-out duration-150"
                                    stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 001-1V10M9 21h6"></path>
                                </svg>
                                Dashboard
                            </a>
                        </nav>
                    </div>
                    <div class="flex-shrink-0 flex border-t border-indigo-700 p-4">
                        <a href="/profile" class="flex-shrink-0 group block focus:outline-none">
                            <div class="flex items-center">
                                <div>
                                    <img class="inline-block h-10 w-10 rounded-full"
                                         src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=2&amp;w=256&amp;h=256&amp;q=80"
                                         alt="">
                                </div>
                                <div class="ml-3">
                                    <p class="text-base leading-6 font-medium text-white">
                                        Paul Weamer
                                    </p>
                                    <p class="text-sm leading-5 font-medium text-indigo-300 group-hover:text-indigo-100 group-focus:underline transition ease-in-out duration-150">
                                        View profile
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="flex-shrink-0 w-14">
                    <!-- Force sidebar to shrink to fit close icon -->
                </div>
            </div>
        </div>

        <!-- Static sidebar for desktop -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 border-r border-gray-200 bg-indigo-800">
                <div class="h-0 flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                    <div class="flex items-center flex-shrink-0 px-4">
                        <a href="{{route('home-owner.dashboard')}}" class="flex items-center justify-center space-x-2">
                            <x-icon.house class="font-medium text-white"/>
                            <h2 class="text-2xl text-white">Houssist</h2>
                        </a>
                    </div>
                    <!-- Sidebar component, swap this element with another sidebar if you like -->
                    <nav class="mt-5 space-y-1 flex-1 px-2 bg-indigo-800">
                        <a href="{{route(auth()->user()->userable->dashboard_link)}}"
                           @class([
                                'group flex items-center px-2 py-2 text-base leading-5 font-medium text-white rounded-md focus:outline-none focus:bg-indigo-700 bg-indigo-900 transition ease-in-out duration-150' => request()->is('*dashboard*'),
                                'text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-base font-medium rounded-md' => !request()->is('*dashboard*'),
                            ])>
                            <svg
                                class="mr-3 h-6 w-6 text-indigo-400 group-focus:text-indigo-300 transition ease-in-out duration-150"
                                stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 001-1V10M9 21h6"></path>
                            </svg>
                            Dashboard
                        </a>
                        <a href="{{route('home-owner.tasks')}}"
                            @class([
                             'group flex items-center px-2 py-2 text-base leading-5 font-medium text-white rounded-md focus:outline-none focus:bg-indigo-700 bg-indigo-900 transition ease-in-out duration-150' => request()->is('*service-provider/tasks*'),
                             'text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-base font-medium rounded-md' => !request()->is('*service-provider/tasks*'),
                             ])
                        >
                            <svg class="mr-3 h-6 w-6 text-indigo-400 group-focus:text-indigo-300 transition ease-in-out duration-150" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
                            </svg>
                            Tasks
                        </a>
                        <a href="{{route('service-provider.tasks')}}"
                            @class([
                             'group flex items-center px-2 py-2 text-base leading-5 font-medium text-white rounded-md focus:outline-none focus:bg-indigo-700 bg-indigo-900 transition ease-in-out duration-150' => request()->is('*service-provider/tasks*'),
                             'text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-base font-medium rounded-md' => !request()->is('*service-provider/tasks*'),
                             ])
                        >
                            <svg class="mr-3 h-6 w-6 text-indigo-400 group-focus:text-indigo-300 transition ease-in-out duration-150" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
                            </svg>


                            My Tasks
                        </a>
                        <a href="{{route('home-owner.advertisements')}}"
                            @class([
                             'group flex items-center px-2 py-2 text-base leading-5 font-medium text-white rounded-md focus:outline-none focus:bg-indigo-700 bg-indigo-900 transition ease-in-out duration-150' => request()->is('*home-owner/advertisements*'),
                             'text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-base font-medium rounded-md' => !request()->is('*home-owner/advertisements*'),
                             ])
                        >
                            <svg class="mr-3 h-6 w-6 text-indigo-400 group-focus:text-indigo-300 transition ease-in-out duration-150" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" />
                            </svg>

                            My Ads
                        </a>
                        <a href="{{route('service-provider.advertisements')}}"
                            @class([
                             'group flex items-center px-2 py-2 text-base leading-5 font-medium text-white rounded-md focus:outline-none focus:bg-indigo-700 bg-indigo-900 transition ease-in-out duration-150' => request()->is('*service-provider/advertisements*'),
                             'text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-base font-medium rounded-md' => !request()->is('*service-provider/advertisements*'),
                             ])
                        >
                            <svg class="mr-3 h-6 w-6 text-indigo-400 group-focus:text-indigo-300 transition ease-in-out duration-150" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" />
                            </svg>

                            Available Ads
                        </a>
                        <a href="{{route('shared.deposits')}}"
                           @class([
                            'group flex items-center px-2 py-2 text-base leading-5 font-medium text-white rounded-md focus:outline-none focus:bg-indigo-700 bg-indigo-900 transition ease-in-out duration-150' => request()->is('*deposits*'),
                            'text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-base font-medium rounded-md' => !request()->is('*deposits*'),
                            ])
                           >
                            <svg class="mr-3 h-6 w-6 text-indigo-400 group-focus:text-indigo-300 transition ease-in-out duration-150" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                            </svg>
                            Deposits
                        </a>
                        <a href="{{route('admin.kyc.approvals')}}"
                            @class([
                             'group flex items-center px-2 py-2 text-base leading-5 font-medium text-white rounded-md focus:outline-none focus:bg-indigo-700 bg-indigo-900 transition ease-in-out duration-150' => request()->is('*kyc/approvals*'),
                             'text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-base font-medium rounded-md' => !request()->is('*kyc/approvals*'),
                             ])
                        >
                            <svg class="mr-3 h-6 w-6 text-indigo-400 group-focus:text-indigo-300 transition ease-in-out duration-150" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776" />
                            </svg>

                            KYC Approvals
                        </a>
                        <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf
                            <button type="submit"
                                @class([
                                     'text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-base font-medium rounded-md w-full',
                                 ])>
                                <svg
                                    class="mr-3 h-6 w-6 text-indigo-400 group-focus:text-indigo-300 transition ease-in-out duration-150"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </nav>
                </div>

                <div class="flex-shrink-0 flex border-t border-indigo-700 p-4">
                    <a href="/profile" class="flex-shrink-0 w-full group block">
                        <div class="flex items-center">
                            <div>
                                <img class="inline-block h-9 w-9 rounded-full"
                                     src="https://images.unsplash.com/photo-1517365830460-955ce3ccd263?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=256&h=256&q=80"
                                     alt="Profile Photo">
                            </div>

                            <div class="ml-3">
                                <p class="text-sm leading-5 font-medium text-white">
                                    Paul Weamer
                                </p>

                                <p class="text-xs leading-4 font-medium text-indigo-300 group-hover:text-indigo-100 transition ease-in-out duration-150">
                                    View profile
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="flex flex-col w-0 flex-1 overflow-hidden">
            <div class="md:hidden pl-1 pt-1 sm:pl-3 sm:pt-3">
                <button @click.stop="sidebarOpen = true"
                        class="-ml-0.5 -mt-0.5 h-12 w-12 inline-flex items-center justify-center rounded-md text-gray-500 hover:text-gray-900 focus:outline-none focus:bg-gray-200 transition ease-in-out duration-150"
                        aria-label="Open sidebar">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <main class="flex-1 relative z-0 overflow-y-auto pt-2 pb-6 focus:outline-none md:py-6" tabindex="0"
                  x-data="" x-init="$el.focus()">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                    {{ $slot }}
                </div>
            </main>
        </div>

        <x-notification/>
    </div>
</x-layouts.base>
