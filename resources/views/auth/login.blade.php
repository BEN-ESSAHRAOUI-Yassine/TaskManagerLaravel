<x-guest-layout>

<div class="auth-container">

    <div class="auth-card">

        <h2 class="auth-title">Welcome Back</h2>
        <p class="auth-subtitle">Login to your dashboard</p>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="form-group">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="input" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="error" />
            </div>

            <!-- Password -->
            <div class="form-group">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="input" type="password" name="password" required />
                <x-input-error :messages="$errors->get('password')" class="error" />
            </div>

            <!-- Remember -->
            <div class="remember">
                <label>
                    <input type="checkbox" name="remember">
                    <span>Remember me</span>
                </label>
            </div>

            <!-- Actions -->
            <div class="auth-actions">

                @if (Route::has('password.request'))
                    <a class="link" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif

                <a class="btn primary" href="{{ route('register') }}">
                    Register
                </a>
                <button class="btn primary">
                    Log in
                </button>
            </div>

        </form>

    </div>

</div>

</x-guest-layout>