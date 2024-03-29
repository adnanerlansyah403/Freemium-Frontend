@extends("homepage")

@section("title", "Login - Freemium App")

{{-- Title Section --}}
{{-- <div x-data="user" x-init="checkSession()">
    <template x-if="!isLogedIn">
        <script>
            document.title = 'Login - Freemium App';
        </script>
    </template>
</div> --}}


@section("content")

<section class="pt-[140px] pb-[100px] dark:text-white" x-data="auth">
    <div x-init="checkAlreadyAuth()"></div>
    {{-- alert --}}
    <div x-init="flash()"></div>
    <div x-show="showFlash">
        <x-alert />
    </div>

    <div x-show="isLoadingAuth" class="flex justify-center px-32 py-4">
        <x-loading-page />
    </div>
    <template x-if="!isLoadingAuth">
        <div class="container mx-auto flex items-start">
    
            <div class="col col-12 lg:col-6">
                <form x-on:submit.prevent="fetchLogin()">
                    <div class="mb-5">
                        <label for="email" class="text-md">Email</label>
                        <div class="flex items-center gap-4 pl-4 pr-3 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] bg-white hover:bg-white dark:bg-slate-secondary rounded-primary mt-4" x-bind:class="status_err?.email || status_err?.email?.[0] ? 'border border-[#b91c1c]' : ''">
                            <i data-feather="mail" class="w-6 h-6 text-gray-secondary"></i>
                            <input type="text" placeholder="Your email..."
                                class="w-full" x-model="email">
                        </div>
                        <template x-if="status_err?.email">
                            <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                <span class="span-danger" x-text="status_err.email[0]">Validasi Error</span>
                            </div>
                        </template>
                    </div>
        
                    <div class="mb-8" x-data="{passwordHidden: true}">
                        <label for="password" class="text-md">Password</label>
                        <div class="group flex items-center gap-4 pl-4 pr-3 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] bg-white hover:bg-white dark:bg-slate-secondary rounded-primary mt-4 transition duration-200 ease-in-out" x-bind:class="status_err?.password || status_err?.password?.[0] ? 'border border-[#b91c1c]' : ''">
                            <span>
                                <i data-feather="lock" class="w-6 h-6 text-gray-secondary transition duration-200 ease-in-out"></i>
                                <script>
                                    feather.replace()
                                </script>
                            </span>
                            <input type="password" placeholder="Your password..."
                            class="w-full" x-model="password" x-ref="password">
                            <button type="button" title="show password" @click="
                            typePassword = passwordHidden == true ? 'text' : 'password';
                            $refs.password.setAttribute('type', typePassword)
                            passwordHidden = !passwordHidden;
                            ">
                                <span x-show="passwordHidden">
                                    <i data-feather="eye" class="group-hover:text-primary dark:group-hover:text-white w-6 h-6 text-gray-secondary transition duration-200 ease-in-out"
                                    ></i>
                                    <script>
                                        feather.replace()
                                    </script>
                                </span>
                                <span x-show="!passwordHidden">
                                    <i data-feather="eye-off" class="group-hover:text-primary dark:group-hover:text-white w-6 h-6 text-gray-secondary transition duration-200 ease-in-out"
                                    ></i>
                                    <script>
                                        feather.replace()
                                    </script>
                                </span>
                            </button>
                        </div>
                        <template x-if="status_err?.password">
                            <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                <span class="span-danger" x-text="status_err.password[0]">Validasi Error</span>
                            </div>
                        </template>
                    </div>
        
                    <div class="flex items-center justify-between mb-14">
                        <button type="submit"
                            class="px-4 py-2 rounded-pill bg-primary dark:bg-slate-secondary text-white text-center hover:text-opacity-90 transition duration-200 ease-in-out"">Sign
                            In</button>
                        <a href="{{ route('password-reset') }}"><span
                                class="span text-center translate-y-2 font-semibold dark:text-white hover:text-opacity-90 transition duration-200 ease-in-out">Forgot
                                your Password?</span></a>
                    </div>
                </form>
    
    
                <div class="flex items-center justify-center">
                    Don't have an account? &nbsp;
                    <a href="{{ route('register') }}"><span class="span dark:text-slate-fourth font-semibold"> Sign Up Now</span></a>
                </div>
    
            </div>
    
            <div class="border border-gray-third bg-white dark:bg-slate-secondary rounded-primary col col-12 lg:col-6 hidden h-[400px] lg:flex items-center justify-center">
                <figure>
                    <img src="{{ asset('assets/images/securelogin.svg') }}" class="w-[300px] h-[300px]" alt="">
                </figure>
            </div>
    
        </div>
    </template>
    
</section>

@endsection