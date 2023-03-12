<div>
    <h1 class="text-4xl font-semibold text-gray-900">Offer #{{$view_advertisement_offer_data->advertisement_offer_id}}</h1>
    <div class="py-4 space-y-4">
        <!-- Top Bar -->
        <div class="flex justify-between">
            <div class="w-2/4 flex space-x-4">
            </div>

            <div class="space-x-2 flex items-center">
                <x-label.button href="{{route('home-owner.advertisements.show', $view_advertisement_offer_data->advertisement_id)}}">Back</x-label.button>
            </div>
        </div>

        <div class="bg-white py-6 px-4 sm:p-6 rounded-lg">
            <x-label.group label="Service Provider">
                <dd class="mt-1 text-sm text-gray-900">{{ $view_advertisement_offer_data->service_provider->name . "({$view_advertisement_offer_data->service_provider->email})" }}</dd>
            </x-label.group>

            <x-label.group label="Rate Offered">
                <dd class="mt-1 text-sm text-gray-900">{{ $view_advertisement_offer_data->payment_rate }}</dd>
            </x-label.group>

            <x-label.group label="Offer Date">
                <dd class="mt-1 text-sm text-gray-900">{{ date_for_humans($view_advertisement_offer_data->created_at) }}</dd>
            </x-label.group>
            <x-label.group label="Actions">
                <x-button.primary wire:click="accept">Accept</x-button.primary>
                <x-button.danger wire:click="reject">Reject</x-button.danger>
            </x-label.group>
        </div>
        <div class="bg-white py-6 px-4 sm:p-6 rounded-lg">
            <div class="flex-1 p:2 sm:p-6 justify-between flex flex-col">
                <div id="messages" class="flex flex-col space-y-4 p-3 overflow-y-auto scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch">
                    <div class="chat-message">
                        <div class="flex items-end">
                            <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-2 items-start">
                                <div><span class="px-4 py-2 rounded-lg inline-block rounded-bl-none bg-gray-300 text-gray-600">Can be verified on any platform using docker</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-message">
                        <div class="flex items-end justify-end">
                            <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-1 items-end">
                                <div><span class="px-4 py-2 rounded-lg inline-block rounded-br-none bg-indigo-600 text-white ">Your error message says permission denied, npm global installs must be given root privileges.</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-message">
                        <div class="flex items-end">
                            <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-2 items-start">
                                <div><span class="px-4 py-2 rounded-lg inline-block bg-gray-300 text-gray-600">Command was run with root privileges. I'm sure about that.</span></div>
                                <div><span class="px-4 py-2 rounded-lg inline-block bg-gray-300 text-gray-600">I've update the description so it's more obviously now</span></div>
                                <div><span class="px-4 py-2 rounded-lg inline-block bg-gray-300 text-gray-600">FYI https://askubuntu.com/a/700266/510172</span></div>
                                <div>
                      <span class="px-4 py-2 rounded-lg inline-block rounded-bl-none bg-gray-300 text-gray-600">
                         Check the line above (it ends with a # so, I'm running it as root )
                         <pre># npm install -g @vue/devtools</pre>
                      </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-message">
                        <div class="flex items-end justify-end">
                            <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-1 items-end">
                                <div><span class="px-4 py-2 rounded-lg inline-block rounded-br-none bg-indigo-600 text-white ">Any updates on this issue? I'm getting the same error when trying to install devtools. Thanks</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-message">
                        <div class="flex items-end">
                            <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-2 items-start">
                                <div><span class="px-4 py-2 rounded-lg inline-block rounded-bl-none bg-gray-300 text-gray-600">Thanks for your message David. I thought I'm alone with this issue. Please, ? the issue to support it :)</span></div>
                                <div><span class="px-4 py-2 rounded-lg inline-block bg-gray-300 text-gray-600">It seems like you are from Mac OS world. There is no /Users/ folder on linux ?</span></div>
                                <div><span class="px-4 py-2 rounded-lg inline-block rounded-bl-none bg-gray-300 text-gray-600">I have no issue with any other packages installed with root permission globally.</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-message">
                        <div class="flex items-end justify-end">
                            <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-1 items-end">
                                <div><span class="px-4 py-2 rounded-lg inline-block rounded-br-none bg-indigo-600 text-white ">yes, I have a mac. I never had issues with root permission as well, but this helped me to solve the problem</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border-t-2 border-gray-200 px-4 pt-4 mb-2 sm:mb-0">
                    <div class="relative flex">
                        <input type="text" placeholder="Write your message" class="w-full focus:outline-none focus:placeholder-gray-400 text-gray-600 placeholder-gray-600 bg-gray-200 rounded-md py-3">
                        <div class="absolute right-0 items-center inset-y-0 hidden sm:flex">
                            <button type="button" class="inline-flex items-center justify-center rounded-lg px-4 py-3 transition duration-500 ease-in-out text-white bg-indigo-500 hover:bg-indigo-400 focus:outline-none">
                                <span class="font-bold">Send</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-6 w-6 ml-2 transform rotate-90">
                                    <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
