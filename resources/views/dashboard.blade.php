<x-app-layout>
   <section class="text-gray-600 body-font overflow-hidden">
    <div class="container px-5 py-12 mx-auto">
        <div class="mb-12">
            <h2 class="text-2xl font-medium text-gray-900 title-font px-4">
                Your Listings ({{ $listings->count() }})
            </h2>
        </div>
        @foreach ($listings as $listing)
        <a href="{{ route('listing.show', $listing->slug) }}"
            class="py-6 px-4 flex flex-wrap md:flex-nowrap border-b border-gray-100 {{ $listing->is_highlighted ? 'bg-yellow-100 hover:bg-yellow-200': 'bg-white hover:bg-gray-100' }}"
        >
            <div class="md:w-16 md:mb-0 mb-6 mr-4 flex-shrink-0 flex flex-col">
                <img src="{{ asset('storage/logos/'. $listing->logo) }}" alt="{{ $listing->company }}" class="w-16 h-16 rounded-full object-cover">
            </div>
            
            <div class="md:w-1/2 mr-8 flex-col items-start justify-center">
                <h2 class="text-xl font-bold text-gray-900 title-font mb-1">{{ $listing->title }}</h2>
                <p class="leading-relaxed text-gray-900">
                    {{ $listing->company }} &mdash; <span class="text-gray600">{{ $listing->location }}</span>
                </p>
            </div>
            
            <div class="md:flex-grow mr-8 flex items-center justify-start">
                @foreach ($listing->tags as $tag)
                    <span class="inline-block ml-2 tracking-wide text-xs font-medium title-font py-1 px-2 mb-2 border text-gray-900 border-indigo-500 rounded-md uppercase {{ $tag->slug === request()->tag ? ' bg-indigo-500 text-white' : 'bg-white text-indigo-500' }}">
                            {{ $tag->name }}
                    </span>
                @endforeach
            </div>
            <span class="md:flex-grow flex flex-col items-end justify-center">
                <span>{{ $listing->created_at->diffForHumans() }}</span>
                <span><strong class="text-bold">{{ $listing->clicks()->count() }}</strong> Apply Btn Clicks</span>
            </span>
        </a>
        @endforeach
    </div>
   </section>
</x-app-layout>
