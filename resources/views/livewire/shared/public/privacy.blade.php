<div class="bg-white">
    <header class="absolute inset-x-0 top-0 z-50">
        <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
            <div class="flex lg:flex-1">
                <x-icon.house class="font-medium text-indigo-600 !w-12 !h-12"/>
            </div>
            <div class="flex lg:hidden">
                <button @click="showMenu = !showMenu" type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
                    <span class="sr-only">Open main menu</span>
                    <!-- Heroicon name: outline/bars-3 -->
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
            <div class="hidden lg:flex lg:gap-x-12">
                <a href="/docs" class="text-sm font-semibold leading-6 text-gray-900">Docs</a>

                <a href="{{route('about.index')}}" class="text-sm font-semibold leading-6 text-gray-900">About</a>
            </div>
            <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                <a href="{{route('login')}}" class="text-sm font-semibold leading-6 text-gray-900">Log in <span aria-hidden="true">&rarr;</span></a>
            </div>
        </nav>
        <!-- Mobile menu, show/hide based on menu open state. -->
        <div class="lg:hidden" role="dialog" aria-modal="true" x-show="showMenu">
            <!-- Background backdrop, show/hide based on slide-over state. -->
            <div class="fixed inset-0 z-50"></div>
            <div class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                <div class="flex items-center justify-between">
                    <a href="{{route('home.index')}}" class="-m-1.5 p-1.5">
                        <span class="sr-only">Houssist</span>
                        <x-icon.house class="font-medium text-indigo-600 w-auto h-8"/>
                    </a>
                    <button @click="showMenu = !showMenu" type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700">
                        <span class="sr-only">Close menu</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="mt-6 flow-root">
                    <div class="-my-6 divide-y divide-gray-500/10">
                        <div class="space-y-2 py-6">
                            <a href="/docs" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Docs</a>
                            <a href="{{route('about.index')}}" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">About</a>
                        </div>
                        <div class="py-6">
                            <a href="{{route('login')}}" class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Log in</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="isolate">
        <div class="bg-white px-6 py-32 lg:px-8">
            <div class="mx-auto max-w-3xl text-base leading-7 text-gray-700">
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Privacy Policy</h1>
                <p class="mt-6 text-xl leading-8">Effective Date: January 1, 2023</p>
                <div class="mt-10 max-w-2xl">
                    <p>This privacy policy (“Policy”) explains how Houssist and its affiliates (“us”, “we”, or “our”) collect, use, and share information about you when you use our websites, mobile applications, and other online products and services (collectively, the “Services”).
                        Please read this Policy carefully to understand our policies and practices regarding your information and how we will treat it. If you do not agree with our policies and practices, do not use our Services. By accessing or using our Services, you agree to this Policy. This Policy may change from time to time. Your continued use of our Services after we make changes is deemed to be acceptance of those changes, so please check the Policy periodically for updates.</p>
                    <ol role="list" class="list-decimal mt-8 max-w-xl space-y-8 text-gray-600">
                        <li>
                            <span><strong class="font-semibold text-gray-900">Information We Collect.</strong> We collect several types of information from and about users of our Services, including:</span>
                            <ul class="list-disc">
                                <li>Information that you provide to us directly: We collect information that you provide to us directly, such as when you create an account, fill out a form, or communicate with us through our Services. This may include your name, email address, phone number, and other contact information.</li>
                                <li>Information that we collect automatically: We automatically collect certain information about you when you access or use our Services. This may include your IP address, device type, browser type, and other technical information about your device and connection to our Services. We may also collect information about your location, including through the use of GPS, Bluetooth, and other technologies.</li>
                                <li>Information from third parties: We may receive information about you from third parties, such as social media platforms, advertising networks, and analytics providers.</li>
                            </ul>
                        </li>
                        <li>
                            <span><strong class="font-semibold text-gray-900">How We Use Your Information.</strong> We use the information we collect from and about you for a variety of purposes, including:</span>
                            <ul class="list-disc">
                                <li>To provide, maintain, and improve our Services: We use your information to provide and improve the Services, including to personalize your experience and to communicate with you about your account and activities on the Services.</li>
                                <li>To communicate with you: We may use your information to communicate with you about our Services and other matters that may be of interest to you.</li>
                                <li>To market and advertise to you: We may use your information to send you promotional materials and to personalize the advertising that you see on our Services and other websites.</li>
                                <li>To conduct research and analysis: We may use your information to conduct research and analysis to improve our Services and to develop new products and services.</li>
                                <li>To enforce our policies and comply with legal obligations: We may use your information to enforce our policies and to comply with legal and regulatory obligations.</li>
                            </ul>
                        </li>
                        <li>
                            <span><strong class="font-semibold text-gray-900">How We Share Your Information.</strong> We may share your information with third parties in the following circumstances:</span>
                            <ul class="list-disc">
                                <li>With third-party service providers: We may share your information with third-party service providers who perform services on our behalf, such as hosting, data analysis, payment processing, and marketing.</li>
                                <li>With business partners: We may share your information with business partners for marketing and advertising purposes.</li>
                                <li>In connection with a merger, acquisition, or sale: If we are involved in a merger, acquisition, or sale of all or part of our business, we may share your information with the parties involved in the transaction.</li>
                                <li>As required by law: We may disclose your information as required by law, such as to comply with a subpoena or similar legal process, or to protect the rights, property, and safety of our company and our users.</li>
                            </ul>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="mt-32 sm:mt-40" aria-labelledby="footer-heading">
        <h2 id="footer-heading" class="sr-only">Footer</h2>
        <div class="mx-auto max-w-7xl px-6 pb-8 lg:px-8">
            <div class="mt-16 border-t border-gray-900/10 pt-8 sm:mt-20 md:flex md:items-center md:justify-between lg:mt-24">
                <p class="mt-8 text-xs leading-5 text-gray-500 md:order-1 md:mt-0">&copy; {{ date('Y') }} Houssist. All rights reserved.</p>
            </div>
        </div>
    </footer>
</div>
