<!-- resources/views/posts/create.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create a New Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="post" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div>
                            <x-input-label for="body" :value="__('Body')" />
                            <x-textarea-input id="body" name="body" class="mt-1 block w-full" :value="old('body')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('body')" />
                        </div>

                        <div>
                            <x-input-label for="photo" :value="__('Photo')" />
                            <x-file-input id="photo" name="photo" class="block" accept="image/*" />
                            <x-input-error class="ml-2" :messages="$errors->get('photo')" />
                        </div>



                        <div class="flex items-center gap-4 mt-4">
                            <x-primary-button>{{ __('Post') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
