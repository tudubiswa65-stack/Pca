@extends('layouts.public')

@section('title', 'Login - Padmabati Computer Academy')

@section('content')
<div class="w-full max-w-md mx-auto">
    <div class="bg-white rounded-2xl shadow-2xl p-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="bg-gradient-to-r from-amber-500 to-orange-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-graduation-cap text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-navy-900 mb-2">Welcome Back</h1>
            <p class="text-gray-600">Sign in to your PCA account</p>
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" x-data="loginForm()">
            @csrf
            
            <!-- Email/Phone Field -->
            <div class="mb-6">
                <label for="credential" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-user mr-1"></i>
                    Email or Phone Number
                </label>
                <input 
                    type="text" 
                    id="credential" 
                    name="credential" 
                    value="{{ old('credential') }}"
                    x-model="credential"
                    @input="validateCredential()"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent transition duration-200"
                    placeholder="Enter your email or phone number"
                    required
                >
                @error('credential')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p x-show="credentialError" x-text="credentialError" class="text-red-500 text-sm mt-1"></p>
            </div>

            <!-- Password Field -->
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-lock mr-1"></i>
                    Password
                </label>
                <div class="relative">
                    <input 
                        :type="showPassword ? 'text' : 'password'"
                        id="password" 
                        name="password"
                        x-model="password"
                        @input="validatePassword()"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent transition duration-200 pr-12"
                        placeholder="Enter your password"
                        required
                    >
                    <button 
                        type="button" 
                        @click="showPassword = !showPassword"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700"
                    >
                        <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p x-show="passwordError" x-text="passwordError" class="text-red-500 text-sm mt-1"></p>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
                <a href="{{ route('password.request') }}" class="text-sm text-amber-600 hover:text-amber-700">
                    Forgot password?
                </a>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                :disabled="!isValid"
                class="w-full bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold py-3 px-4 rounded-xl hover:from-amber-600 hover:to-orange-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                x-text="'Sign In'"
            >
            </button>
        </form>

        <!-- Divider -->
        <div class="my-6 flex items-center">
            <div class="flex-1 border-t border-gray-300"></div>
            <span class="px-4 text-gray-500 text-sm">New to PCA?</span>
            <div class="flex-1 border-t border-gray-300"></div>
        </div>

        <!-- Register Link -->
        <a href="{{ route('register') }}" class="w-full block text-center bg-teal-600 text-white font-semibold py-3 px-4 rounded-xl hover:bg-teal-700 transition duration-200">
            Create an Account
        </a>
    </div>
</div>

<script>
function loginForm() {
    return {
        credential: '',
        password: '',
        showPassword: false,
        credentialError: '',
        passwordError: '',
        
        get isValid() {
            return this.credential.length > 0 && this.password.length > 0 && 
                   !this.credentialError && !this.passwordError;
        },
        
        validateCredential() {
            this.credentialError = '';
            if (this.credential.length === 0) return;
            
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const phonePattern = /^[6-9][0-9]{9}$/;
            
            if (!emailPattern.test(this.credential) && !phonePattern.test(this.credential)) {
                this.credentialError = 'Please enter a valid email or 10-digit phone number';
            }
        },
        
        validatePassword() {
            this.passwordError = '';
            if (this.password.length > 0 && this.password.length < 8) {
                this.passwordError = 'Password must be at least 8 characters';
            }
        }
    }
}
</script>
@endsection