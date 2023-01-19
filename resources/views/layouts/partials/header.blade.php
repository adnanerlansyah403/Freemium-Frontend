<header class="shadow-lg py-1 dark:text-white">
<div class="container mx-auto flex items-center justify-between px-2 sm:px-0">
    
    <figure>
        <a href="{{ route('homepage') }}" class="flex items-center">
            <span class="span text-lg sm:text-xl dark:text-slate-third">F</span>
            <p class="text-md font-iceberg">reemium</p>
        </a>
    </figure>

    <div class="flex items-center gap-2" x-data="auth">
        <div x-init="checkSession()"></div>

        <template x-if="!isLogedIn">
            <div>
                <a href="{{ route('login') }}" class="text-[16px] sm:text-base px-4 py-2 hover:bg-primary dark:hover:bg-slate-secondary hover:text-white rounded-pill transition duration-200 ease-in-out">Sign In</a>
                <a href="{{ route('register') }}" class="text-[16px] sm:text-base px-4 py-2 hover:bg-primary dark:hover:bg-slate-secondary hover:text-white rounded-pill transition duration-200 ease-in-out">Sign Up</a>
            </div>
        </template>

        <template x-if="isLogedIn">
            <div class="flex items-center gap-6" x-data="user">
                <div x-init="fetchMe()"></div>
                <div x-init="fetchMyTransactions()"></div>
                {{-- <span x-text="console.log(data_user)"></span> --}}
                <template x-if="data_user.role == 2">
                    <a href="{{ route('article.create') }}" class="hidden lg:flex items-center gap-2 text-slate-primary dark:text-gray-third dark:hover:text-white text-[20px] hover:text-opacity-90 transition duration-200 ease-in-out">
                        <i data-feather="edit"></i>
                        <span>Write</span>
                        <!-- Feather Icons Scripts -->
                        <script>
                            feather.replace()
                        </script>
                    </a>
                </template>
                <div class="relative z-[100]"
                    x-data="{dropdownmenu : false}"
                >
                    <button 
                        type="button" 
                        class="flex items-center gap-2 px-4 py-2 bg-primary dark:bg-slate-secondary text-white hover:text-opacity-90 rounded-primary"
                        @click="dropdownmenu = !dropdownmenu"
                        x-data="helpers"
                    >
                        <template x-if="imgUrl+data_user.photo != null || imgUrl+data_user.photo != ''">
                            <figure>
                                <img x-bind:src="imgUrl+data_user.photo" src="" class="w-6 h-6 bg-gray-third rounded-full" alt="">
                            </figure>
                        </template>
                        <span class="font-inter" x-text="data_user.name == null ? 'User' : substring(data_user.name)"></span>
                    </button>
                    <ul 
                        class="absolute top-[140%] right-0 rounded-primary w-[200px] bg-primary dark:bg-slate-secondary text-white shadow-[0px_0px_8px_2px_rgba(0,0,0,0.25)] overflow-hidden"
                        x-show="dropdownmenu"
                        x-transition
                    >
                        <template x-if="data_user.role == 1">
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
                        <li class="px-[18px] py-2 hover:bg-white hover:text-black transition duration-200 ease-out">
                            <a href="{{ route('profile.index') }}" class="flex items-center gap-2">
                                <i data-feather="user"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <template x-if="data_user.role == 2">
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
                        <template x-if="myTransactions[0] != null && data_user.subscribe_status == false">
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

        <div x-data="helpers">
            <button id="buttonMode" @click="darkMode()" class="p-2 text-sm rounded-full bg-slate-primary dark:bg-white text-white dark:text-slate-secondary flex items-center gap-2 overflow-hidden transition duration-200 ease-in-out" title="Light Mode">
                {{-- <ion-icon id="iconMode" class="dark:text-white" name="moon-outline"></ion-icon> --}}
                {{-- <i id="iconMode" data-feather="moon"></i> --}}
                <img src="{{ asset("assets/images/icons/sun.svg") }}" id="iconMode" alt="" class="transition duration-200 ease-in-out">
            </button>
        </div>


    </div>

</div>
</header>