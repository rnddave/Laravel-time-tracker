@push('scripts')
    <script src="//unpkg.com/alpinejs" defer></script>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New User') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <x-card>
            <form method="POST" action="{{ route('admin.users.store') }}" x-data="userForm()" x-init="init()">
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

                <!-- Role -->
                <div class="mb-4">
                    <x-label for="role" :value="__('Role')" />

                    <select id="role" name="role" class="block mt-1 w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200">
                        <option value="team_member" {{ old('role', 'team_member') === 'team_member' ? 'selected' : '' }}>Team Member</option>
                        <option value="manager" {{ old('role') === 'manager' ? 'selected' : '' }}>Manager</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                <!-- Department and Team Selection with Alpine.js -->
                <div class="mb-4">
                    <!-- Department -->
                    <div class="mb-4">
                        <x-label for="department_id" :value="__('Department')" />

                        <select id="department_id" name="department_id" x-model="selectedDepartment" @change="fetchTeams()" class="block mt-1 w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200">
                            <option value="">-- Select Department --</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Team -->
                    <div class="mb-4">
                        <x-label for="team_id" :value="__('Team')" />

                        <select id="team_id" name="team_id" x-model="selectedTeam" class="block mt-1 w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200">
                            <option value="">-- Select Team --</option>
                            <template x-for="team in teams" :key="team.id">
                                <option :value="team.id" x-text="team.name"></option>
                            </template>
                        </select>
                    </div>
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
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="mr-2">
                    <x-label for="is_active" :value="__('Active')" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-button type="primary">
                        {{ __('Create User') }}
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>

    <script>
        function userForm() {
            return {
                selectedDepartment: '{{ old('department_id') }}',
                selectedTeam: '{{ old('team_id') }}',
                teams: [],

                init() {
                    if (this.selectedDepartment) {
                        this.fetchTeams();
                    }
                },

                fetchTeams() {
                    if (this.selectedDepartment) {
                        fetch(`/admin/departments/${this.selectedDepartment}/teams`)
                            .then(response => response.json())
                            .then(data => {
                                this.teams = data.teams;
                                // Reset team selection if team doesn't belong to new department
                                if (!this.teams.some(team => team.id == this.selectedTeam)) {
                                    this.selectedTeam = '';
                                }
                            })
                            .catch(error => {
                                console.error('Error fetching teams:', error);
                            });
                    } else {
                        this.teams = [];
                        this.selectedTeam = '';
                    }
                }
            }
        }
    </script>
</x-app-layout>
