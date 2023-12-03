
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create a New Post') }}
        </h2>
    </x-slot>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-2 border-black">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="post" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="body" :value="__('Body')" />
                            <x-textarea-input id="body" name="body" class="mt-1 block w-full" :value="old('body')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('body')" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="img_path" :value="__('Photo')" />
                            <x-file-input id="img_path" name="img_path" class="block" accept="image/*" />
                            <x-input-error class="ml-2" :messages="$errors->get('img_path')" />
                        </div>

                        <div class="flex items-center gap-4 mt-4">
                            <x-primary-button>{{ __('Post') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <a href="{{ route('homepage') }}" class="bg-red-700 text-white px-4 py-2 rounded-md transition-transform hover:scale-105 focus:outline-none focus:ring focus:border-custom-focus-color duration-300 inline-block mb-4 ml-2 border-2 border-black">
        Retour à la liste des posts
    </a>
</x-app-layout>
