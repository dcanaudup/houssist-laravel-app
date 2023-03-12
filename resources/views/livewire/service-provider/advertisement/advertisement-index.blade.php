<div>
    <h1 class="text-4xl font-semibold text-gray-900">Available Ads</h1>
    <div class="py-4 space-y-4">
        <div class="bg-white rounded-lg">
            <div class="mx-auto max-w-2xl py-8 px-4 sm:py-12 sm:px-6 lg:max-w-7xl lg:px-8">
                <h2 class="sr-only">Products</h2>

                <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                    @foreach($advertisements as $advertisement)
                        <a href="{{route('service-provider.advertisements.show', $advertisement->advertisement_id)}}" class="group">
                            <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                                {{ $advertisement->media->first() }}
                            </div>
                            <h3 class="mt-4 text-sm text-gray-700">{{ $advertisement->title }}</h3>
                            <p class="mt-1 text-lg font-medium text-gray-900">{{ $advertisement->payment_rate }} ({{ $advertisement->job_payment_type }})</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
