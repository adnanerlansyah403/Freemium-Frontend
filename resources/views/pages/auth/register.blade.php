@extends("homepage")

@section("title", "Register - Freemium App")

@section("content")

<section class="p-[100px]">
    <div class="container mx-auto flex items-start">

        <form action="" class="col col-12 lg:col-6">

            <div class="mb-5">
                <label for="text" class="text-md">Full Name</label>
                <input type="text" placeholder="Your text..."
                    class="px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white mt-4">
            </div>

            <div class="mb-5">
                <label for="email" class="text-md">Email</label>
                <input type="text" placeholder="Your email..."
                    class="px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white mt-4">
            </div>

            <div class="mb-8">
                <label for="password" class="text-md">Password</label>
                <input type="password" placeholder="Your password..."
                    class="px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white mt-4">
            </div>

            <div class="flex items-center justify-between mb-14">
                <button type="submit"
                    class="px-4 py-2 rounded-pill bg-primary text-white text-center hover:text-opacity-90 transition duration-200 ease-in-out">Sign
                    Up</button>
            </div>

            <div class="flex items-center justify-center">
                Already have an account? &nbsp;
                <a href=""><span class="span font-semibold"> Sign In Now</span></a>
            </div>

        </form>

        <div class="border border-gray-third rounded-primary sm:hidden lg:flex col col-6 h-[485px] items-center justify-center">
            <figure>
                <img src="{{ asset('assets/images/accessaccount.svg') }}" width="375" height="300" alt="">
            </figure>
        </div>

    </div>
</section>

@endsection