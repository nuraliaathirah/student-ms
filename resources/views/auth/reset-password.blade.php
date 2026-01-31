<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Change Password') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    {{-- Success Message --}}
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-300 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Password Change Form --}}
                    <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                Password requirements:
                            </p>
                            <ul class="list-disc list-inside text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                <li>At least 8 characters long</li>
                                <li>Contains both uppercase and lowercase letters</li>
                                <li>Contains at least one number</li>
                                <li>Contains at least one symbol (!@#$%^&*)</li>
                                <li>Not a commonly used password</li>
                            </ul>
                        </div>

                        <!-- Current Password -->
                        <div>
                            <x-input-label for="current_password" :value="__('Current Password')" />
                            <x-text-input 
                                id="current_password" 
                                name="current_password" 
                                type="password" 
                                class="mt-1 block w-full" 
                                required 
                                autocomplete="current-password" 
                            />
                            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
                        </div>

                        <!-- New Password -->
                        <div>
                            <x-input-label for="password" :value="__('New Password')" />
                            <x-text-input 
                                id="password" 
                                name="password" 
                                type="password" 
                                class="mt-1 block w-full" 
                                required 
                                autocomplete="new-password" 
                            />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirm New Password')" />
                            <x-text-input 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                type="password" 
                                class="mt-1 block w-full" 
                                required 
                                autocomplete="new-password" 
                            />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Please re-enter your new password to confirm
                            </p>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>
                                {{ __('Update Password') }}
                            </x-primary-button>

                            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                Cancel
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>