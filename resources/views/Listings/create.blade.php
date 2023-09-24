<x-app-layout>
    <section class="text-gray-600 body-font overflow-hidden">
        <div class="w-full md:w-1/2 py-24 mx-auto">
            <div class="mb-4">
                <h2 class="text-2xl font-medium text-gray-900 title-font">
                    Create a new listing

                </h2>
            </div>
            <x-message></x-message>
            <form action="{{ route('listing.store') }}" id="payment-form" method="POST" enctype="multipart/form-data" class="bg-gray-600 p-4">
                @csrf
                <div class="flex mb-4">
                    <div class="flex-1 mx-2">
                        <x-input-label for="title" value="Job Title" />
                        <x-input
                            class="block mt-1 w-full"
                            id="title"
                            type="text"
                            name="title"
                            :value="old('title')"
                            required />
                    </div>
                </div>
                <div class="flex mb-4">
                    <div class="flex-1 mx-2">
                        <x-input-label for="company" value="Company Name" />
                        <x-input
                            class="block mt-1 w-full"
                            id="company"
                            type="text"
                            name="company"
                            :value="old('company')"
                            required />
                    </div>
                </div>
                <div class="flex mb-4">
                    <div class="flex-1 mx-2">
                        <x-input-label for="logo" value="Company Logo" />
                        <x-input
                            class="block mt-1 w-full"
                            id="logo"
                            type="file"
                            name="logo"
                            :value="old('logo')"
                             />
                    </div>
                </div>
                <div class="flex mb-4">
                    <div class="flex-1 mx-2">
                        <x-input-label for="location" value="Location: (e.g. Remote, Nigeria)" />
                        <x-input
                            class="block mt-1 w-full"
                            id="location"
                            type="text"
                            name="location"
                            :value="old('location')"
                            required />
                    </div>
                </div>
                <div class="flex mb-4">
                    <div class="flex-1 mx-2">
                        <x-input-label for="apply_link" value="Link to Apply" />
                        <x-input
                            class="block mt-1 w-full"
                            id="apply_link"
                            type="text"
                            name="apply_link"
                            :value="old('apply_link')"
                            required />
                    </div>
                </div>
                <div class="flex mb-4">
                    <div class="flex-1 mx-2">
                        <x-input-label for="tags" value="Tags (separate by comma eg: html,css,php)" />
                        <x-input
                            class="block mt-1 w-full"
                            id="tags"
                            type="text"
                            name="tags"
                            :value="old('tags')"
                            required />
                    </div>
                </div>
                <div class="flex mb-4">
                    <div class="flex-1 mx-2">
                        <x-input-label for="description" value="Job Descriptions and requirements" />
                        <textarea
                            class="block mt-1 w-full bg-white"
                            id="description"
                            type="text"
                            name="description"
                            :value="old('description')"
                            rows="8"
                            required ></textarea>
                    </div>
                </div>
                <div class="flex mb-4">
                    <div class="flex-1 mx-2">
                        <x-input-label for="is_highlighted"></x-input-label>
                        <x-input
                            class="rounded border-gray-300  text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-offset-0 focus:ring-indigo-200 focus:ring-opacity-50"
                            id="is_highlighted"
                            type="checkbox"
                            name="is_highlighted"
                            :value="old('is_highlighted')"
                            value="yes"
                            />
                            <span class="ml-2 text-white">Highlight this post </span>
                    </div>
                </div>
                <div class="mb-6 mx-2">

                </div>
                <div class="mb-2 mx-2">
                    <button type="submit" id="form_submit" class="block w-full items-center bg-indigo-500 text-white border-0 py-2 focus:outline-none hover:bg-indigo-600 rounded text-base mt-4 md:mt-0">Post</button>
                </div>
            </form>
        </div>
    </section>
    @section('scripts')

        <script>
            $(function(){
                $('#description').summernote({
                    height: 200,

                });


                // $('#content').summernote({
                //     placeholder: 'Hello stand alone ui',
                //     tabsize: 2,
                //     height: 120,
                //     toolbar: [
                //     ['style', ['style']],
                //     ['font', ['bold', 'underline', 'clear']],
                //     ['color', ['color']],
                //     ['para', ['ul', 'ol', 'paragraph']],
                //     ['table', ['table']],
                //     ['insert', ['link', 'picture', 'video']],
                //     ['view', ['fullscreen', 'codeview', 'help']]
                //     ]
                // });
            })
        </script>
    @endsection
</x-app-layout>

