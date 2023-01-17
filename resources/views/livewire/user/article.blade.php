{{-- @section("title", "Me - Freemium App") --}}

{{-- Title Section --}}
<div x-data="user" x-init="checkSession()">
    <template x-if="isLogedIn">
        <script>
            document.title = 'Me - Freemium App';
        </script>
    </template>
</div>

<section class="py-[100px]" x-data="user" x-init="checkSession()" style="display: none;">
    <div x-init="fetchMe()"></div>
    <div x-data="admin">
        <div x-init="checkIsAdmin()"></div>
    </div>
    <div
    x-init="
        if(isLogedIn == true) {
            setTimeout(function() {
                return document.querySelector('section').style.display = 'block';
            }, 1000)
        }
    ">

        <h1 class="font-iceberg text-lg text-center text-primary dark:text-white mb-16">ME</h1>
    
        @include("layouts.partials.user.dashboard")
    
        <div x-init="fetchMe()"></div>
        
        {{-- <div x-data="user" class="container mx-auto">
            <div x-init="flash()"></div>
            <div x-show="showFlash">
                <x-alert />
            </div>
        </div> --}}
    
        <div class="container mx-auto mt-10 w-full dark:text-white" x-data="user">
            <div x-init="fetchListMyArticle()"></div>
    
            <template x-if="isLoading == true">
                <div class="flex items-center justify-center my-10">
                    <span class="span dark:text-white text-md">Loading..</span>
                </div>
            </template>
            
            <template x-if="!isLoading">
                <template x-for="(item, index) in listMyArticle.data.length > 1 ? listMyArticle.data.slice(0, itemMyArticle) : listMyArticle.data">
                    
                    <div class="group flex items-center flex-wrap lg:flex-nowrap justify-center lg:justify-between mb-10 gap-6">

                        <div class="relative z-10 flex lg:items-center flex-wrap lg:flex-nowrap lg:justify-between col lg:col-10 bg-white lg:mx-0 px-4 py-3 shadow-[0px_0px_4px_rgba(0,0,0,0.25)] dark:bg-slate-secondary rounded-lg overflow-hidden">
                            <div class="col lg:col-9 col:12" style="margin: 0 !important;">
                                <div class="flex items-center gap-3">
                                    <figure>
                                        <img x-bind:src="imgUrl+item.author.photo" class="w-10 h-10 bg-gray-primary rounded-full" alt="">
                                    </figure>
                                    <div x-data="helpers">
                                        <span class="font-bold text-base" x-text="substring(item.author.username, 10)"></span>
                                        <p class="flex flex-wrap lg:flex-nowrap items-center gap-2 text-sm mt-2">
                                            <span class="flex items-center gap-1" 
                                            x-text="convertDate(item.created_at)">
                                                {{-- {{ \Carbon\Carbon::parse()->translatedFormat('H:i:s') }} --}}
                                                <i data-feather="calendar" class="w-4 h-4"></i>

                                            </span>
                                            <i data-feather="eye" class="w-4 h-4"></i>
                                            <span class="flex items-center gap-1 -ml-1" x-text="item.total_views_sum ? item.total_views_sum : '0'">
                                                1000
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between mt-6 mb-4">
                                    <span class="text-base md:text-md font-bold" x-text="item.title"></span>
                                    <i class="bg-primary dark:bg-slate-third px-4 py-2 rounded-primary text-white font-bold" x-text="item.type.charAt(0).toUpperCase() + item.type.slice(1)"></i>
                                </div>start
                                <p class="text-sm text-gray-secondary" x-html="item.substring+'...'">

                                </p>
                            </div>
                            <figure class="col col-3 hidden lg:flex items-center justify-center" style="margin: 0 !important;">
                                <img x-bind:src="imgUrl+item.thumbnail" class="w-[150px] h-[150px] bg-gray-primary rounded-lg" alt="">
                            </figure>
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

                        <div class="relative hidden -translate-x-[103%] group-hover:translate-x-0 z-[1] col col-2 lg:col-1 lg:flex flex-row md:flex-col items-center lg:items-start gap-4 transition duration-200 ease-in-out">
                            <a x-bind:href="baseUrl+`article/edit/${item.id}`" @click="Article['id'] = item.id" class="w-max p-2 rounded-full outline outline-1 outline-primary dark:outline-slate-third hover:bg-primary dark:hover:bg-white hover:text-white dark:hover:text-slate-primary hover:outline-none transition duration-200 ease-in-out">
                                <i data-feather="edit"></i>
                            </a>
                            <button href="#" x-on:click="deleteArticle(item.id)" class="w-max p-2 rounded-full outline outline-1 outline-primary dark:outline-slate-third hover:bg-primary dark:hover:bg-white hover:text-white dark:hover:text-slate-primary hover:outline-none transition duration-200 ease-in-out">
                                <i data-feather="trash-2"></i>
                            </button>
                        </div>

                    </div>

                </template>
            </template>

            <template x-if="listMyArticle.data.length > 1 && listMyArticle.data.length > itemMyArticle">
                
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
            
            <template x-if="listMyArticle.data.length == 0">
                <h1 class="text-center text-md"><span class="span dark:text-slate-third">Oops</span>, You don't have an article</h1>
            </template>

            <span x-text="console.log(itemMyArticle > listMyArticle.data.length)"></span>
            <span x-text="console.log(listMyArticle.data.length < itemMyArticle)"></span>
            <template x-if="itemMyArticle > listMyArticle.data.length && listMyArticle.data.length > 1">
                <div class="flex items-center justify-center">
                    <div id="resetButton" class="flex items-center justify-center" style="display: none;"
                        x-init="
                            setTimeout(() => {
                                document.getElementById('resetButton').style.display = 'block';
                            }, 300)
                        "
                    >
                        
                        <a x-bind:href="baseUrl+'myarticle'"
                        class="px-4 py-2 outline outline-1 outline-primary dark:outline-white rounded-pill text-primary dark:text-white hover:bg-primary dark:bg-slate-secondary hover:outline-none hover:text-white transition duration-200 ease-in-out">Reset</a>
    
                    </div>
                </div>
            </template>
        </div>

    </div>

</section>
