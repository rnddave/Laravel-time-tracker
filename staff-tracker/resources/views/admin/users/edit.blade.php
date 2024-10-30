<x-app-layout>
    <div class="container mx-auto px-4">
        <x-card>
            <h2 class="text-2xl font-bold mb-6">Edit User</h2>

            @if ($errors->any())
                <x-alert type="error">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-alert>
            @endif

            <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <x-input type="text" label="Name" name="name" :value="$user->name" required autofocus />

                <x-input type="email" label="Email Address" name="email" :value="$user->email" required />

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
                            <option value="{{ $role }}" {{ (old('role', $user->role) === $role) ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $role)) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <hr class="my-6 border-gray-200 dark:border-gray-700">

                <h4 class="text-lg font-semibold mb-4">Change Password</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">Leave blank if you don't want to change the password.</p>

                <x-input type="password" label="New Password" name="password" />
                <x-input type="password" label="Confirm New Password" name="password_confirmation" />

                <div class="flex items-center justify-between">
                    <x-button type="primary">Update User</x-button>
                    <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                        Cancel
                    </a>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
