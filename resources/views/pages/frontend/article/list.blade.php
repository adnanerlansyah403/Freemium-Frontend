@extends("homepage")

@section("title", "List - Freemium App")

@section("content")

<style>


.category.active {
    background-color: #fff;
    color: #7C000B;
    border: none;
}

#freeFilter.active {
    background-color: #7C000B;
    color: #fff
}

#paidFilter.active {
    background-color: #7C000B;
    color: #fff
}

.content {
  width: 100%;
  /* display: none; */
}

.bg-active {
        background : #7C000D;
        color: white;
    }

.noContent {
  color: #000 !important;
  background-color: transparent !important;
  pointer-events: none;
  outline: none !important;
}

</style>

<section class="lg:px-[12px] py-[120px]" x-data="user">
    <div x-init="fetchMe()"></div>
    {{-- alert --}}
    <div x-init="flash()"></div>
    <div x-show="showFlash" x-init="setTimeout(() => {
        showFlash = false
        }, 4000);
    ">
        <x-alert />
    </div>


        <div class="container mx-auto" x-data="articles">
            <span x-init="resetFilters()"></span>
            <div x-init="getArticle()"></div>

            <template x-if="!isLoadingArticle">

                <div class="col-12">

                    <div class="px-3 lg:px-0 flex items-center justify-between">
                        <h1 class=" font-poppins text-base lg:text-md font-semibold mb-4 dark:text-white">Article Search Results</h1>
                        <button x-on:click="resetFilters()" class="text-base font-medium flex items-center gap-1 hover:text-gray-secondary dark:hover:text-opacity-80 dark:text-white transition duration-200 ease-in-out">
                            <i data-feather="filter"></i>
                            Reset Filters
                        </button>
                    </div>

                    <div class="px-3 lg:px-0">
                        <div class=" md:px-0 flex items-center justify-between bg-white shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-pill w-full">
                            <input type="text" class="py-2 px-4 text-sm w-full" x-ref="search"
                            x-bind:value="filtersKey[0] ? filtersKey[0] : ''"
                            x-on:change="filtersKey[0] = $event.target.value; filterArticle()" 
                            placeholder="Search article title....">
                            <button @click="
                                if(filtersKey[0] != '') {
                                    filterArticle()
                                }
                            " class="text-sm lg:text-base translate-x-[2px] flex items-center px-4 py-2 gap-2 bg-primary dark:bg-slate-secondary rounded-r-pill text-white dark:text-white">
                                <i data-feather="search" class="text-white dark:text-gray-secondary"></i>
                                <span>Search</span>
                            </button>
                        </div>
                    </div>

                    <div class="px-3 lg:px-0 md:px-0 mt-4 w-full flex items-start justify-between gap-4">
                        {{-- <div class="w-full flex flex-wrap gap-[11px]" x-init="getCategories()">
                            <select name="category" x-on:change="filtersKey[2] = $event.target.value; filterArticle()" id="category" class="text-sm py-2 px-3 rounded-[10px] border-solid border border-primary dark:border-white w-full bg-white dark:bg-slate-primary dark:text-white font-medium" x-ref="category">
                                <option value="" @click="getCategories()">  Select a category... </option>
                                <template x-for="(item, index) in categoriesArticle">
                                    <option x-bind:value="item.id" x-text="item.name" ></option>
                                </template>
                            </select>
                        </div> --}}
                        <div class="relative flex items-center flex-wrap gap-[6px]" x-init="getCategories()"
                        x-data="{categoryShow: false, categoryActive: false}">
                            <template x-for="(item, index) in categoriesArticle.slice(0, 8)">
                                <span 
                                x-bind:id="'category'+item.id"
                                x-on:click="
                                    filterArticle(item.id);
                                    let category = document.getElementById(`category${item.id}`);
                                    if(category.classList.contains('active')) {
                                        category.classList.remove('active');
                                    } else {
                                        category.classList.add('active');
                                    }
                                "
                                class="category cursor-pointer px-2 py-1 text-xs font-medium rounded-pill text-white bg-primary dark:bg-slate-secondary hover:text-opacity-80 dark:hover:text-opacity-80 transition duration-200 ease-in-out" x-text="item.name">Javascript</span>
                            </template>
                            <div x-on:click="getCategories(true)">
                                <button class="px-4 py-1 border border-primary rounded-pill text-slate-primary font-medium dark:border dark:border-white dark:bg-white dark:text-black text-sm hover:text-opacity-80 dark:hover:text-opacity-80 transition duration-200 ease-in-out" @click="categoryShow = !categoryShow">
                                    More
                                </button>
                                <div class="fixed top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2 grid place-items-center z-[100]">
                                    <div class="bg-white p-2 rounded-primary w-[350px] lg:w-[400px] shadow-[0px_0px_8px_rgba(0,0,0,0.25)] pr-4 transition duration-200 ease-in-out" x-show="categoryShow" x-transition>
                                        <div class="flex items-center justify-between w-full">
                                            <h3 class="font-medium font-poppins text-base"><span class="span dark:text-slate-third">Category</span> List </h3>
                                            <span @click="categoryShow = false" class="text-black text-base hover:text-opacity-80 font-medium cursor-pointer">
                                                <i data-feather="x"></i>
                                            </span>
                                        </div>
                                        <ul class="max-h-[200px] overflow-y-auto has-scrollbar2 flex items-center flex-wrap gap-2 mt-2">
                                            {{-- <li class="mb-6">
                                                <span class="span">Category</span> List
                                            </li> --}}
                                            <template x-for="(item, index) in categoriesArticle.slice(8)">
                                                <li class="cursor-pointer px-2 py-1 text-xs font-medium rounded-primary text-white bg-primary dark:bg-slate-secondary hover:text-opacity-80 dark:hover:text-opacity-80 transition duration-200 ease-in-out">
                                                    <span x-text="item.name" x-bind:id="'categoryModal'+item.id"
                                                        x-on:click="
                                                            filterArticle(item.id);
                                                            let category = document.getElementById(`categoryModal${item.id}`);
                                                            if(category.classList.contains('active')) {
                                                                category.classList.remove('active');
                                                            } else {
                                                                category.classList.add('active');
                                                            }
                                                    "></span>
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button x-ref="paidFilter" 
                            x-on:click="
                                filtersKey[1] = filtersKey[1] != 'paid' ? 'paid' : '';
                                filterArticle();
                                $refs.freeFilter.classList.remove('active');
                                if($refs.paidFilter.classList.contains('active')) {
                                    $refs.paidFilter.classList.remove('active');
                                } else {
                                    $refs.paidFilter.classList.add('active');
                                }
                            "
                            id="paidFilter" 
                            class="px-4 py-1 border border-primary rounded-pill text-black dark:text-white font-medium dark:border dark:border-white dark:bg-slate-secondary text-sm hover:text-opacity-80 dark:hover:text-opacity-80 transition duration-200 ease-in-out">
                                <span>PAID</span>
                            </button>
                            <button x-ref="freeFilter" 
                            x-on:click="
                                filtersKey[1] = filtersKey[1] != 'free' ? 'free' : '';
                                filterArticle();
                                $refs.paidFilter.classList.remove('active');
                                if($refs.freeFilter.classList.contains('active')) {
                                    $refs.freeFilter.classList.remove('active');
                                } else {
                                    $refs.freeFilter.classList.add('active');
                                }
                            "
                            id="freeFilter" class="px-4 py-1 border border-primary rounded-pill text-black dark:text-white font-medium dark:border dark:border-white dark:bg-slate-secondary text-sm hover:text-opacity-80 dark:hover:text-opacity-80 transition duration-200 ease-in-out">
                                <span>FREE</span>
                            </button>
                        </div>
                    </div>

                    <template x-if="localStorage.getItem('token') && !data_user?.subscribe_status && isLoading == false">
                        <div id="getUnlimitedAccess" class="mt-8 text-center py-6 container mx-auto max-w-max rounded-lg" style="display: none;"
                        x-init="
                            setTimeout(function() {
                                document.getElementById('getUnlimitedAccess').style.display = 'block';
                            }, 600)
                        ">
                            <p class="text-[20px] lg:text-md text-black font-medium font-poppins mb-6 dark:text-white">Get Unlimited Access Now for All Content</p>
                            <a href="{{ route('transaction.create') }}" class="px-4 py-2 rounded-pill bg-primary dark:bg-black text-white text-sm lg:text-base dark:border dark:border-white hover:text-opacity-80 transition-none duration-200 ease-in-out">Join Now</a>
                        </div>
                    </template>

                    <template x-if="!isLoading">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-6" x-data="helpers" style="margin-top: 32px;">
                            <template x-for="(item, index) in listArticle.data">
                                <div class="dark:border dark:border-white md:dark:rounded-lg hover:-translate-y-2 dark:hover:shadow-[0px_2px_8px_rgba(255,255,255,.30)] transition duration-200 ease-linear">
                                    <figure class="bg-no-repeat w-full h-[270px] rounded-none md:rounded-t-[6px] overflow-hidden relative bg-primary dark:bg-slate-secondary">
                                        <img x-bind:src="imgUrl+item.thumbnail" class="w-full h-full object-cover dark:text-white" onerror="this.style.opacity = 0" onload="this.style.opacity = 1" x-bind:alt="`${item.title}.png is not found`">
                                    </figure>
                                    <div class="relative h-[230px] pt-12 dark:bg-[#111] shadow-lg dark:shadow-none flex-1 rounded-none md:rounded-b-[6px] overflow-hidden px-3 pb-6">
                                        <div class="flex items-center justify-between w-full absolute top-4 left-0 px-3">
                                            <button class="flex items-center gap-1 text-black font-bold text-sm leading-[21px] rounded-[10px]"
                                            x-on:click="
                                                if(item.type == 'free') {
                                                    getFreeArticle()
                                                } else {
                                                    getPaidArticle()
                                                }
                                            ">
                                                <template x-if="item.type == 'paid'">
                                                    <span class="text-primary dark:text-white">
                                                        <i data-feather="lock"></i>
                                                        <script style="display: none;">
                                                            feather.replace()
                                                        </script>
                                                    </span>
                                                </template>
                                                <template x-if="item.type == 'free'">
                                                    <span class="text-primary dark:text-white">
                                                        <i data-feather="unlock"></i>
                                                        <script style="display: none;">
                                                            feather.replace()
                                                        </script>
                                                    </span>
                                                </template>
                                                <span x-text="item.type.charAt(0).toUpperCase() + item.type.slice(1)" class="text-primary dark:text-white"></span>
                                            </button>
                                            <div class="flex items-center gap-2 dark:text-white">
                                                <time class="text-[14px]" x-text="convertDate(item.created_at)"></time>
                                                <template x-if="!checkExists(listView, item.id)">
                                                    <p class="flex items-center gap-1 text-[14px]">
                                                        <i data-feather="eye" class="w-4 h-4"></i>
                                                        <span x-text="'No views'">
                                                            1000
                                                        </span>
                                                        <script>
                                                            feather.replace()
                                                        </script>
                                                    </p>
                                                </template>
                                            </div>
                                        </div>
                                        <a x-bind:href="baseUrl + `article/detail/${item.id}`" class="font-bold text-[20px] font-lato leading-9 dark:text-white" x-text="item.title.length > 30 ? item.title.substring(0, 30) + '...' : item.title"></a>
                                        <p class="font-normal text-sm dark:text-gray-primary"
                                        x-text="item.description.length > 120 ? parseToOriginalString(item.description, 120) : item.description">

                                        </p>
                                        <a x-bind:href="baseUrl + `article/detail/${item.id}`" class="group flex items-center gap-1 absolute bottom-0 -translate-y-4 px-4 py-1 border border-primary text-primary dark:text-white dark:border-white dark:hover:bg-white dark:hover:text-slate-primary font-poppins font-medium transition duration-200 ease-in-out">
                                            Read More
                                            <span class="group-hover:translate-x-1 translate-y-0 transition duration-200 ease-linear">
                                                <i class="bi bi-arrow-right"></i>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                        </div>
                    </template>

                </div>

            </template>

            <template x-if="isLoading">
                <x-loading />
            </template>

            <template x-if="listArticle.data.length == 0">
                <div x-ref="articleNotFound" class="flex flex-col items-center justify-center text-md mt-10 dark:text-white"
                >
                    <img src="{{ asset("assets/images/nodata.svg") }}" class="h-[200px] w-[200px] mx-auto mb-6" alt="">
                    <p>
                        <span class="span dark:text-slate-fourth" x-text="filtersKey[0] != '' ? 'Oops' : 'Sorry'"></span>
                        <span x-text="filtersKey[0] != '' ? ', We can not find your article' : ', We still have not an article'"></span>
                    </p>
                    <template x-if="filtersKey[0] == '' && listArticle.data.length == 0">
                        <div class="flex items-center justify-center mt-6">
                            <a href="{{ route("article.create") }}" class="py-2 px-4 border border-primary dark:border-white rounded-pill text-sm font-medium text-center hover:bg-primary hover:text-white dark:bg-slate-secondary dark:hover:text-opacity-80 transition duration-200 ease-in-out">
                                Create One
                            </a>
                        </div>
                    </template>
                </div>
            </template>

            <template x-if="listArticle.data.length != 0">
                <div class="flex items-center justify-center gap-4 translate-y-14 dark:text-white">
                    <template x-if="listArticle.current_page != 1">
                            <
                            <a @click="paginateArticle(listArticle.prev_page_url)" class="cursor-pointer text-base font-semibold hover:text-primary dark:text-white dark:hover:text-opacity-80 transition duration-200 ease-in-out">
                                <i class="bi bi-arrow-left"></i>
                            </a>
                        </a>

                    </template>
                    <b class="font-semibold">
                        Halaman <span x-text="listArticle.current_page">1</span> dari <span class="span dark:text-slate-fourth" x-text="listArticle.last_page">200</span>
                    </b>
                    <template x-if="listArticle.current_page < listArticle.last_page">
                        <a @click="paginateArticle(listArticle.next_page_url)" class="cursor-pointer text-base font-semibold hover:text-primary dark:text-white dark:hover:text-opacity-80 transition duration-200 ease-in-out">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </template>
    
                </div>
            </template>


            </template>

            <template x-if="isLoadingArticle">
                <x-loading-page />
            </template>

        </div>




</section>

<x-top-button />

@endsection
