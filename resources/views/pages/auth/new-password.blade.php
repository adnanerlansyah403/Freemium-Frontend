@extends("homepage")

@section("title", "New Password - Freemium App")

{{-- Title Section --}}
{{-- <div x-data="user" x-init="checkSession()">
    <template x-if="!isLogedIn">
        <script>
            document.title = 'Register - Freemium App';
        </script>
    </template>
</div> --}}

@section("content")

<section class="pt-[140px] pb-[100px] dark:text-white" x-data="auth"
>
<div x-init="checkAlreadyAuth()"></div>

<div x-init="flash()"></div>
<div x-show="showFlash" x-init="setTimeout(() => {
  showFlash = false
  }, 4000);
">
    <x-alert />
</div>

<div x-show="isLoadingAuth" class="flex justify-center px-32 py-4">
    <x-loading-page />
</div>

<template x-if="!isLoadingAuth">
    <div class="container mx-auto flex items-start justify-center">

        <div class="col col-12 md:col-6 lg:col-6 py-6 px-4 border border-gray-third bg-white dark:bg-slate-secondary rounded-primary lg:flex flex-col items-center">

            <div class="mb-8 text-center">
                <h1 class="text-[32px]">
                    <span class="span dark:text-slate-fourth font-medium">Make a</span>
                    New Password
                </h1>
                <p class="mt-2 mb-4 text-[14px] text-gray-primary dark:text-white">Please enter your new password, and the password will be changed </p>
            </div>
        
            <div class="w-full" x-data="{passwordHidden: true}">
                <label for="password" class="text-md">New Password</label>
                <div class="group flex items-center gap-4 pl-4 pr-3 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] bg-white hover:bg-white dark:bg-slate-secondary dark:text-white dark:shadow-none dark:border dark:border-white rounded-primary mt-4 transition duration-200 ease-in-out" x-bind:class="status_err.password ? 'border border-[#b91c1c]' : ''">
                    <button type="button" @click="
                    typePassword = passwordHidden == true ? 'text' : 'password';
                    $refs.password.setAttribute('type', typePassword)
                    passwordHidden = !passwordHidden;
                    ">
                        <template x-if="passwordHidden == true">
                            <span>
                                <i data-feather="lock" class="group-hover:text-primary dark:group-hover:text-white w-6 h-6 text-gray-secondary transition duration-200 ease-in-out"></i>
                                <script>
                                    feather.replace()
                                </script>
                            </span>
                        </template>
                        <template x-if="passwordHidden == false">
                            <span>
                                <i data-feather="unlock" class="group-hover:text-primary dark:group-hover:text-white w-6 h-6 text-gray-secondary transition duration-200 ease-in-out"
                                ></i>
                                <script>
                                    feather.replace()
                                </script>
                            </span>
                        </template>
                    </button>
                    <input type="password" placeholder="Your password..."
                    x-bind:class="status_err.password ? 'input-danger' : ''" class="w-full border-none" x-model="password" x-ref="password">
                </div>
                <template x-if="status_err.password">
                    <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                        <span class="span-danger" x-text="status_err.password[0]">Validasi Error</span>
                    </div>
                </template>
                <div class="flex items-center justify-center mt-6">
                    <button type="submit"
                        class="px-4 py-2 rounded-pill bg-primary dark:bg-slate-third text-white dark:hover:text-opacity-80 text-center hover:text-opacity-90 transition duration-200 ease-in-out" @click="newPassword({{Request::segment(2)}})">
                        Confirm
                    </button>
                </div>
            </div>


        </div>
        
    </div>
</template>

</section>

@endsection