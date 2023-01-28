@extends("homepage")


@section("content")

<div x-data="user" x-init="checkSession()">
    {{-- <div x-init="fetchMe()"></div> --}}
    <template x-if="isLogedIn && data_user.role == 1">
        <script>
            document.title = 'Dashboard Admin - Freemium App';
        </script>
    </template>
</div>

<style>
    .bg-active {
        background : #7C000D;
        color: white;
    }

    .hidden-prev {
        display: none
    }

    .hidden-next {
        display: none;
    }

    #repeatIcon.active {
        color: #7C000D !important;
        transform: rotate(90deg);
        background-color: transparent;
        transition: .2s ease-in-out;
    }

</style>

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

            <div class="flex flex-wrap lg:flex-nowrap gap-8 container mx-auto px-3 lg:px-0 mt-9" x-data="articles">

                <div class="w-full lg:col-2">
                    @include("pages.admin.layouts.partials.sidebar")
                </div>

                <div class="w-full col-12 lg:col-9">
                    <div x-init="fetchPaginationCategory()"></div>
                    <h2 class="w-full flex items-center justify-center gap-2 py-3 border border-primary dark:border-white dark:bg-slate-secondary rounded-primary text-[20px]">
                        <i class="span dark:text-white font-bold" data-feather="bookmark"></i>
                        <p>
                        <span class="span dark:text-white">Dashboard</span>
                        Admin (Category)
                    </p>
                    </h2>

                    <div class="relative mt-6 mb-10 flex items-center justify-between flex-wrap lg:flex-nowrap gap-y-4">

                        <button class="flex lg:col-2 items-center gap-1 dark:text-white" @click="modalHandlerCategory(true)">
                            <i class="span dark:text-slate-third" data-feather="plus-square"></i>
                            Add Category
                        </button>

                        <div class="w-full flex items-center flex-wrap lg:flex-nowrap gap-2 gap-y-3" style="justify-content: flex-end">
                            <div action="" class="w-full lg:col-4">
                                <div class="p-2 w-full flex items-center justify-between bg-white dark:bg-slate-secondary dark:shadow-none dark:border dark:border-white shadow-[0px_0px_4px_#7C000B] rounded-lg">
                                    <input id="search" x-model="search" @keydown.enter="searchCategory()" type="text" placeholder="Search Here..." class="w-[93%] dark:text-white">
                                    <img class="w-[24px] h-[24px]" src="{{ asset('./assets/images/search.png') }}" alt="">
                                </div>
                            </div>

                            <button @click="sort('name')" type="button" class="group w-full lg:col-2 flex items-center justify-center gap-2 p-2 rounded-primary border border-primary dark:bg-slate-secondary dark:border-white dark:text-slate-fourth transition duration-200 ease-in-out">
                                <p>
                                    <span class="span dark:text-white group-hover:animate-bounce5">Sort By:</span>A/Z
                                </p>
                                <i id="repeatIcon" data-feather="repeat" class="rotate-90 w-4 h-4 text-gray-secondary transition duration-200 ease-in-out"></i>
                            </button>

                        </div>

                    </div>

                    <template x-if="!isLoading">

                        <div>

                            <div class="w-full rounded-primary bg-white shadow-lg">
                                <div class="w-full text-center bg-primary dark:bg-slate-secondary py-2 text-white">List Category</div>
                                <div class="overflow-x-auto">
                                    <table class="w-full overflow-x-scroll items-center bg-transparent border-collapse">
                                        <thead>
                                        <tr>
                                            <th class="px-6 align-middle dark:bg-slate-third dark:text-white border border-primary dark:border-none py-3 text-xs uppercase whitespace-nowrap font-semibold text-left bg-pink-800">Name</th>
                                            <th class="px-6 align-middle dark:bg-slate-third dark:text-white border border-primary dark:border-none py-3 text-xs uppercase whitespace-nowrap font-semibold text-left bg-pink-800">Icon</th>
                                            <th class="px-6 align-middle dark:bg-slate-third dark:text-white border border-primary dark:border-none py-3 text-xs uppercase whitespace-nowrap font-semibold text-left bg-pink-800">Actions</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                            <template x-for="category in categoriesArticle.data">
                                                <tr class="border border-b-primary dark:border-b-slate-secondary dark:bg-slate-fourth dark:text-slate-secondary">
                                                    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 font-semibold" x-text="category.name">Laravel</td>
                                                    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 ">
                                                        <template x-if="category.icon">
                                                            <img x-bind:src="imgUrl+category.icon" src="" class="w-[100px]">
                                                        </template>
                                                        <template x-if="!category?.icon">
                                                            <span class="text-gray-secondary italic">No Icon</span>
                                                        </template>
                                                    </td>
                                                    <td class="flex items-center w-full h-full border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 gap-2">
                                                        <button @click="modalHandlerCategory(true, category.id)" class="w-max hover:text-opacity-60 transition duration-200 ease-in-out" title="Edit">
                                                            <i data-feather="edit" class="w-5 h-5 lg:w-6 lg:h-6"></i>
                                                        </button>
                                                        <button @click="deleteCategory(category.id)" class="w-max hover:text-opacity-60 transition duration-200 ease-in-out" title="Delete">
                                                            <i data-feather="trash-2" class="w-5 h-5 lg:w-6 lg:h-6"></i>
                                                        </button>
                                                    </td>
                                                    <script>
                                                        feather.replace()
                                                    </script>
                                                </tr>
                                            </template>
                                            <template x-if="categoriesArticle.data.length == 0">
                                                <tr class="text-center border border-b-slate-secondary dark:bg-slate-fourth">
                                                    <td colspan="3">
                                                        <span class="text-base dark:text-white">No Categories Yet. </span>
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
                                    <span x-text="categoriesArticle.current_page" class="font-semibold"></span> /
                                    <span class="span dark:text-slate-third font-semibold" x-text="categoriesArticle.last_page"></span>
                                </p>
                                <ul class="flex items-center justify-center gap-2">

                                    <template x-if="categoriesArticle.current_page != 1">

                                        <a @click="paginate(categoriesArticle.prev_page_url)" class="w-8 h-8 cursor-pointer leading-7 rounded-full text-center border border-primary dark:border-white hover:bg-primary dark:bg-slate-third hover:text-white transition duration-200 ease-in-out">

                                            <

                                        </a>

                                    </template>

                                    <template x-for="(category, index) in categoriesArticle.links">

                                            <template x-if="index != 0 && index != (categoriesArticle.links.length - 1) && categoriesArticle.last_page > 1">
                                                <li :class="
                                                {
                                                    'bg-active' : categoriesArticle.current_page == category.label,
                                                    '' : categoriesArticle.current_page != category.label,
                                                }" @click="paginate(category.url); console.log(category.url)" class="w-8 h-8 cursor-pointer leading-7 rounded-full text-center border border-primary dark:border-white hover:bg-primary dark:bg-slate-third hover:text-white dark:hover:text-white transition duration-200 ease-in-out">
                                                {{-- <span x-text="console.log(categoriesArticle)"></span> --}}
                                                    <button
                                                    x-text="category.label">
                                                    </button>
                                                </li>
                                            </template>


                                    </template>

                                    <template x-if="categoriesArticle.current_page < categoriesArticle.last_page">
                                        <a @click="paginate(categoriesArticle.next_page_url)" class="w-8 h-8 cursor-pointer leading-7 rounded-full text-center border border-primary dark:border-white hover:bg-primary dark:bg-slate-third hover:text-white transition duration-200 ease-in-out">

                                            >

                                        </a>
                                    </template>
                                </ul>
                            </div>

                        </div>

                    </template>

                    <template x-if="isLoading">
                        <div class="w-full col-12 flex items-center justify-center mt-10">
                            <x-loading />
                        </div>
                    </template>

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
                        <div class="my-4">
                            <label for="name" class="text-gray-800 text-sm font-bold leading-tight tracking-normal">Name</label>
                            <input id="name" x-bind:class="status_err.name ? 'bg-primary' : ''" class="mt-2 text-gray-600 font-normal w-full h-10 flex items-center pl-3 text-sm border border-primary dark:border-white rounded-primary" placeholder="Name..." />
                        </div>
                        <template x-if="status_err.name">
                            <div class="mt-3 flex text-[#b91c1c] items-center gap-2 mb-5">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                <span class="span-danger" x-text="status_err.name[0]">Validasi Error</span>
                            </div>
                        </template>
                        <div class="my-4">
                            <label for="icon" class="text-gray-800 text-sm font-bold leading-tight tracking-normal">Icon</label>
                            <input id="icon" x-bind:class="status_err.name ? 'bg-primary' : ''" type="file" class="mt-2 text-gray-600 font-normal w-full h-10 flex items-center px-3 py-2 text-sm border border-primary dark:border-white rounded-primary" placeholder="Icon..." />
                            <template x-if="status_err.icon">
                                <div class="mt-3 flex text-[#b91c1c] items-center gap-2 mb-5">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                    <span class="span-danger" x-text="status_err.icon[0]">Validasi Error</span>
                                </div>
                            </template>
                        </div>
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
    </template>

    <template x-if="isLoading">
        <div class="w-full col-12 flex items-center justify-center mt-10">
            <x-loading-page />
        </div>
    </template>

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
