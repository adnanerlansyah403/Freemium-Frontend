
{{-- @section("title", "Me - Freemium App") --}}

{{-- Title Section --}}
<div x-data="user" x-init="checkSession()">
    <template x-if="isLogedIn">
        <script>
            document.title = 'Me - Freemium App';
        </script>
    </template>
</div>

<section class="pt-[60px] pb-[100px]" x-data="user" x-init="checkSession()">
    <div x-init="fetchMe()"></div>

    {{-- alert --}}
    <div x-init="flash()"></div>
    <div x-show="showFlash">
        <x-alert />
    </div>
    
    <div>
        <h1 class="font-iceberg text-lg text-center text-primary dark:text-white mb-16">ME</h1>
    
        @include("layouts.partials.user.dashboard")
        
        <template x-if="isLoading == true">
            <div class="container mx-auto flex items-center justify-center flex-wrap md:flex-nowrap gap-10 lg:gap-0">
                <span class="span my-10 dark:text-white text-md">Loading...</span>
            </div>
        </template>
    
        <template x-if="!isLoading">
            
            <div class="container mx-auto flex flex-wrap md:flex-nowrap gap-10 lg:gap-0">
    
                <div class="col col-12 order-2 md:ml-0 lg:order-1 lg:col-8">
    
                    <div class="group flex items-center gap-5 mb-7 pl-4 lg:pl-0 pr-2 bg-white dark:bg-slate-primary rounded-primary shadow-[0px_0px_4px_rgba(0,0,0,0.25)]">
                        <span class="group-hover:translate-x-1 bg-primary dark:bg-slate-secondary lg:w-[150px] text-white text-center hidden lg:block lg:px-6 py-3 rounded-primary transition duration-200 ease-in-out">
                            Full Name
                        </span>
                        <input type="text" class="py-3 lg:w-4/5 dark:text-white" placeholder="Your full name..." title="Full Name" x-model="name">
                    </div>
    
                    <div class="group flex items-center gap-5 mb-7 pl-4 lg:pl-0 pr-2 bg-white dark:bg-slate-primary rounded-primary shadow-[0px_0px_4px_rgba(0,0,0,0.25)]">
                        <span class="group-hover:translate-x-1 bg-primary dark:bg-slate-secondary lg:w-[150px] text-white text-center hidden lg:block lg:px-6 py-3 rounded-primary transition duration-200 ease-in-out">
                            Username
                        </span>
                        <input type="text" class="py-3 w-full lg:w-4/5 dark:text-white" placeholder="Your username..." x-bind:value="data_user.username" x-model="username" title="Username">
                    </div>
    
                    <div class="group flex items-center gap-5 mb-7 pl-4 lg:pl-0 pr-2 bg-white dark:bg-slate-primary rounded-primary shadow-[0px_0px_4px_rgba(0,0,0,0.25)]">
                        <span class="group-hover:translate-x-1 bg-primary dark:bg-slate-secondary lg:w-[150px] text-white text-center hidden lg:block lg:px-6 py-3 rounded-primary transition duration-200 ease-in-out">
                            Email
                        </span>
                        <input type="email" class="py-3 w-full lg:w-4/5 dark:text-white" x-bind:value="data_user.email" x-model="email" placeholder="Your email...">
                    </div>
    
                    <div class="group flex items-center gap-5 mb-7 pl-4 lg:pl-0 pr-2 bg-white dark:bg-slate-primary rounded-primary shadow-[0px_0px_4px_rgba(0,0,0,0.25)]">
                        <span class="group-hover:translate-x-1 bg-primary dark:bg-slate-secondary lg:w-[150px] text-white text-center hidden lg:block lg:px-6 py-3 rounded-primary transition duration-200 ease-in-out">
                            Password
                        </span>
                        <input type="password" class="py-3 w-full lg:w-4/5 dark:text-white" placeholder="Your password..." x-model="password">
                    </div>
    
                    <div class="flex items-center gap-5 mb-7 pr-2 bg-white dark:bg-slate-primary rounded-primary shadow-[0px_0px_4px_rgba(0,0,0,0.25)]">
                        <span class="cursor-pointer bg-primary dark:bg-slate-secondary lg:w-[150px] text-white text-center px-4 lg:px-6 py-3 rounded-primary" title="Upload Photo Profile"
                        @click="$refs.photo.click()">
                            Upload
                        </span>
                        <input type="file" class="py-3 w-full lg:w-4/5 dark:text-white" id="photo" x-ref="photo" placeholder="Your password...">
                    </div>
    
                    <ul class="flex items-center justify-center gap-4 my-12">
                        <li class="w-max cursor-pointer p-3 rounded-full bg-[#4267B2] text-white hover:bg-primary dark:hover:bg-slate-secondary transition duration-200 ease-in-out"
                        @click="
                            linkInputFacebook = true;
                            linkInputLinkedin = false;
                            linkInputInstagram = false;
                            linkInputTwitter = false;
                        ">
                            <i data-feather="facebook"></i>
                        </li>
                        <li class="w-max cursor-pointer p-3 rounded-full bg-[#0077B5] text-white hover:bg-primary dark:hover:bg-slate-secondary transition duration-200 ease-in-out"
                        @click="
                        linkInputFacebook = false;
                        linkInputLinkedin = true;
                        linkInputInstagram = false;
                        linkInputTwitter = false;
                        ">
                            <i data-feather="linkedin"></i>
                        </li>
                        <li class="w-max cursor-pointer p-3 rounded-full bg-[#C13584] text-white hover:bg-primary dark:hover:bg-slate-secondary transition duration-200 ease-in-out"
                        @click="
                        linkInputFacebook = false;
                        linkInputLinkedin = false;
                        linkInputInstagram = true;
                        linkInputTwitter = false;
                        ">
                            <i data-feather="instagram"></i>
                        </li>
                        <li class="w-max cursor-pointer p-3 rounded-full bg-[#1DA1F2] text-white hover:bg-primary dark:hover:bg-slate-secondary transition duration-200 ease-in-out"
                        @click="
                        linkInputFacebook = false;
                        linkInputLinkedin = false;
                        linkInputInstagram = false;
                        linkInputTwitter = true;
                        ">
                            <i data-feather="twitter"></i>
                        </li>
                    </ul>
    
                    <div class="group flex items-center gap-5 mb-7 pl-4 lg:pl-0 pr-2 bg-white dark:bg-slate-primary rounded-primary shadow-[0px_0px_4px_rgba(0,0,0,0.25)]">
                        <span class="group-hover:translate-x-1 bg-primary dark:bg-slate-secondary lg:w-[220px] text-white text-center hidden lg:block lg:px-6 py-3 rounded-primary transition duration-200 ease-in-out">
                            Link Social
                            <i x-show="linkInputFacebook">Facebook</i>
                            <i x-show="linkInputLinkedin">Linkedin</i>
                            <i x-show="linkInputInstagram">Instagram</i>
                            <i x-show="linkInputTwitter">Twitter</i>
                        </span>
    
                        <input type="url" class="py-3 w-full lg:w-[65%] dark:text-white" placeholder="Your link facebook..." title="Link Facebook" x-bind:value="data_user.link_facebook" x-model="link_facebook" x-show="linkInputFacebook">
    
                        <input type="url" class="py-3 w-full lg:w-[65%] dark:text-white" placeholder="Your link linkedin..." title="Link Linkedin" x-bind:value="data_user.link_linkedin" x-model="link_linkedin" x-show="linkInputLinkedin">
    
                        <input type="url" class="py-3 w-full lg:w-[65%] dark:text-white" placeholder="Your link instagram..." title="Link Instagram" x-bind:value="data_user.link_instagram" x-model="link_instagram" x-show="linkInputInstagram">
    
                        <input type="url" class="py-3 w-full lg:w-[65%] dark:text-white" placeholder="Your link twitter..." title="Link Twitter" x-bind:value="data_user.link_twitter" x-model="link_twitter" x-show="linkInputTwitter">
                    </div>
    
                    <div class="flex items-center justify-center mt-10">
                        <button @click="updateMe()" class="py-2 px-4 rounded-primary outline outline-1 outline-primary dark:outline-white text-primary dark:text-white hover:bg-primary dark:hover:bg-slate-secondary hover:text-white hover:outline-none transition duration-200 ease-in-out">
                            Save
                        </button>
                    </div>
    
                </div>
    
                <div class="col col-12 lg:col-4 md:order-2 h-max py-5 px-4 rounded-primary bg-white dark:bg-slate-secondary dark:text-white shadow-[0px_0px_4px_rgba(0,0,0,0.25)] flex flex-col items-center">
                    <figure class="mb-5">
                        <template x-if="data_user.photo != null || data_user.photo.length != 0">
                            <img x-bind:src="imgUrl+data_user.photo" class="w-[100px] h-[100px] bg-gray-secondary rounded-full" alt="">
                        </template>
                        <template x-if="data_user.photo == null || data_user.photo.length == 0">
                            <img x-bind:src="imgUrl+'img/user1.png'" class="w-[100px] h-[100px] bg-gray-secondary rounded-full" alt="">
                        </template>
                    </figure>
                    <span class="text-md font-semibold" x-text="data_user.name">User</span>
                    <p x-text="data_user.email">user@gmail.com</p>
                    <div class="mt-12 flex flex-col items-center justify-center">
                        {{-- <span class="mb-4 font-semibold text-primary">AUTHOR</span> --}}
                        <p class="flex items-center gap-2">
                            <span class=" font-bold">Status : </span>
                            <template x-if="data_user.role == 1">
                                {{-- <span x-text="console.log(data_user.role)"></span> --}}
                                <span class="bg-primary dark:bg-slate-third rounded-primary py-1 px-3 text-white text-sm" x-text="data_user.role == 1 ? 'Admin Member' : ''">Admin Member</span>
                            </template>
                            <template x-if="data_user.role == 2">
                                <span class="bg-primary dark:bg-slate-third rounded-primary py-1 px-3 text-white text-sm" x-text="data_user.subscribe_status == 1 ? 'Member - '+data_user.payments[0].plan.name : 'Not a Member'">Member - Lifetime</span>
                            </template>
                        </p>
                    </div>
                </div>
                <!-- Feather Icons Scripts -->
                <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
                <script>
                    feather.replace()
                </script>
    
            </div>
    
        </template>

    </div>

</section>
