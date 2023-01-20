@extends("homepage")

@section("title", "Register - Freemium App")

{{-- Title Section --}}
{{-- <div x-data="user" x-init="checkSession()">
    <template x-if="!isLogedIn">
        <script>
            document.title = 'Register - Freemium App';
        </script>
    </template>
</div> --}}

@section("content")

<section class="pt-[60px] pb-[100px] dark:text-white" x-data="auth" x-init="checkAlreadyAuth()"
>

    <div class="container mx-auto flex items-start" >

        <div class="col col-12 lg:col-6">

            <div class="mb-5">
                <label for="name" class="text-md">Name</label>
                <div class="flex items-center gap-4 pl-4 pr-3 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] bg-white hover:bg-white dark:bg-slate-secondary rounded-primary mt-4">
                    <i data-feather="user" class="w-6 h-6 text-gray-secondary"></i>
                    <input type="text" placeholder="Your name..."
                    x-bind:class="status_err.name ? 'input-danger' : ''" class="" x-model="name">
                </div>
                    <template x-if="status_err.name">
                        <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <span class="span-danger" x-text="status_err.name[0]">Validasi Error</span>
                        </div>
                    </template>
            </div>

            <div class="mb-5">
                <label for="email" class="text-md">Email</label>
                <div class="flex items-center gap-4 pl-4 pr-3 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] bg-white hover:bg-white dark:bg-slate-secondary rounded-primary mt-4">
                    <i data-feather="mail" class="w-6 h-6 text-gray-secondary"></i>
                    <input type="text" placeholder="Your email..."
                    x-bind:class="status_err.email ? 'input-danger' : ''" class="" x-model="email">
                </div>
                    <template x-if="status_err.email">
                        <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <span class="span-danger" x-text="status_err.email[0]">Validasi Error</span>
                        </div>
                    </template>
            </div>

            <div class="mb-8" x-data="{passwordHidden: true}">
                <label for="password" class="text-md">Password</label>
                <div class="group flex items-center gap-4 pl-4 pr-3 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] bg-white hover:bg-white dark:bg-slate-secondary rounded-primary mt-4 transition duration-200 ease-in-out">
                    <button type="button" @click="
                    typePassword = passwordHidden == true ? 'text' : 'password';
                    $refs.password.setAttribute('type', typePassword)
                    passwordHidden = !passwordHidden;
                    ">
                        <i x-show="passwordHidden == true" data-feather="lock" class="group-hover:text-white w-6 h-6 text-gray-secondary transition duration-200 ease-in-out"></i>
                        <i x-show="passwordHidden == false" data-feather="unlock" class="group-hover:text-white w-6 h-6 text-gray-secondary transition duration-200 ease-in-out"></i>
                    </button>
                    <input type="password" placeholder="Your password..."
                    x-bind:class="status_err.password ? 'input-danger' : ''" class="" x-model="password" x-ref="password">
                </div>
                    <template x-if="status_err.password">
                        <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <span class="span-danger" x-text="status_err.password[0]">Validasi Error</span>
                        </div>
                    </template>
            </div>

            <div class="flex items-center justify-between mb-14">
                <button type="submit"
                    class="px-4 py-2 rounded-pill bg-primary dark:bg-slate-secondary text-white text-center hover:text-opacity-90 transition duration-200 ease-in-out" @click="register()">Sign
                    Up</button>
            </div>

            <div class="flex items-center justify-center">
                Already have an account? &nbsp;
                <a href="{{ route('login') }}"><span class="span font-semibold dark:text-slate-fourth"> Sign In Now</span></a>
            </div>

        </div>

        <div class="border border-gray-third bg-white dark:bg-slate-secondary rounded-primary hidden lg:flex col col-6 h-[400px] items-center justify-center">
            <figure>
                <img src="{{ asset('assets/images/accessaccount.svg') }}" class="w-[300px] h-[300px]" alt="">
            </figure>
        </div>

    </div>

</section>

@endsection