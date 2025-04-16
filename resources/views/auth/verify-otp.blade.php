<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Sekolah Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-50">
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            <h2 class="mt-4 text-3xl font-extrabold text-gray-900">{{ __('Verifikasi OTP') }}</h2>
            <p class="mt-2 text-sm text-gray-600">
                Masukkan kode verifikasi untuk melanjutkan
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow-lg sm:rounded-lg sm:px-10 border border-gray-200">
            @if (session('success'))
                <div class="rounded-md bg-green-50 p-4 mb-6 border border-green-200" 
                     x-data="{ show: true }" 
                     x-show="show" 
                     x-init="setTimeout(() => show = false, 5000)"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                        <div class="ml-auto pl-3">
                            <div class="-mx-1.5 -my-1.5">
                                <button @click="show = false" class="inline-flex rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <span class="sr-only">Dismiss</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-blue-50 rounded-lg p-4 mb-6 border border-blue-100">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            Kode OTP telah dikirim ke email <strong>{{ $email }}</strong>. Silahkan periksa email Anda dan masukkan kode OTP di bawah ini.
                        </p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('school.verify.otp') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">

                <div x-data="otpInput()" class="space-y-2">
                    <label for="otp" class="block text-sm font-medium text-gray-700">{{ __('Kode OTP') }}</label>
                    
                    <div class="flex justify-center space-x-2">
                        <template x-for="(digit, index) in digits" :key="index">
                            <input 
                                type="text" 
                                maxlength="1" 
                                x-model="digit" 
                                @input="onInput($event, index)"
                                @keydown="onKeyDown($event, index)"
                                @paste="onPaste($event)"
                                class="w-12 h-12 text-center text-xl font-semibold border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                :class="{'border-red-500': error}"
                            >
                        </template>
                    </div>
                    
                    <input id="otp" type="hidden" name="otp" x-model="otpValue" class="@error('otp') is-invalid @enderror">
                    
                    @error('otp')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    
                    <div x-show="error" class="mt-2 text-sm text-red-600" x-text="errorMessage"></div>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        {{ __('Verifikasi') }}
                    </button>
                </div>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="flex items-center justify-center" x-data="{ countdown: 60, canResend: false }" x-init="
                    setInterval(() => {
                        if (countdown > 0) {
                            countdown--;
                        } else {
                            canResend = true;
                        }
                    }, 1000);
                ">
                    <div class="text-sm text-center">
                        <p class="text-gray-600 mb-2">Tidak menerima kode OTP?</p>
                        
                        <template x-if="!canResend">
                            <div class="text-gray-500">
                                Kirim ulang tersedia dalam <span class="font-medium text-blue-600" x-text="countdown"></span> detik
                            </div>
                        </template>
                        
                        <template x-if="canResend">
                            <form method="POST" action="{{ route('school.resend.otp') }}">
                                @csrf
                                <input type="hidden" name="email" value="{{ $email }}">
                                <button type="submit" class="font-medium text-blue-600 hover:text-blue-500 focus:outline-none focus:underline transition-colors" @click="countdown = 60; canResend = false;">
                                    Kirim Ulang Kode OTP
                                </button>
                            </form>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- OTP Expiry Timer -->
    <div class="mt-6 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-4 px-4 shadow-sm sm:rounded-lg sm:px-10 border border-gray-200" x-data="{ 
            expiryTime: 300,
            minutes: 0,
            seconds: 0,
            timer: null,
            init() {
                this.startTimer();
                this.timer = setInterval(() => {
                    this.startTimer();
                }, 1000);
            },
            startTimer() {
                if (this.expiryTime > 0) {
                    this.expiryTime--;
                    this.minutes = Math.floor(this.expiryTime / 60);
                    this.seconds = this.expiryTime % 60;
                } else {
                    clearInterval(this.timer);
                }
            }
        }">
            <div class="flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-sm text-gray-600">
                    Kode OTP akan kedaluwarsa dalam 
                    <span class="font-medium" x-text="minutes < 10 ? '0' + minutes : minutes"></span>:<span class="font-medium" x-text="seconds < 10 ? '0' + seconds : seconds"></span>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    function otpInput() {
        return {
            digits: ['', '', '', '', '', ''],
            error: false,
            errorMessage: '',
            
            get otpValue() {
                return this.digits.join('');
            },
            
            onInput(event, index) {
                const input = event.target;
                const value = input.value;
                const nextInput = input.nextElementSibling;
                
                // Clear any previous errors
                this.error = false;
                
                // Allow only numbers
                if (!/^\d*$/.test(value)) {
                    this.digits[index] = '';
                    this.error = true;
                    this.errorMessage = 'Hanya angka yang diperbolehkan';
                    return;
                }
                
                // Auto-focus next input
                if (value !== '' && nextInput) {
                    nextInput.focus();
                }
            },
            
            onKeyDown(event, index) {
                const input = event.target;
                const prevInput = input.previousElementSibling;
                
                // Handle backspace
                if (event.key === 'Backspace') {
                    if (this.digits[index] === '' && prevInput) {
                        prevInput.focus();
                    }
                }
            },
            
            onPaste(event) {
                event.preventDefault();
                
                const pastedData = (event.clipboardData || window.clipboardData).getData('text');
                if (!/^\d+$/.test(pastedData)) {
                    this.error = true;
                    this.errorMessage = 'Hanya angka yang diperbolehkan';
                    return;
                }
                
                const otpLength = Math.min(pastedData.length, 6);
                for (let i = 0; i < otpLength; i++) {
                    this.digits[i] = pastedData[i];
                }
                
                // Focus the next empty input or the last one
                const inputs = event.target.parentNode.querySelectorAll('input');
                const nextEmptyIndex = this.digits.findIndex(digit => digit === '');
                
                if (nextEmptyIndex !== -1 && nextEmptyIndex < 6) {
                    inputs[nextEmptyIndex].focus();
                } else {
                    inputs[5].focus();
                }
            }
        };
    }
</script>
</body>
</html>