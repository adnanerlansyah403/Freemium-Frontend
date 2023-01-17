@extends("homepage")


@section("content")

<div x-data="user" x-init="checkSession()">
    <div x-init="fetchMe()"></div>
    <template x-if="isLogedIn && data_user.role == 1">
        <script>
            document.title = 'Dashboard Admin - Freemium App';
        </script>
    </template>
</div>

<section class="py-[100px]" x-data="user" x-init="checkSession()" style="display: none;">
    <div x-init="checkRole()"></div>
    <div
    x-init="
        if(isLogedIn == true) {
            setTimeout(function() {
                return document.querySelector('section').style.display = 'block';
            }, 1000)
        }"
    >


        @include("layouts.partials.user.dashboard")

        <div class="flex flex-wrap lg:flex-nowrap gap-8 container mx-auto px-3 lg:px-0 mt-9">

            <div class="w-full lg:col-2">
                @include("pages.admin.layouts.partials.sidebar")
            </div>

            <div class="w-full col-12 lg:col-9">
                
                <h2 class="w-full flex items-center justify-center gap-2 py-3 border border-primary dark:border-white dark:bg-slate-secondary rounded-primary text-[20px]">
                    <i class="span dark:text-white font-bold" data-feather="bookmark"></i>
                    <p>
                    <span class="span dark:text-white">Dashboard</span>
                    Admin (Category)
                </p>
                </h2>

                <div class="relative mt-6 mb-10 flex items-center justify-between flex-wrap lg:flex-nowrap gap-y-4" x-data="user">

                    <button class="flex lg:col-2 items-center gap-1 dark:text-white" @click="modalHandlerCategory(true)">
                        <i class="span dark:text-slate-third" data-feather="plus-square"></i>
                        Add Category
                    </button>

                    <div class="w-full flex items-center flex-wrap lg:flex-nowrap gap-2 gap-y-3" style="justify-content: flex-end">
                        <form action="" class="w-full lg:col-4">
                            <div class="p-2 w-full flex items-center justify-between bg-white dark:bg-slate-secondary dark:shadow-none dark:border dark:border-white shadow-[0px_0px_4px_#7C000B] rounded-lg">
                                <input id="search" name="search" type="text" placeholder="Search Here..." class="w-[93%] dark:text-white">
                                <img class="w-[24px] h-[24px]" src="{{ asset('./assets/images/search.png') }}" alt="">
                            </div>
                        </form>

                        <button class="group w-full lg:col-2 flex items-center justify-center gap-2 p-2 rounded-primary border border-primary dark:bg-slate-secondary dark:border-white dark:text-slate-fourth transition duration-200 ease-in-out">
                            <p>
                                <span class="span dark:text-white group-hover:animate-bounce5">Sort By:</span>A/Z
                            </p>
                            <i data-feather="repeat" class="rotate-90 w-4 h-4 text-gray-secondary group-hover:-rotate-90 dark:group-hover:text-white transition duration-200 ease-in-out"></i>
                        </button>

                    </div>

                </div>

                <div class="w-full rounded-primary bg-white shadow-lg">
                    {{-- <div x-data="user">
                        <div x-init="flash()"></div>
                        <div x-show="showFlash">
                            <x-alert />
                        </div>
                    </div> --}}
                    <div class="w-full text-center bg-primary dark:bg-slate-secondary py-2 text-white">List Category</div>
                    <div class="overflow-x-auto" x-data="articles">
                        <div x-init="getCategories()"></div>
                        <table class="w-full overflow-x-scroll items-center bg-transparent border-collapse">
                            <thead>
                              <tr>
                                <th class="px-6 align-middle dark:bg-slate-third dark:text-white border border-primary dark:border-none py-3 text-xs uppercase whitespace-nowrap font-semibold text-left bg-pink-800">Name</th>
                                <th class="px-6 align-middle dark:bg-slate-third dark:text-white border border-primary dark:border-none py-3 text-xs uppercase whitespace-nowrap font-semibold text-left bg-pink-800">Icon</th>
                                <th class="px-6 align-middle dark:bg-slate-third dark:text-white border border-primary dark:border-none py-3 text-xs uppercase whitespace-nowrap font-semibold text-left bg-pink-800">Actions</th>
                              </tr>
                            </thead>
                    
                            <tbody>
                                <template x-for="category in categoriesArticle">
                                    <tr class="border border-b-primary dark:border-b-slate-secondary dark:bg-slate-fourth dark:text-slate-secondary">
                                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 font-semibold" x-text="category.name">Laravel</td>
                                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 ">
                                            <img x-bind:src="imgUrl+category.icon" src="" class="w-[100px]">
                                        </td>
                                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 flex items-center gap-2">
                                            <button @click="modalHandlerCategory(true, category.id)" class="hover:text-opacity-60 transition duration-200 ease-in-out" title="Edit">
                                                <i data-feather="edit" class="w-5 h-5 lg:w-6 lg:h-6"></i>
                                            </button>
                                            <button @click="deleteCategory(category.id)" class="hover:text-opacity-60 transition duration-200 ease-in-out" title="Delete">
                                                <i data-feather="trash-2" class="w-5 h-5 lg:w-6 lg:h-6"></i>
                                            </button>
                                        </td>
                                        <script>
                                            feather.replace()
                                        </script>
                                    </tr>
                                </template>
                                <template x-if="categoriesArticle.length == 0">
                                    <tr class="text-center border border-b-slate-secondary dark:bg-slate-fourth">
                                        <td colspan="3">
                                            <span class="text-base dark:text-white">Empty Data</span>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-4">
                    <ul class="flex items-center justify-center gap-2">
                        <li class="w-8 h-8 cursor-pointer leading-7 rounded-full text-center border border-primary dark:border-white hover:bg-primary dark:bg-slate-third hover:text-white transition duration-200 ease-in-out">
                            <a href="" class="">1</a>
                        </li>
                        <li class="w-8 h-8 cursor-pointer leading-7 rounded-full text-center border border-primary dark:border-white hover:bg-primary dark:bg-slate-third hover:text-white transition duration-200 ease-in-out">
                            <a href="" class="">2</a>
                        </li>
                        <li class="w-8 h-8 cursor-pointer leading-7 rounded-full text-center border border-primary dark:border-white hover:bg-primary dark:bg-slate-third hover:text-white transition duration-200 ease-in-out">
                            <a href="" class="">3</a>
                        </li>
                    </ul>
                </div>

            </div>

        </div>

        
        <div class="hidden py-12 bg-gray-700 transition duration-150 ease-in-out z-10 top-0 w-full h-full" id="modal" style="position: fixed; background: rgba(0, 0, 0, 50%)" x-data="user">
            <div role="alert" class="relative top-[13%] lg:top-[11%] container mx-auto w-11/12 md:w-2/3 max-w-lg">
                <div class="relative py-8 px-5 md:px-10 bg-white dark:text-white dark:bg-slate-secondary shadow-md rounded border border-gray-400">
                    <div class="w-full flex justify-start text-primary dark:text-slate-third mb-3">
                        <i data-feather="bookmark" class="w-14 h-14"></i>
                    </div>
                    <h1 class="text-gray-800 font-lg font-bold tracking-normal leading-tight mb-4">Enter a Category</h1>
                    <input type="hidden" id="category_id" value="0">
                    <label for="name" class="text-gray-800 text-sm font-bold leading-tight tracking-normal">Name</label>
                    <input id="name" class="mb-5 mt-2 text-gray-600 font-normal w-full h-10 flex items-center pl-3 text-sm border border-primary dark:border-white rounded-primary" placeholder="Name..." style="border: 1px solid white;" />
                    <label for="icon" class="text-gray-800 text-sm font-bold leading-tight tracking-normal">Icon</label>
                    <input id="icon" type="file" class="mb-5 mt-2 text-gray-600 font-normal w-full h-10 flex items-center px-3 py-2 text-sm border border-primary dark:border-white rounded-primary" placeholder="Icon..." style="border: 1px solid white" />
                    <button class="cursor-pointer absolute top-0 right-0 mt-4 mr-5 text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out rounded focus:ring-2 focus:outline-none focus:ring-gray-600" @click="modalHandlerCategory()" aria-label="close modal" role="button">
                        <svg  xmlns="http://www.w3.org/2000/svg"  class="icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" />
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </button>
                    <div class="flex items-center justify-start w-full">
                        <button @click="actionCategory()" class="focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 transition duration-150 ease-in-out hover:bg-indigo-600 bg-primary dark:bg-slate-third hover:text-opacity-80 rounded text-white px-8 py-2 text-sm">Submit</button>
                        <button class="relative overflow-hidden ml-3 bg-gray-100 border border-primary dark:border-white dark:text-white text-slate-primary hover:text-opacity-70 transition duration-150 ease-in-out px-8 py-2 text-sm before:absolute" @click="modalHandlerCategory()">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        


    </div>
</section>

<script>
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