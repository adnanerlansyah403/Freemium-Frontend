{{-- @section("title", "Me - Freemium App") --}}

{{-- Title Section --}}
<div x-data="user" x-init="checkSession()">
    <template x-if="isLogedIn">
        <script>
            document.title = 'Me - Freemium App';
        </script>
    </template>
</div>

<section class="pt-[140px] pb-[100px]" x-data="user" x-init="checkSession()" >
    <div x-init="fetchMe()"></div>
    <div x-init="checkRoleUser()"></div>
    <div x-init="fetchListMyArticle()"></div>
            
    <div x-init="flash()"></div>
    <div x-show="showFlash">
        <x-alert />
    </div>
    
    <template x-if="!isLoading">
        <div>
    
            <h1 class="font-iceberg text-lg text-center text-primary dark:text-white mb-16">ME</h1>
        
            @include("layouts.partials.user.dashboard")
        
            <div x-init="fetchMe()"></div>
        
            <div class="container mx-auto mt-10 w-full dark:text-white">
                
                <template x-if="!isLoading">
                    <div x-data="helpers">
                        <div class="flex items-center lg:gap-6 mb-10" x-data="{ resetShow: false }"
                            {{-- x-on:mouseleave="resetShow = false"
                            x-on:mouseover="resetShow = true" --}}
                        >
                            <div class="group relative h-[44px] col col-12 lg:mx-0 w-full rounded-[10px] border-solid border border-primary dark:border-white overflow-hidden">
                                <div class="flex justify-between">
                                    <div class="w-full">
                                        <input
                                            x-model="keywordMyArticle"
                                            x-on:change="
                                            searchMyArticle(keywordMyArticle);
                                            "
                                            {{-- x-on:keyup="resetShow = true"
                                            x-on:mouseover="resetShow = true"
                                            x-on:keydown="resetShow = false" --}}
                                            class="w-[85%] md:w-[95%] lg:w-full block translate-x-8 text-[#8B8585] py-2.5 px-3 font-normal text-sm transition duration-200 ease-in-out"
                                            placeholder="Search Here..." />
                                        <img class="group-hover:translate-x-0 w-[24px] h-[24px] absolute left-2 top-2 transition duration-200 ease-in-out" src="{{ asset('./assets/images/search.png') }}" alt="">
                                    </div>
                                    {{-- <button type="button" @click="" class="cursor-pointer p-2 h-full hover:text-opacity-80 dark:hover:text-opacity-80 rounded-r-lg transition duration-200 ease-in-out">
                                        Search
                                    </button> --}}
                                </div>
                            </div>
                            {{-- <div class="col" style="margin-left: 0;">
                                <button @click="keywordMyArticle = ''; fetchListMyArticle();  itemMyArticle = 3;" class="px-6 py-2 border border-primary dark:border-white hover:bg-primary dark:hover:bg-white hover:text-white dark:hover:text-slate-secondary rounded-pill transition duration-200 ease-in-out">
                                    Reset
                                </button>
                            </div> --}}
                        </div>

                        <template x-if="isLoadingMyArticle">
                            <div class="flex items-center justify-center my-10">
                                <x-loading />
                            </div>
                        </template>

                        
                        <template x-if="!isLoadingMyArticle">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-4">
                                <template x-for="(item, index) in listMyArticle">
                                    
                                    
                                    <article class="bg-white shadow-lg dark:hover:shadow-[0_0_4px_2px_#fff] dark:bg-[#111] w-[370px] rounded-lg max-w-max transition duration-400 ease-in-out">
                                        <div class="bg-no-repeat h-[220px] rounded-t-lg overflow-hidden relative">
                                            <figure class="bg-primary dark:bg-slate-secondary w-full h-full">
                                                <img x-bind:src="imgUrl+item.thumbnail" alt="" onerror="this.style.opacity = 0" onload="this.style.opacity = 1" class="h-full w-full object-cover">
                                            </figure>
                                            <template x-if="item.type == 'paid'">
                                                <span class="absolute left-3 top-3 bg-primary text-white dark:bg-slate-secondary p-2" title="PAID">
                                                    <i data-feather="lock" class="text-sm rounded-lg"></i>
                                                    <script>
                                                        feather.replace()
                                                    </script>
                                                </span>
                                            </template>
                                            <template x-if="item.type == 'free'">
                                                <span class="absolute left-3 top-3 bg-primary text-white dark:bg-slate-secondary p-2 "title="FREE">
                                                    <i data-feather="unlock" class="text-sm rounded-lg"></i>
                                                    <script>
                                                        feather.replace()
                                                    </script>
                                                </span>
                                            </template>
                                        </div>
                                        <div class="relative h-[230px] dark:bg-[#111] flex-1 rounded-b-lg overflow-hidden px-3 pt-4 pb-6">
                                            <div class="flex items-center gap-2">
                                                <p class="text-sm">
                                                    <span class="flex items-center gap-1" 
                                                    x-text="convertDate(item.created_at)">
                                                        <i data-feather="calendar" class="w-4 h-4"></i>
                                                    </span>
                                                </p>
                                                <template x-for="list in listMyView">
                                                    <template x-if="list.id === item.id">
                                                        <p class="flex items-center gap-1 text-[14px] text-white">
                                                            <span x-text="console.log(list.total)"></span>
                                                            <i data-feather="eye" class="w-4 h-4"></i>
                                                            <span x-text="list.total">
                                                                1000
                                                            </span>
                                                            <script>
                                                                feather.replace()
                                                            </script>
                                                        </p>
                                                    </template>
                                                </template>
                                            </div>
                                            <div class="flex items-start mt-2">
                                                <a x-bind:href="baseUrl + `article/detail/${item.id}`" class="text-[22px] font-lato font-bold" x-text="substring(item.title, 30)"></a>
                                            </div>
                                            <p class="font-normal text-sm dark:text-gray-primary"
                                            x-text="item.description.length > 80 ? parseToOriginalString(item.description, 80) : item.description">
                
                                            </p>
                                            <div class="absolute -bottom-2 -translate-y-5 flex items-center gap-3 mt-6">
                                                <a x-bind:href="baseUrl+`article/edit/${item.id}`" @click="Article['id'] = item.id" class="w-max p-2 rounded-full outline outline-1 outline-primary dark:outline-slate-third hover:bg-primary dark:hover:bg-white hover:text-white dark:hover:text-slate-primary hover:outline-none transition duration-200 ease-in-out">
                                                    <i data-feather="edit"></i>
                                                    <script>
                                                        feather.replace()
                                                    </script>
                                                </a>
                                                <button href="#" x-on:click="deleteArticle(item.id)" class="w-max p-2 rounded-full outline outline-1 outline-primary dark:outline-slate-third hover:bg-primary dark:hover:bg-white hover:text-white dark:hover:text-slate-primary hover:outline-none transition duration-200 ease-in-out">
                                                    <i data-feather="trash-2"></i>
                                                    <script>
                                                        feather.replace()
                                                    </script>
                                                </button>
                                            </div>
                                        </div>
                                    </article>
    
                                    {{-- <div class="group flex items-center flex-wrap lg:flex-nowrap justify-center lg:justify-between mb-10 gap-6">
                                        <div class="relative z-10 flex lg:items-start flex-wrap lg:flex-nowrap lg:justify-between col lg:col-10 bg-white lg:mx-0 px-4 py-3 shadow-[0px_0px_4px_rgba(0,0,0,0.25)] h-full lg:max-h-[200px] lg:h-[200px] dark:bg-slate-secondary rounded-lg overflow-hidden">
                                            <div class="col lg:col-9 col:12" style="margin: 0 !important;">
                                                <div class="flex items-center gap-3">
                                                    <p class="text-sm">
                                                        <span class="flex items-center gap-1" 
                                                        x-text="convertDate(item.created_at)">
                                                            <i data-feather="calendar" class="w-4 h-4"></i>
                                                        </span>
                                                    </p>
                                                    <template x-for="list in listMyView">
                                                        <template x-if="list.id === item.id">
                                                            <p class="flex items-center gap-1 text-[14px]">
                                                                <i data-feather="eye" class="w-4 h-4"></i>
                                                                <span x-text="list.total">
                                                                    1000
                                                                </span>
                                                                <script>
                                                                    feather.replace()
                                                                </script>
                                                            </p>
                                                        </template>
                                                    </template>
                                                    <template x-if="!checkExists(listMyView, item.id)">
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
                                                <div class="pb-4 pt-12 lg:py-0 lg:translate-y-5">
                                                    <div class="flex flex-wrap lg:flex-nowrap items-start gap-4 mb-4">
                                                        <a x-bind:href="baseUrl + `article/detail/${item.id}`" class="text-[22px] md:text-md font-lato font-bold" x-text="substring(item.title, 70)"></a>
                                                        <i class="bg-primary dark:bg-slate-third px-4 py-2 rounded-primary text-white font-bold" x-text="item.type.charAt(0).toUpperCase() + item.type.slice(1)"></i>
                                                    </div>
                                                    <p class="text-sm text-gray-secondary mt-8 w-full" x-html="parseToOriginalString(item.substring, 150)+'...'">
                    
                                                    </p>
                                                </div>
                                            </div>
                                            <template x-if="item.thumbnail != ''">
                                                <figure class="col col-2 h-full hidden lg:flex items-center justify-end" style="margin: 0 !important;">
                                                    <img x-bind:src="imgUrl+item.thumbnail" class="w-full h-full bg-gray-primary rounded-lg" alt="">
                                                </figure>
                                            </template>
                                            <template x-if="item.thumbnail == ''">
                                                <figure class="bg-slate-secondary dark:bg-white rounded-lg col col-2 h-full hidden lg:flex items-center justify-end" style="margin: 0 !important;">
                                                </figure>
                                            </template>
                                            <div class="absolute right-4 md:hidden flex flex-row md:flex-col items-center lg:items-start gap-2">
                                                <a x-bind:href="baseUrl+`article/edit/${item.id}`" @click="Article['id'] = item.id" class="w-max p-2 rounded-full outline outline-1 outline-primary dark:outline-slate-third hover:bg-primary dark:hover:bg-white hover:text-white dark:hover:text-slate-primary hover:outline-none transition duration-200 ease-in-out">
                                                    <i data-feather="edit"></i>
                                                </a>
                                                <button href="#" x-on:click="deleteArticle(item.id)" class="w-max p-2 rounded-full outline outline-1 outline-primary dark:outline-slate-third hover:bg-primary dark:hover:bg-white hover:text-white dark:hover:text-slate-primary hover:outline-none transition duration-200 ease-in-out">
                                                    <i data-feather="trash-2"></i>
                                                </button>
                                            </div>
                
                                            <script>
                                                feather.replace()
                                            </script>
                                        </div>
                
                                        <div class="relative hidden z-[1] col col-2 lg:col-1 lg:flex flex-row md:flex-col items-center lg:items-start gap-4">
                                            <a x-bind:href="baseUrl+`article/edit/${item.id}`" @click="Article['id'] = item.id" class="w-max p-2 rounded-full outline outline-1 outline-primary dark:outline-slate-third hover:bg-primary dark:hover:bg-white hover:text-white dark:hover:text-slate-primary hover:outline-none -translate-x-[300%] group-hover:translate-x-[-25%] transition delay-100 duration-200 ease-in-out">
                                                <i data-feather="edit"></i>
                                            </a>
                                            <button href="#" x-on:click="confirm('Do you want to delete this article?') ? deleteArticle(item.id) : ''" class="w-max p-2 rounded-full outline outline-1 outline-primary dark:outline-slate-third hover:bg-primary dark:hover:bg-white hover:text-white dark:hover:text-slate-primary hover:outline-none -translate-x-[300%] group-hover:translate-x-[-25%] transition delay-200 duration-200 ease-in-out">
                                                <i data-feather="trash-2"></i>
                                            </button>
                                        </div>
                
                                    </div> --}}
                
                                </template>
                            </div>
                        </template>
                        
                    </div>
                </template>
    
                <template x-if="listMyArticle.length > 1 && listMyArticle.length > itemMyArticle">
                    
                    {{-- <div>
                        <template x-if="isLoadMore">
                            <div class="flex items-center justify-center">
                                <span class="span dark:text-slate-third">Loading...</span>
                            </div>
                        </template>
                        
                        <template x-if="!isLoadingMyArticle">
                            <div class="flex items-center justify-center">
                                <button @click="
                                loadMoreMyArticle()
                                " id="loadMore" class="px-4 py-2 outline outline-1 outline-primary dark:outline-white rounded-pill text-primary dark:text-white hover:bg-primary dark:bg-slate-secondary hover:outline-none hover:text-white transition duration-200 ease-in-out">Load More</button>
                            </div>
                        </template>
                    </div> --}}
                
                </template>
                
                <template x-if="listMyArticle.length == 0">
                    <div>
                        <img src="{{ asset("assets/images/nodata.svg") }}" class="h-[200px] w-[200px] mx-auto mb-4" alt="">
                        <h1 class="text-center text-md"><span class="span dark:text-slate-third">Oops</span>, You don't have an article</h1>
                    </div>
                </template>


                <template x-if="listMyArticle.length != 0">
                    <div class="flex items-center justify-center gap-4 translate-y-14 dark:text-white">
                        <b class="font-semibold">
                            Halaman <span>1</span> dari <span class="span dark:text-slate-fourth">200</span>
                        </b>
                        <a class="cursor-pointer text-base font-semibold hover:text-primary dark:text-white dark:hover:text-opacity-80 transition duration-200 ease-in-out">
                            <i class="bi bi-arrow-right"></i>
                        </a>
    
                    </div>
                </template>
    
                {{-- <template x-if="itemMyArticle > listMyArticle.length">
                    <div class="flex items-center justify-center">
                        <div id="resetButton" class="flex items-center justify-center"
                        >
                            
                            <a x-bind:href="baseUrl+'myarticle'"
                            class="px-4 py-2 outline outline-1 outline-primary dark:outline-white rounded-pill text-primary dark:text-white hover:bg-primary dark:bg-slate-secondary hover:outline-none hover:text-white transition duration-200 ease-in-out">Reset</a>
        
                        </div>
                    </div>
                </template> --}}
            </div>
    
        </div>
    </template>
    
    <template x-if="isLoading">
        <div class="flex justify-center px-32 py-4">
            <x-loading-page />
        </div>
    </template>

    <x-top-button />

</section>
