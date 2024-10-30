<x-app-layout>
    <div class="container mx-auto px-4">
        <x-card>
            <h2 class="text-2xl font-bold mb-6">Create New User</h2>

            @if ($errors->any())
                <x-alert type="error">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-alert>
            @endif

            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
                @csrf

                <x-input type="text" label="Name" name="name" required autofocus />

                <x-input type="email" label="Email Address" name="email" required />

                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium mb-1">Role</label>
                    <select 
                        id="role" 
                        name="role" 
                        required 
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200"
                    >
                        <option value="">Select Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role }}" {{ old('role') === $role ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $role)) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <x-input type="password" label="Password" name="password" required />
                <x-input type="password" label="Confirm Password" name="password_confirmation" required />

                <div class="flex items-center justify-end">
                    <x-button type="primary">Create User</x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
