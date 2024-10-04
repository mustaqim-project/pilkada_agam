<x-guest-layout>

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Flatpickr JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Tanggal Lahir -->
        <div class="mt-4">
            <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
            <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="text" name="tanggal_lahir" :value="old('tanggal_lahir')" required autocomplete="bday" placeholder="dd-mm-yyyy" />
            <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
        </div>

        <!-- Tinggi Badan -->
        <div class="mt-4">
            <x-input-label for="tinggi_badan" :value="__('Tinggi Badan (cm)')" />
            <x-text-input id="tinggi_badan" class="block mt-1 w-full" type="number" name="tinggi_badan" :value="old('tinggi_badan')" required autocomplete="height" />
            <x-input-error :messages="$errors->get('tinggi_badan')" class="mt-2" />
        </div>

        <!-- Berat Badan -->
        <div class="mt-4">
            <x-input-label for="berat_badan" :value="__('Berat Badan (kg)')" />
            <x-text-input id="berat_badan" class="block mt-1 w-full" type="number" name="berat_badan" :value="old('berat_badan')" required autocomplete="weight" />
            <x-input-error :messages="$errors->get('berat_badan')" class="mt-2" />
        </div>

        <!-- Jenis Kelamin -->
        <div class="mt-4">
            <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
            <select id="jenis_kelamin" name="jenis_kelamin" class="block mt-1 w-full" required>
                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>{{ __('Laki-laki') }}</option>
                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>{{ __('Perempuan') }}</option>
            </select>
            <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
        </div>

        <!-- Aktifitas -->
        <div class="mt-4">
            <x-input-label for="aktifitas_id" :value="__('Pilih Aktifitas')" />
            <select id="aktifitas_id" name="aktifitas_id" class="block mt-1 w-full">
                <option value="">{{ __('Pilih Aktifitas') }}</option>
                @foreach($aktifitas as $id => $nama)
                    <option value="{{ $id }}" {{ old('aktifitas_id') == $id ? 'selected' : '' }}>{{ $nama }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('aktifitas_id')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Profile Picture Upload -->
        <div class="mt-4">
            <x-input-label for="profile_picture" :value="__('Profile Picture')" />
            <input type="file" id="profile_picture" name="profile_picture" accept="image/*" class="block mt-1 w-full" />
            <x-input-error :messages="$errors->get('profile_picture')" class="mt-2" />
        </div>

        <!-- Image Preview -->
        <div class="mt-4">
            <img id="image_preview" src="#" alt="Image Preview" style="display:none; width:200px; height:auto;" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            flatpickr("#tanggal_lahir", {
                dateFormat: "d-m-Y",  // Format dd-mm-yyyy
                altInput: true,       // Show formatted date in input
                altFormat: "d-m-Y",   // Display format
                allowInput: true      // Allow manual input
            });

            // Handle image preview
            const profilePictureInput = document.getElementById('profile_picture');
            const imagePreview = document.getElementById('image_preview');

            profilePictureInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.src = '#';
                    imagePreview.style.display = 'none';
                }
            });
        });
    </script>

</x-guest-layout>
