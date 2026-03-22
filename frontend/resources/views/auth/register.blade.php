@extends('layouts.public')

@section('title', 'Register - Padmabati Computer Academy')

@section('content')
<div class="w-full max-w-md mx-auto">
    <div class="bg-white rounded-2xl shadow-2xl p-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="bg-gradient-to-r from-teal-500 to-cyan-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-user-plus text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-navy-900 mb-2">Join PCA</h1>
            <p class="text-gray-600">Create your student account</p>
        </div>

        <!-- Registration Form -->
        <form method="POST" action="{{ route('register') }}" x-data="registerForm()">
            @csrf
            
            <!-- Name Field -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-user mr-1"></i>
                    Full Name *
                </label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}"
                    x-model="name"
                    @input="validateName()"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent transition duration-200"
                    placeholder="Enter your full name"
                    required
                >
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p x-show="nameError" x-text="nameError" class="text-red-500 text-sm mt-1"></p>
            </div>

            <!-- Phone Field -->
            <div class="mb-6">
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-phone mr-1"></i>
                    Phone Number *
                </label>
                <input 
                    type="tel" 
                    id="phone" 
                    name="phone" 
                    value="{{ old('phone') }}"
                    x-model="phone"
                    @input="validatePhone()"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent transition duration-200"
                    placeholder="Enter 10-digit phone number"
                    maxlength="10"
                    required
                >
                @error('phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p x-show="phoneError" x-text="phoneError" class="text-red-500 text-sm mt-1"></p>
                <p x-show="phoneSuccess" class="text-teal-600 text-sm mt-1">
                    <i class="fas fa-check mr-1"></i>
                    Valid phone number
                </p>
            </div>

            <!-- Email Field -->
            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-envelope mr-1"></i>
                    Email Address (optional)
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    x-model="email"
                    @input="validateEmail()"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent transition duration-200"
                    placeholder="Enter your email (optional)"
                >
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p x-show="emailError" x-text="emailError" class="text-red-500 text-sm mt-1"></p>
            </div>

            <!-- Password Field -->
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-lock mr-1"></i>
                    Password *
                </label>
                <div class="relative">
                    <input 
                        :type="showPassword ? 'text' : 'password'"
                        id="password" 
                        name="password"
                        x-model="password"
                        @input="validatePassword()"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent transition duration-200 pr-12"
                        placeholder="Enter a strong password"
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
                <div x-show="password.length > 0" class="mt-2 space-y-1">
                    <div class="flex items-center text-xs">
                        <i :class="password.length >= 8 ? 'fas fa-check text-teal-600' : 'fas fa-times text-red-500'" class="mr-1"></i>
                        <span :class="password.length >= 8 ? 'text-teal-600' : 'text-red-500'">At least 8 characters</span>
                    </div>
                </div>
            </div>

            <!-- Confirm Password Field -->
            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-lock mr-1"></i>
                    Confirm Password *
                </label>
                <div class="relative">
                    <input 
                        :type="showConfirmPassword ? 'text' : 'password'"
                        id="password_confirmation" 
                        name="password_confirmation"
                        x-model="passwordConfirmation"
                        @input="validatePasswordConfirmation()"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent transition duration-200 pr-12"
                        placeholder="Confirm your password"
                        required
                    >
                    <button 
                        type="button" 
                        @click="showConfirmPassword = !showConfirmPassword"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700"
                    >
                        <i :class="showConfirmPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                    </button>
                </div>
                @error('password_confirmation')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p x-show="passwordConfirmationError" x-text="passwordConfirmationError" class="text-red-500 text-sm mt-1"></p>
                <p x-show="passwordConfirmation.length > 0 && password === passwordConfirmation" class="text-teal-600 text-sm mt-1">
                    <i class="fas fa-check mr-1"></i>
                    Passwords match
                </p>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                :disabled="!isValid"
                class="w-full bg-gradient-to-r from-teal-500 to-cyan-500 text-white font-semibold py-3 px-4 rounded-xl hover:from-teal-600 hover:to-cyan-600 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
            >
                <span x-show="!loading">Create Account</span>
                <span x-show="loading" class="flex items-center justify-center">
                    <i class="fas fa-spinner fa-spin mr-2"></i>
                    Creating Account...
                </span>
            </button>
        </form>

        <!-- Divider -->
        <div class="my-6 flex items-center">
            <div class="flex-1 border-t border-gray-300"></div>
            <span class="px-4 text-gray-500 text-sm">Already have an account?</span>
            <div class="flex-1 border-t border-gray-300"></div>
        </div>

        <!-- Login Link -->
        <a href="{{ route('login') }}" class="w-full block text-center bg-amber-500 text-white font-semibold py-3 px-4 rounded-xl hover:bg-amber-600 transition duration-200">
            Sign In
        </a>
    </div>
</div>

<script>
function registerForm() {
    return {
        name: '',
        phone: '',
        email: '',
        password: '',
        passwordConfirmation: '',
        showPassword: false,
        showConfirmPassword: false,
        loading: false,
        nameError: '',
        phoneError: '',
        phoneSuccess: false,
        emailError: '',
        passwordError: '',
        passwordConfirmationError: '',
        
        get isValid() {
            return this.name.length > 0 && 
                   this.phoneSuccess && 
                   this.password.length >= 8 && 
                   this.password === this.passwordConfirmation &&
                   !this.nameError && !this.phoneError && !this.emailError && 
                   !this.passwordError && !this.passwordConfirmationError;
        },
        
        validateName() {
            this.nameError = '';
            if (this.name.length > 0) {
                const namePattern = /^[\p{L} .]+$/u;
                if (!namePattern.test(this.name)) {
                    this.nameError = 'Name can only contain letters, spaces, and dots';
                } else if (this.name.length > 100) {
                    this.nameError = 'Name cannot exceed 100 characters';
                }
            }
        },
        
        validatePhone() {
            this.phoneError = '';
            this.phoneSuccess = false;
            if (this.phone.length > 0) {
                const phonePattern = /^[6-9][0-9]{9}$/;
                if (!phonePattern.test(this.phone)) {
                    this.phoneError = 'Enter a valid 10-digit phone number starting with 6-9';
                } else {
                    this.phoneSuccess = true;
                }
            }
        },
        
        validateEmail() {
            this.emailError = '';
            if (this.email.length > 0) {
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(this.email)) {
                    this.emailError = 'Please enter a valid email address';
                }
            }
        },
        
        validatePassword() {
            this.passwordError = '';
            if (this.password.length > 0 && this.password.length < 8) {
                this.passwordError = 'Password must be at least 8 characters';
            }
            this.validatePasswordConfirmation();
        },
        
        validatePasswordConfirmation() {
            this.passwordConfirmationError = '';
            if (this.passwordConfirmation.length > 0 && this.password !== this.passwordConfirmation) {
                this.passwordConfirmationError = 'Passwords do not match';
            }
        }
    }
}
</script>
@endsection