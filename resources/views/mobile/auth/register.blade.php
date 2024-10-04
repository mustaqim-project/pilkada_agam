@extends('mobile.frontend.layout.master')

@section('content')
<style>
    .btn-full {
        display: inline-block;
        width: 100%;
        padding: 0.75rem 1.5rem;
        /* Padding atas/bawah dan kiri/kanan */
        border: none;
        border-radius: 0.375rem;
        /* Radius sudut */
        font-size: 1rem;
        font-weight: bold;
        color: #fff;
        /* Warna teks putih */
        background-color: #007bff;
        /* Ganti dengan warna latar belakang sesuai kebutuhan */
        text-align: center;
        cursor: pointer;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-highlight {
        background-color: #28a745;
        /* Ganti dengan warna latar belakang highlight */
    }

    .btn-full:hover {
        background-color: #0056b3;
        /* Ganti dengan warna latar belakang saat hover */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        /* Bayangan saat hover */
    }

    .btn-full:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.5);
        /* Bayangan fokus */
    }

</style>

<div class="page-content">
    <div class="page-title page-title-small">
        <h2><a href="#" data-back-button><i class="fa fa-arrow-left"></i></a>Sign Up</h2>
        {{-- <a href="#" data-menu="menu-main" class="bg-fade-gray1-dark shadow-xl preload-img"
        data-src="{{ asset('mobile/images/logobulat.png') }}"> --}}
        </a>
    </div>
    <div class="card header-card shape-rounded" data-card-height="150">
        <div class="card-overlay bg-highlight opacity-95"></div>
        <div class="card-overlay dark-mode-tint"></div>
    </div>

    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <div class="card card-style">
            <div class="content mb-0 mt-1">
                <!-- Name -->
                <div class="input-style has-icon input-style-1 input-required">
                    <i class="input-icon fa fa-user color-theme"></i>
                    <span>Name</span>
                    <x-text-input id="name" class="input" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>


                <!-- Email Address -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <i class="input-icon fa fa-at color-theme"></i>
                    <span>Email</span>
                    <x-text-input id="email" class="input" type="email" name="email" :value="old('email')" required autocomplete="email" placeholder="Email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>


                <!-- Password -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <i class="input-icon fa fa-lock color-theme"></i>
                    <span>Password</span>
                    <x-text-input id="password" class="input" type="password" name="password" required autocomplete="new-password" placeholder="Choose a Password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="input-style has-icon input-style-1 input-required mb-4">
                    <i class="input-icon fa fa-lock color-theme"></i>
                    <span>Confirm Password</span>
                    <x-text-input id="password_confirmation" class="input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your Password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-m btn-full rounded-sm shadow-l bg-green1-dark text-uppercase font-900">
                    Create Account
                </button>

                <!-- Divider -->
                <div class="divider"></div>

                <!-- Sign-in Link -->
                <p class="text-center">
                    <a href="{{ route('login') }}" class="color-highlight opacity-80 font-12">Already Registered? Sign
                        in
                        Here</a>
                </p>

            </div>
        </div>
    </form>
</div>
@endsection
