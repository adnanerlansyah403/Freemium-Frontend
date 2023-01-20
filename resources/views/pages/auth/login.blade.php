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

<section class="pt-[60px] pb-[100px] dark:text-white" x-data="auth" x-init="checkAlreadyAuth()" style="display: none;"
>
    {{-- alert --}}
    <div x-init="flash()"></div>
    <div x-show="showFlash">
        <x-alert />
    </div>

    <div class="container mx-auto flex items-start" x-init="
        if(!isLogedIn) {
            setTimeout(function() {
                return document.querySelector('section').style.display = 'block';
            }, 1000)
        }
    ">

        <div class="col col-12 lg:col-6">

            <div class="mb-5">
                <label for="email" class="text-md">Email</label>
                <input type="text" placeholder="Your email..."
                    x-bind:class="status_err.email ? 'input-danger' : ''" class="px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] bg-white hover:bg-white dark:bg-slate-secondary rounded-primary mt-4" x-model="email">
                    <template x-if="status_err.email">
                        <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <span class="span-danger" x-text="status_err.email[0]">Validasi Error</span>
                        </div>
                    </template>
            </div>

            <div class="mb-8">
                <label for="password" class="text-md">Password</label>
                <input type="password" placeholder="Your password..."
                x-bind:class="status_err.password ? 'input-danger' : ''" class="px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] bg-white hover:bg-white dark:bg-slate-secondary rounded-primary mt-4" x-model="password">
                    <template x-if="status_err.password">
                        <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <span class="span-danger" x-text="status_err.password[0]">Validasi Error</span>
                        </div>
                    </template>
            </div>

            <div class="flex items-center justify-between mb-14">
                <button type="submit"
                    class="px-4 py-2 rounded-pill bg-primary dark:bg-slate-secondary text-white text-center hover:text-opacity-90 transition duration-200 ease-in-out" @click="fetchLogin()">Sign
                    In</button>
                <a href="#"><span
                        class="span text-center dark:text-white hover:text-opacity-90 transition duration-200 ease-in-out">Forgot
                        your Password?</span></a>
            </div>

            <div class="flex items-center justify-center">
                Don't have an account? &nbsp;
                <a href="{{ route('register') }}"><span class="span dark:text-slate-fourth font-semibold"> Sign Up Now</span></a>
            </div>

        </div>

        <div class="border border-gray-third bg-white dark:bg-slate-secondary rounded-primary col col-12 lg:col-6 hidden h-[485px] lg:flex items-center justify-center">
            <figure>
                <img src="{{ asset('assets/images/securelogin.svg') }}" class="w-full h-auto" alt="">
            </figure>
        </div>

    </div>
    
</section>

@endsection