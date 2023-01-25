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
        
                <template x-if="isLoading">
                    <div class="flex items-center justify-center my-10">
                        <x-loading />
                    </div>
                </template>
                
                <template x-if="!isLoading">
                    <div x-data="helpers">
                        <div class="flex items-center lg:gap-6 mb-10" x-data="{ resetShow: false }"
                            {{-- x-on:mouseleave="resetShow = false"
                            x-on:mouseover="resetShow = true" --}}
                        >
                            <div class="h-[44px] col col-10 lg:mx-0 w-full py-2.5 px-3 rounded-[10px] border-solid border border-primary dark:border-white">
                                <div class="flex justify-between">
                                    <input
                                        x-model="keywordMyArticle"
                                        x-on:change="
                                        searchMyArticle(keywordMyArticle);
                                        "
                                        {{-- x-on:keyup="resetShow = true"
                                        x-on:mouseover="resetShow = true"
                                        x-on:keydown="resetShow = false" --}}
                                        class="w-[85%] md:w-[95%] lg:w-[85%] text-[#8B8585] font-normal text-sm"
                                        placeholder="Search Here..." />
                                    <img class="w-[24px] h-[24px]" src="{{ asset('./assets/images/search.png') }}" alt="">
                                </div>
                            </div>
                            <div class="col" style="margin-left: 0;">
                                <button @click="keywordMyArticle = ''; fetchListMyArticle();  itemMyArticle = 3;" class="px-6 py-2 border border-primary dark:border-white hover:bg-primary dark:hover:bg-white hover:text-white dark:hover:text-slate-secondary rounded-pill transition duration-200 ease-in-out">
                                    Reset
                                </button>
                            </div>
                        </div>

                        <template x-for="(item, index) in listMyArticle.length > 1 ? listMyArticle.slice(0, itemMyArticle) : listMyArticle">
                            
                            <div class="group flex items-center flex-wrap lg:flex-nowrap justify-center lg:justify-between mb-10 gap-6">
                                <div class="relative z-10 flex lg:items-start flex-wrap lg:flex-nowrap lg:justify-between col lg:col-10 bg-white lg:mx-0 px-4 py-3 shadow-[0px_0px_4px_rgba(0,0,0,0.25)] h-full lg:max-h-[200px] lg:h-[200px] dark:bg-slate-secondary rounded-lg overflow-hidden">
                                    <div class="col lg:col-9 col:12" style="margin: 0 !important;">
                                        <div class="flex items-center gap-3">
                                            <p class="text-sm">
                                                <span class="flex items-center gap-1" 
                                                x-text="convertDate(item.created_at)">
                                                    <i data-feather="calendar" class="w-4 h-4"></i>
                                                </span>
                                            </p>
                                            <div class="flex items-center gap-2">
                                                <i data-feather="eye" class="-mt-[2px] w-4 h-4"></i>
                                                <span class="flex items-center gap-1 -ml-1" x-text="item.total_views_sum ? item.total_views_sum : '0'">
                                                    1000
                                                </span>
                                            </div>
                                        </div>
                                        <div class="pb-4 pt-12 lg:py-0 lg:translate-y-5">
                                            <div class="flex items-center justify-between mb-4">
                                                <a x-bind:href="baseUrl + `article/detail/${item.id}`" class="text-base md:text-md font-neucha font-bold" x-text="substring(item.title, 70)"></a>
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
        
                            </div>
        
                        </template>
                    </div>
                </template>
    
                <template x-if="listMyArticle.length > 1 && listMyArticle.length > itemMyArticle">
                    
                    <div>
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
                    </div>
                
                </template>
                
                <template x-if="listMyArticle.length == 0">
                    <div>
                        <img src="{{ asset("assets/images/nodata.svg") }}" class="h-[200px] w-[200px] mx-auto mb-4" alt="">
                        <h1 class="text-center text-md"><span class="span dark:text-slate-third">Oops</span>, You don't have an article</h1>
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
