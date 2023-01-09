<header class="shadow-lg">
<div class="container mx-auto flex items-center justify-between px-2 sm:px-0">
    
    <figure>
        <a href="{{ route('homepage') }}" class="flex items-center">
            <span class="span text-lg sm:text-xl">F</span>
            <p class="text-md font-iceberg">reemium</p>
        </a>
    </figure>

    <div class="flex items-center gap-3 sm:gap-2">


        <a href="{{ route('login') }}" class="text-xs sm:text-base px-4 py-2 hover:bg-primary hover:text-white rounded-pill transition duration-200 ease-in-out">Sign In</a>
        <a href="{{ route('register') }}" class="text-xs sm:text-base px-4 py-2 hover:bg-primary hover:text-white rounded-pill transition duration-200 ease-in-out">Sign Up</a>

        {{-- <div class="flex items-center gap-6">
            <a href="{{ route('article.create') }}" class="hidden lg:flex items-center gap-2 text-gray-primary text-[20px] hover:text-opacity-90 transition duration-200 ease-in-out">
                <i data-feather="edit"></i>
                <span>Write</span>
            </button>
            <div class="relative"
                x-data="{dropdownmenu : false}"
            >
                <button 
                    type="button" 
                    class="flex items-center gap-3 px-4 py-2 bg-primary text-white hover:text-opacity-90 rounded-primary"
                    @click="dropdownmenu = !dropdownmenu"
                >
                    <figure>
                        <img src="" class="w-6 h-6 bg-gray-third rounded-full" alt="">
                    </figure>
                    <span class="font-inter">Adnan Erlansyah</span>
                </button>
                <ul 
                    class="absolute top-[140%] rounded-primary bg-primary text-white w-full shadow-[0px_0px_8px_2px_rgba(0,0,0,0.25)]"
                    x-show="dropdownmenu"
                    x-transition
                >
                    <li class="px-[18px] py-2 rounded-t-primary hover:bg-white hover:text-black transition duration-200 ease-out">
                        <a href="{{ route('profile.index') }}" class="flex items-center gap-2">
                            <i data-feather="user"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li class="px-[18px] py-2 hover:bg-white hover:text-black transition duration-200 ease-out">
                        <a href="{{ route('myarticle.index') }}" class="flex items-center gap-2">
                            <i data-feather="file-text"></i>
                            <span>My Articles</span>
                        </a>
                    </li>
                    <li class="px-[18px] py-2 rounded-b-primary hover:bg-white hover:text-black transition duration-200 ease-out">
                        <a href="{{ route('logout') }}" class="flex items-center gap-2">
                            <i data-feather="log-out"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div> --}}

    </div>

</div>
</header>