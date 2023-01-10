@extends("homepage")

@section("title", "Register - Freemium App")

@section("content")

<section class="py-[100px]"  x-data="auth">
    <div x-init="checkAlreadyAuth()"></div>
    <div class="container mx-auto flex items-start">

        <div class="col col-12 lg:col-6" x-data="auth">

            <div class="mb-5">
                <label for="name" class="text-md">Name</label>
                <input type="text" placeholder="Your name..."
                    x-bind:class="status_err.name ? 'input-danger' : ''" class="px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary mt-4" x-model="name">
                    <template x-if="status_err.name">
                        <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <span class="span-danger" x-text="status_err.name[0]">Validasi Error</span>
                        </div>
                    </template>
            </div>

            <div class="mb-5">
                <label for="email" class="text-md">Email</label>
                <input type="text" placeholder="Your email..."
                    x-bind:class="status_err.email ? 'input-danger' : ''" class="px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary mt-4" x-model="email">
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
                x-bind:class="status_err.password ? 'input-danger' : ''" class="px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary mt-4" x-model="password">
                    <template x-if="status_err.password">
                        <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <span class="span-danger" x-text="status_err.password[0]">Validasi Error</span>
                        </div>
                    </template>
            </div>

            <div class="flex items-center justify-between mb-14">
                <button type="submit"
                    class="px-4 py-2 rounded-pill bg-primary text-white text-center hover:text-opacity-90 transition duration-200 ease-in-out" @click="register()">Sign
                    Up</button>
            </div>

            <div class="flex items-center justify-center">
                Already have an account? &nbsp;
                <a href="{{ route('login') }}"><span class="span font-semibold"> Sign In Now</span></a>
            </div>

        </div>

        <div class="border border-gray-third rounded-primary hidden lg:flex col col-6 h-[485px] items-center justify-center">
            <figure>
                <img src="{{ asset('assets/images/accessaccount.svg') }}" width="375" height="300" alt="">
            </figure>
        </div>

    </div>
</section>

@endsection