<x-guest-layout>
    <x-slot name="header">

        <!-- You can add a header if needed -->
    </x-slot>

    @if($banners->isNotEmpty())
        @foreach($banners as $banner)
            <div class="relative isolate flex items-center gap-x-6 overflow-hidden bg-gray-50 px-6 py-2.5 sm:px-3.5 sm:before:flex-1">
                <div class="absolute left-[max(-7rem,calc(50%-52rem))] top-1/2 -z-10 -translate-y-1/2 transform-gpu blur-2xl" aria-hidden="true">
                    <div class="aspect-[577/310] w-[36.0625rem] bg-gradient-to-r from-[#ff80b5] to-[#9089fc] opacity-30" style="clip-path: polygon(74.8% 41.9%, 97.2% 73.2%, 100% 34.9%, 92.5% 0.4%, 87.5% 0%, 75% 28.6%, 58.5% 54.6%, 50.1% 56.8%, 46.9% 44%, 48.3% 17.4%, 24.7% 53.9%, 0% 27.9%, 11.9% 74.2%, 24.9% 54.1%, 68.6% 100%, 74.8% 41.9%)"></div>
                </div>
                <div class="absolute left-[max(45rem,calc(50%+8rem))] top-1/2 -z-10 -translate-y-1/2 transform-gpu blur-2xl" aria-hidden="true">
                    <div class="aspect-[577/310] w-[36.0625rem] bg-gradient-to-r from-[#ff80b5] to-[#9089fc] opacity-30" style="clip-path: polygon(74.8% 41.9%, 97.2% 73.2%, 100% 34.9%, 92.5% 0.4%, 87.5% 0%, 75% 28.6%, 58.5% 54.6%, 50.1% 56.8%, 46.9% 44%, 48.3% 17.4%, 24.7% 53.9%, 0% 27.9%, 11.9% 74.2%, 24.9% 54.1%, 68.6% 100%, 74.8% 41.9%)"></div>
                </div>
                <div class="flex flex-wrap items-center gap-x-4 gap-y-2">
                    <p class="text-sm leading-6 text-gray-900">
                        <strong class="font-semibold">{{$banner->title}}</strong><svg viewBox="0 0 2 2" class="mx-2 inline h-0.5 w-0.5 fill-current" aria-hidden="true"><circle cx="1" cy="1" r="1" /></svg>{{$banner->content}}
                    </p>
                    <a href="#" class="flex-none rounded-full bg-{{$banner->color}}-900 px-3.5 py-1 text-sm font-semibold text-white shadow-sm hover:bg-{{$banner->color}}-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-900">Register now <span aria-hidden="true">&rarr;</span></a>
                </div>

            </div>
        @endforeach
    @endif


    <div class="text-center mt-5">
        <h1 class="text-4xl font-extrabold text-pink-500">Welcome to SnappFood</h1>
        <p class="mt-4 text-lg text-gray-600">Order your favorite food online!</p>
        <a href="{{ route('login') }}"
               class="mt-8 inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-pink-500 hover:bg-pink-600 focus:outline-none focus:shadow-outline-indigo active:bg-pink-700 transition duration-150 ease-in-out">Get
                Started</a>
        </div>
</x-guest-layout>
