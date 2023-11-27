<!-- Dans votre vue profile.edit.blade.php -->

<x-app-layout>
    <!-- ... -->

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Formulaire de modification de profil -->
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <!-- Champs du formulaire (nom, photo de profil, bio, etc.) -->

                    <x-primary-button>
                        {{ __('Update Profile') }}
                    </x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
