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
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Terms & Conditions</h1>
                <p class="mt-6 text-xl leading-8">Effective Date: January 1, 2023</p>
                <div class="mt-10 max-w-2xl">
                    <p>Welcome to Houssist ("we", "us", or "our"). These terms and conditions ("Terms") govern your access to and use of our websites, mobile applications, and other online products and services (collectively, the "Services”). Please read these Terms carefully before using our Services. By accessing or using our Services, you agree to be bound by these Terms and our Privacy Policy. If you do not agree to these Terms and our Privacy Policy, do not use our Services.</p>
                    <ol role="list" class="list-decimal mt-8 max-w-xl space-y-8 text-gray-600">
                        <li>
                            <span><strong class="font-semibold text-gray-900">Privacy.</strong> Your privacy is important to us. Our Privacy Policy explains how we collect, use, and share information about you when you use our Services. By using our Services, you consent to the collection, use, and sharing of your information as described in our Privacy Policy.</span>
                        </li>
                        <li>
                            <span><strong class="font-semibold text-gray-900">Data Privacy Act of 2012.</strong> We are committed to complying with the Data Privacy Act of 2012 and its implementing rules and regulations. This means that we will only collect, use, and share your personal information for legitimate purposes and in accordance with the Act. If you have any questions about your data privacy rights or our compliance with the Act, please contact us at info@houssist.me.
</span>
                        </li>
                        <li>
                            <span><strong class="font-semibold text-gray-900">Changes to These Terms and Our Services.</strong> We may make changes to these Terms from time to time. We will post any changes on this page and encourage you to review the Terms periodically. If we make material changes to these Terms, we will provide notice through our Services or by other means. Your continued use of our Services after any changes to these Terms will constitute your acceptance of such changes. We may also change, suspend, or discontinue any aspect of our Services at any time, including the availability of any feature, database, or content. We may also impose limits on certain features and services or restrict your access to parts or all of our Services without notice or liability.</span>
                        </li>
                        <li>
                            <span><strong class="font-semibold text-gray-900">User Content.</strong> Our Services may allow you to post, upload, or otherwise submit content (“User Content”). By submitting User Content to our Services, you grant us a worldwide, perpetual, irrevocable, royalty-free, and fully sublicensable license to use, reproduce, modify, adapt, publish, translate, create derivative works from, distribute, and display your User Content in any media. You represent and warrant that you have the right to grant this license and that your User Content does not violate any laws or infringe the rights of any third party.
We are under no obligation to monitor or control User Content posted through our Services, and we do not endorse any User Content. However, we reserve the right to remove any User Content at any time for any reason, without notice.</span>
                        </li>
                        <li><span><strong class="font-semibold text-gray-900">User Obligations.</strong> You are responsible for maintaining the confidentiality of your login credentials, and you agree not to share your username or password with anyone.

                            You are responsible for all activities that occur under your account, and you agree to notify us immediately if you suspect any unauthorized use of your account.

                            You agree to provide accurate and complete information when creating your account, and to update your information promptly if there are any changes.

                            You agree to comply with all applicable laws and regulations, including those related to data privacy and security.</li>
                        <li>
                            <span><strong class="font-semibold text-gray-900">Intellectual Property.</strong> The content and materials on our Services, including but not limited to text, graphics, logos, images, and software, are protected by intellectual property laws. Except as expressly provided in these Terms, we do not grant any express or implied rights to use the content and materials on our Services.</span>
                        </li>
                        <li>
                            <span><strong class="font-semibold text-gray-900">Disclaimer of Warranties.</strong> As a user of our service, it's important to understand that our service is provided "as is" and without any warranties or guarantees of any kind, either expressed or implied.

We do not warrant that our service will meet your specific requirements, that it will be uninterrupted, timely, secure, or error-free, or that the results that may be obtained from the use of the service will be accurate or reliable.

We do not guarantee that our service will be free from viruses, hacking, or other malicious attacks, and we are not responsible for any damages that may result from such events.

Furthermore, we do not warrant that any information obtained by you from our service will be accurate or reliable, or that any defects in the service will be corrected.

You agree that the use of our service is at your own risk, and we will not be liable for any damages of any kind arising from the use of our service, including but not limited to direct, indirect, incidental, punitive, and consequential damages.

By using our service, you acknowledge and agree to these disclaimers of warranties and limitations of liability. If you do not agree to these terms, you may not use our service.</span>
                        </li>
                        <li>
                            <span><strong class="font-semibold text-gray-900">Limitation of Liability.</strong> We will not be liable for any indirect, incidental, consequential, or punitive damages arising from the use of our service, even if we have been advised of the possibility of such damages.

Our total liability for any claims arising from the use of our service will not exceed the amount paid by you for the service in the twelve (12) months preceding the claim.</span>
                        </li>
                        <li>
                            <span><strong class="font-semibold text-gray-900">Governing law and jurisdiction.</strong> This agreement will be governed by and construed in accordance with the laws of the Philippines, without giving effect to any principles of conflicts of law.

Any disputes arising from this agreement will be resolved in the courts of the Philippines, and you hereby consent to the jurisdiction of such courts.
</span>
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
