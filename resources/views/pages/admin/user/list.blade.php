@extends("homepage")


@section("content")

<style>
    .bg-active {
        background : #7C000D;
        color: white;
    }
</style>

<div x-data="user" x-init="checkSession()">
    {{-- <div x-init="fetchMe()"></div> --}}
    <template x-if="isLogedIn && data_user.role == 1">
        <script>
            document.title = 'Dashboard Admin - Freemium App';
        </script>
    </template>
</div>

<section class="pt-[140px] pb-[100px]" x-data="user" x-init="checkSession()">
    <div x-init="checkRole()"></div>
    <div x-init="flash()"></div>
    <div x-show="showFlash" x-init="setTimeout(() => {
        showFlash = false
        }, 4000);
    ">
        <x-alert />
    </div>
    <template x-if="!isLoading">
        <div>


            @include("layouts.partials.user.dashboard")

            <div class="flex flex-wrap lg:flex-nowrap gap-8 container mx-auto px-3 lg:px-0 mt-9">

                <div class="w-full lg:col-3">
                    @include("pages.admin.layouts.partials.sidebar")
                </div>

                <div class="w-full col-12 lg:col-9">
                    <div x-init="fetchListUser()"></div>
                    <h2 class="w-full flex items-center justify-center gap-2 py-3 border border-primary dark:border-white dark:bg-slate-secondary rounded-primary text-[20px]">
                        <i class="span font-bold dark:text-white" data-feather="users"></i>
                        <p>
                        <span class="span dark:text-white">Dashboard</span>
                        Admin (User)
                    </p>
                    </h2>

                    <div class="mt-6 mb-10 flex items-center justify-between flex-wrap gap-y-4">

                        <div class="w-full flex items-center flex-wrap lg:flex-nowrap gap-2 gap-y-3" >

                            <div class="p-2 w-full  flex items-center justify-between bg-white dark:bg-slate-secondary shadow-[0px_0px_4px_#7C000B] dark:shadow-none dark:border dark:border-white rounded-lg">
                                <input type="text" placeholder="Search Here..." x-model="search" @keydown.enter="searchUser()" class="w-[93%] dark:text-white">
                                <img class="w-[24px] h-[24px]" src="{{ asset('./assets/images/search.png') }}" alt="">
                            </div>

                            <button @click="sort('name')" class="group w-full lg:col-2 flex items-center justify-center gap-2 p-2 rounded-primary border border-primary dark:bg-slate-secondary dark:border-white dark:text-slate-fourth transition duration-200 ease-in-out">
                                <p>
                                    <span class="span dark:text-white">Sort By: </span>A/Z
                                </p>
                                <i data-feather="repeat" class="rotate-90 w-4 h-4 text-gray-secondary dark:group-hover:text-white  group-hover:-rotate-90 transition duration-200 ease-in-out"></i>
                            </button>

                        </div>

                    </div>

                    <template x-if="!isLoading">

                        <div>
                            <div class="w-full bg-white shadow-lg">
                                <div class="w-full text-center bg-primary py-2 text-white dark:bg-slate-secondary">List Users</div>
                                <div class="overflow-x-auto has-scrollbar2">
                                    <table class="w-full overflow-x-scroll items-center bg-transparent border-collapse">
                                        <thead>
                                        <tr>
                                            <th class="px-6 align-middle dark:bg-slate-third dark:text-white border border-primary dark:border-none py-3 text-xs uppercase whitespace-nowrap font-semibold text-left bg-pink-800">Name</th>
                                            <th class="px-6 align-middle dark:bg-slate-third dark:text-white border border-primary dark:border-none py-3 text-xs uppercase whitespace-nowrap font-semibold text-left bg-pink-800">Username</th>
                                            <th class="px-6 align-middle dark:bg-slate-third dark:text-white border border-primary dark:border-none py-3 text-xs uppercase whitespace-nowrap font-semibold text-left bg-pink-800">Email</th>
                                            <th class="px-6 align-middle dark:bg-slate-third dark:text-white border border-primary dark:border-none py-3 text-xs uppercase whitespace-nowrap font-semibold text-left bg-pink-800">Subscribe Status</th>
                                            <th class="px-6 align-middle dark:bg-slate-third dark:text-white border border-primary dark:border-none py-3 text-xs uppercase whitespace-nowrap font-semibold text-left bg-pink-800">Photo</th>
                                            <th class="px-6 align-middle dark:bg-slate-third dark:text-white border border-primary dark:border-none py-3 text-xs uppercase whitespace-nowrap font-semibold text-left bg-pink-800">Actions</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <template x-for="data in listUser.data">
                                            <tr class="border border-b-primary dark:border-b-slate-secondary dark:bg-slate-fourth dark:text-slate-secondary">
                                            {{-- kondisi Undefined --}}
                                            <td x-bind:class="data.name ? 'border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 font-semibold' : 'border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 font-semibold text-[#86A3B8] dark:text-[#787A91] italic'"  x-text="data.name ? data.name : 'Undefined'">Obi Imanuel</td>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4" x-text="data.username">obito
                                            </td>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4" x-text="data.email">obito@gmail.com
                                            </td>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4" x-text="data.subscribe_status ? 'Member' : 'Not Member'">TRUE
                                            </td>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                <template x-if="data?.photo != null">
                                                    <img x-bind:src="imgUrl+data.photo" src="" class="w-full h-full object-cover">
                                                </template>
                                                <template x-if="data?.photo == null">
                                                    <img x-bind:src="baseUrl+'assets/images/user1.png'" src="" class="w-full h-full object-cover">
                                                </template>
                                            </td>
                                            <td class="flex items-center justify-center w-full h-full translate-y-[15%] border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 gap-2">
                                                <button @click="deleteUser(data.id)" class="hover:text-opacity-60 transition duration-200 ease-in-out" title="Delete">
                                                    <i data-feather="trash-2" class="w-5 h-5 lg:w-6 lg:h-6"></i>
                                                </button>
                                            </td>
                                            <script>
                                                feather.replace()
                                            </script>
                                            </tr>
                                        </template>
                                        <template x-if="listUser.data.length == 0">
                                            <tr class="text-center border border-b-slate-secondary dark:bg-slate-fourth">
                                                <td colspan="6">
                                                    <span class="text-base dark:text-white">No Users Yet.</span>
                                                </td>
                                            </tr>
                                        </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="mt-4 flex items-center justify-between">
                                <p class="dark:text-white">
                                    Pages
                                    <span x-text="listUser.current_page" class="font-semibold"></span> /
                                    <span class="span dark:text-slate-third font-semibold" x-text="listUser.last_page"></span>
                                </p>
                                <ul class="flex items-center justify-center gap-2">

                                    <template x-if="listUser.current_page != 1">

                                        <a @click="paginate(listUser.prev_page_url)" class="w-8 h-8 cursor-pointer leading-7 rounded-full text-center border border-primary dark:border-white hover:bg-primary dark:bg-slate-third hover:text-white transition duration-200 ease-in-out">

                                            <

                                        </a>

                                    </template>

                                    <template x-for="(user, index) in listUser.links">

                                            <template x-if="index != 0 && index != (listUser.links.length - 1) && listUser.last_page > 1">
                                                <li :class="
                                                {
                                                    'bg-active' : listUser.current_page == user.label,
                                                    '' : listUser.current_page != user.label,
                                                }" @click="paginate(user.url); console.log(user.url)" class="w-8 h-8 cursor-pointer leading-7 rounded-full text-center border border-primary dark:border-white hover:bg-primary dark:bg-slate-third hover:text-white dark:hover:text-white transition duration-200 ease-in-out">
                                                {{-- <span x-text="console.log(categoriesArticle)"></span> --}}
                                                    <button
                                                    x-text="user.label">
                                                    </button>
                                                </li>
                                            </template>


                                    </template>

                                    <template x-if="listUser.current_page < listUser.last_page">
                                        <a @click="paginate(listUser.next_page_url)" class="w-8 h-8 cursor-pointer leading-7 rounded-full text-center border border-primary dark:border-white hover:bg-primary dark:bg-slate-third hover:text-white transition duration-200 ease-in-out">

                                            >

                                        </a>
                                    </template>
                                </ul>
                            </div>
                        </div>

                    </template>

                    <template x-if="isLoading == true">
                        <div class="w-full col-12 flex items-center justify-center mt-10">
                            <x-loading />
                        </div>
                    </template>

                </div>

            </div>


            <div class="hidden py-12 bg-gray-700 transition duration-150 ease-in-out z-10 top-0 w-full h-full" id="modal" style="position: fixed; background: rgba(0, 0, 0, 50%)">
                <div role="alert" class="relative top-[13%] lg:top-[11%] container mx-auto w-11/12 md:w-2/3 max-w-lg">
                    <div class="relative py-8 px-5 md:px-10 bg-white shadow-md rounded border border-gray-400">
                        <div class="w-full flex justify-start text-primary mb-3">
                            <i data-feather="bookmark" class="w-14 h-14"></i>
                        </div>
                        <h1 class="text-gray-800 font-lg font-bold tracking-normal leading-tight mb-4">Enter a User</h1>
                        <label for="name" class="text-gray-800 text-sm font-bold leading-tight tracking-normal">Name</label>
                        <input id="name" class="mb-5 mt-2 text-gray-600 font-normal w-full h-10 flex items-center pl-3 text-sm border border-primary rounded-primary" placeholder="Name..." />
                        <label for="price" class="text-gray-800 text-sm font-bold leading-tight tracking-normal">Price</label>
                        <input id="price" class="mb-5 mt-2 text-gray-600 font-normal w-full h-10 flex items-center pl-3 text-sm border border-primary rounded-primary" type="number" placeholder="price..." />
                        <label for="expired" class="text-gray-800 text-sm font-bold leading-tight tracking-normal">Expired</label>
                        <input id="expired" class="mb-5 mt-2 text-gray-600 font-normal w-full h-10 flex items-center pl-3 text-sm border border-primary rounded-primary" type="number" placeholder="expired..." />
                        <button class="cursor-pointer absolute top-0 right-0 mt-4 mr-5 text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out rounded focus:ring-2 focus:outline-none focus:ring-gray-600" onclick="modalHandler()" aria-label="close modal" role="button">
                            <svg  xmlns="http://www.w3.org/2000/svg"  class="icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" />
                                <line x1="18" y1="6" x2="6" y2="18" />
                                <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>
                        </button>
                        <div class="flex items-center justify-start w-full">
                            <button class="focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 transition duration-150 ease-in-out hover:bg-indigo-600 bg-primary hover:text-opacity-80 rounded text-white px-8 py-2 text-sm">Submit</button>
                            <button class="relative overflow-hidden ml-3 bg-gray-100 border border-primary text-slate-primary hover:text-opacity-70 transition duration-150 ease-in-out px-8 py-2 text-sm before:absolute" onclick="modalHandler()">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </template>
    <template x-if="isLoading">
        <div class="w-full col-12 flex items-center justify-center mt-10">
            <x-loading-page />
        </div>
    </template>
</section>

<script>
    let modal = document.getElementById("modal");
    function modalHandler(val) {
        if (val) {
            fadeIn(modal);
        } else {
            fadeOut(modal);
        }
    }
    function fadeOut(el) {
        el.style.opacity = 1;
        (function fade() {
            if ((el.style.opacity -= 0.1) < 0) {
                el.style.display = "none";
            } else {
                requestAnimationFrame(fade);
            }
        })();
    }
    function fadeIn(el, display) {
        el.style.opacity = 0;
        el.style.display = display || "flex";
        (function fade() {
            let val = parseFloat(el.style.opacity);
            if (!((val += 0.2) > 1)) {
                el.style.opacity = val;
                requestAnimationFrame(fade);
            }
        })();
    }
</script>


@endsection
