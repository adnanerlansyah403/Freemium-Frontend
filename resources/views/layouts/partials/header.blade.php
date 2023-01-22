<header id="header" class="group fixed w-full z-[101] shadow-lg py-1 bg-white dark:bg-slate-primary dark:text-white transition duration-200 ease-in-out">
<div class="container mx-auto flex items-center justify-between px-2 sm:px-0">
    
    <figure>
        <a href="{{ route('homepage') }}" class="flex items-center">
            <span class="span text-lg sm:text-xl dark:text-slate-third">F</span>
            <p class="text-md font-iceberg">reemium</p>
        </a>
    </figure>

    @if($currentRoute == 'homepage')
        <ul class="hidden lg:flex items-center gap-10">
            <li class="relative text-base font-medium before:absolute before:w-full before:h-[1px] before:bottom-0 before:bg-primary before:-left-full hover:before:left-0 before:transiton before:duration-200 before:ease-in-out overflow-x-hidden">
                <a href="#header">
                    <span class="span">H</span>ome
                </a>
            </li>
            <li class="relative text-base font-medium before:absolute before:w-full before:h-[1px] before:bottom-0 before:bg-primary before:-left-full hover:before:left-0 before:transiton before:duration-200 before:ease-in-out overflow-x-hidden">
                <a href="{{ route('article.list') }}">
                    <span class="span">A</span>rticle
                </a>
            </li>
            <li class="relative text-base font-medium before:absolute before:w-full before:h-[1px] before:bottom-0 before:bg-primary before:-left-full hover:before:left-0 before:transiton before:duration-200 before:ease-in-out overflow-x-hidden">
                <a href="#about">
                    <span class="span">A</span>bout
                </a>
            </li>
            <li class="relative text-base font-medium before:absolute before:w-full before:h-[1px] before:bottom-0 before:bg-primary before:-left-full hover:before:left-0 before:transiton before:duration-200 before:ease-in-out overflow-x-hidden">
                <a href="#faq">
                    <span class="span">F</span>aq
                </a>
            </li>
            <li class="relative text-base font-medium before:absolute before:w-full before:h-[1px] before:bottom-0 before:bg-primary before:-left-full hover:before:left-0 before:transiton before:duration-200 before:ease-in-out overflow-x-hidden">
                <a href="#contact">
                    <span class="span">C</span>ontact
                </a>
            </li>
        </ul>
    @endif

    <div class="flex items-center gap-2" x-data="auth">
        <div x-init="checkSession()"></div>

        <template x-if="!isLogedIn">
            <div class="relative flex items-center gap-2" x-data="{
                menuBar: false
            }">
                <a href="{{ route('login') }}" class="text-[16px] sm:text-base px-4 py-2 hover:bg-primary dark:hover:bg-slate-secondary hover:text-white rounded-pill transition duration-200 ease-in-out">Sign In</a>
                <a href="{{ route('register') }}" class="text-[16px] sm:text-base px-4 py-2 hover:bg-primary dark:hover:bg-slate-secondary hover:text-white rounded-pill transition duration-200 ease-in-out">Sign Up</a>
                <button class="block lg:hidden translate-y-[3px] hover:text-opacity-80 transition duration-200 ease-in-out"
                @click="menuBar = !menuBar"
                x-on:mouseover="menuBar = true"
                >
                    <ion-icon name="menu-outline" class="text-md"></ion-icon>
                </button>
                <ul 
                    class="absolute top-[140%] right-0 rounded-primary w-[200px] bg-white dark:bg-slate-secondary text-black shadow-[0px_0px_8px_2px_rgba(0,0,0,0.25)] overflow-hidden z-[100]"
                x-show="menuBar"
                x-on:mouseleave="menuBar = false"
                x-transition
                >
                    <li class="px-[18px] py-2 hover:bg-primary hover:text-white transition duration-200 ease-out">
                        <a href="#header" class="flex items-center gap-2">
                            <span>Home</span>
                        </a>
                        <!-- Feather Icons Scripts -->
                        <script>
                            feather.replace()
                        </script>
                    </li>
                    <li class="px-[18px] py-2 hover:bg-primary hover:text-white transition duration-200 ease-out">
                        <a href="{{ route("article.create") }}" class="flex items-center gap-2">
                            <span>Article</span>
                        </a>
                        <!-- Feather Icons Scripts -->
                        <script>
                            feather.replace()
                        </script>
                    </li>
                    <li class="px-[18px] py-2 hover:bg-primary hover:text-white transition duration-200 ease-out">
                        <a href="#faq" class="flex items-center gap-2">
                            <span>Faq</span>
                        </a>
                        <!-- Feather Icons Scripts -->
                        <script>
                            feather.replace()
                        </script>
                    </li>
                    <li class="px-[18px] py-2 hover:bg-primary hover:text-white transition duration-200 ease-out">
                        <a href="#contact" class="flex items-center gap-2">
                            <span>Contact</span>
                        </a>
                        <!-- Feather Icons Scripts -->
                        <script>
                            feather.replace()
                        </script>
                    </li>
                </ul>
            </div>
        </template>

        <template x-if="isLogedIn">
            <div class="flex items-center gap-3 lg:gap-4" x-data="user">
                <div x-init="fetchMe()"></div>
                <div x-init="fetchMyTransactions()"></div>
                {{-- <span x-text="console.log(data_user)"></span> --}}
                <template x-if="data_user?.role == 2">
                    <a href="{{ route('article.create') }}" class="lg:flex items-center gap-2 text-slate-primary dark:text-gray-third dark:hover:text-white text-[20px] hover:text-opacity-90 transition duration-200 ease-in-out">
                        <b title="Write" class="-translate-y-1 lg:translate-y-0">
                            <i data-feather="edit"></i>
                        </b>
                        <span class="hidden lg:block">Write</span>
                        <!-- Feather Icons Scripts -->
                        <script>
                            feather.replace()
                        </script>
                    </a>
                </template>
                <div class="relative"
                    x-data="{dropdownmenu : false}"
                >
                    <button 
                        type="button" 
                        class="flex items-center gap-1 px-3 py-2 bg-primary dark:bg-slate-secondary text-white hover:text-opacity-90 rounded-primary"
                        @click="dropdownmenu = !dropdownmenu"
                        x-on:mouseover="dropdownmenu = true"
                        x-data="helpers"
                    >
                        <template x-if="data_user?.photo != null">
                            <figure>
                                <img x-bind:src="imgUrl + data_user?.photo" src="" class="w-6 h-6 bg-gray-third rounded-full" alt="">
                            </figure>
                        </template>
                        {{-- <template x-if="data_user?.photo == null || data_user?.photo?.length == 0">
                            <figure>
                                <ion-icon class="text-[22px] translate-y-[3px]" name="person-circle-outline"></ion-icon>
                            </figure>
                        </template> --}}
                        <span class="font-inter" x-text="data_user?.name == null ? 'User' : substring(data_user?.name)"></span>
                    </button>
                    <ul 
                        class="absolute top-[140%] right-0 rounded-primary w-[200px] bg-primary dark:bg-slate-secondary text-white shadow-[0px_0px_8px_2px_rgba(0,0,0,0.25)] overflow-hidden"
                        x-show="dropdownmenu"
                        x-on:mouseleave="dropdownmenu = false"
                        x-transition
                        style="z-index: 1;"
                    >
                        <template x-if="data_user?.role == 1">
                            <li class="px-[18px] py-2 hover:bg-white hover:text-black transition duration-200 ease-out">
                                <a href="{{ route('admin.dashboard.index') }}" class="flex items-center gap-2">
                                    <i data-feather="trending-up"></i>
                                    <span>Admin</span>
                                </a>
                                <!-- Feather Icons Scripts -->
                                <script>
                                    feather.replace()
                                </script>
                            </li>
                        </template>
                        @if($currentRoute != 'homepage')
                            <li class="px-[18px] py-2 hover:bg-white hover:text-black transition duration-200 ease-out">
                                <a href="{{ route('admin.dashboard.index') }}" class="flex items-center gap-2">
                                    <ion-icon name="documents-outline" class="text-[25px]"></ion-icon>
                                    <span>Articles</span>
                                </a>
                                <!-- Feather Icons Scripts -->
                                <script>
                                    feather.replace()
                                </script>
                            </li>
                        @endif
                        <li class="px-[18px] py-2 hover:bg-white hover:text-black transition duration-200 ease-out">
                            <a href="{{ route('profile.index') }}" class="flex items-center gap-2">
                                <i data-feather="user"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <template x-if="data_user?.role == 2">
                            <li class="px-[18px] py-2 hover:bg-white hover:text-black transition duration-200 ease-out">
                                <a href="{{ route('article.index') }}" class="flex items-center gap-2">
                                    <i data-feather="file-text"></i>
                                    <span>My Articles</span>
                                </a>
                                <script>
                                    feather.replace()
                                </script>
                            </li>
                        </template>
                        <template x-if="myTransactions[0] != null && data_user?.subscribe_status == false">
                            <li class="px-[18px] py-2 hover:bg-white hover:text-black transition duration-200 ease-out">
                                <a href="{{ route('transaction.show') }}" class="flex items-center gap-2">
                                    <i data-feather="credit-card"></i>
                                    <span>My Transaction</span>
                                </a>
                                <!-- Feather Icons Scripts -->
                                <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
                                <script>
                                    feather.replace()
                                </script>
                            </li>
                        </template>
                        <li class="px-[18px] py-2 rounded-b-primary hover:bg-white hover:text-black transition duration-200 ease-out">
                            <button @click="logout()" class="flex items-center gap-2">
                                <i data-feather="log-out"></i>
                                <span>Logout</span>
                            </button>
                        </li>
                    </ul>
                </div>
                <!-- Feather Icons Scripts -->
                <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
                <script>
                    feather.replace()
                </script>
            </div>
        </template>

        @if($currentRoute != 'homepage')
            <div x-data="helpers" class="absolute right-5 top-[125%] xl:-right-1/3 xl:top-[23px] xl:group-hover:right-5 transition duration-200 ease-in-out" style="transition: .6s ease-in-out;">
                <button id="buttonMode" @click="darkMode()" class="p-2 text-sm rounded-full bg-slate-primary dark:bg-white text-white dark:text-slate-secondary flex items-center gap-2 overflow-hidden transition duration-200 ease-in-out" title="Light Mode">
                    <img src="{{ asset("assets/images/icons/sun.svg") }}" id="iconMode" alt="" class="transition duration-200 ease-in-out">
                </button>
            </div>
        @endif


    </div>

</div>
</header>