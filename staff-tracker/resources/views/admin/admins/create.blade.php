<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Admin') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <x-card>
            <form method="POST" action="{{ route('admin.admins.store') }}">
                @csrf

                <!-- Name -->
                <div class="mb-4">
                    <x-label for="name" :value="__('Name')" />

                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ old('name') }}" required autofocus />
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <x-label for="email" :value="__('Email')" />

                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ old('email') }}" required />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <x-label for="password" :value="__('Password')" />

                    <x-input id="password" class="block mt-1 w-full"
                             type="password"
                             name="password"
                             required autocomplete="new-password" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <x-label for="password_confirmation" :value="__('Confirm Password')" />

                    <x-input id="password_confirmation" class="block mt-1 w-full"
                             type="password"
                             name="password_confirmation" required />
                </div>

                <!-- Active Status -->
                <div class="mb-4 flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="mr-2">
                    <x-label for="is_active" :value="__('Active')" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-button type="primary">
                        {{ __('Create Admin') }}
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
