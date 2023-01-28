@extends("homepage")

@section("title", "List - Freemium App")

@section("content")

<style>


.category.active {
    background-color: #7C000B;
    color: white;
    border: none;
}

.content {
  width: 100%;
  /* display: none; */
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
                
                    <div class="flex items-center justify-between bg-white shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-pill w-full">
                        <input type="text" class="py-2 px-4 text-sm w-full" placeholder="Search for a article....">
                        <button class="translate-x-1 flex items-center px-4 py-2 gap-2 bg-primary dark:bg-slate-secondary rounded-r-pill text-white dark:text-white">
                            <i data-feather="search" class="text-white dark:text-gray-secondary"></i>
                            <span>Search</span>
                        </button>
                    </div>
        
                    <div class="mt-4 w-full flex items-center justify-between gap-4">
                        <div class="mt-[33px] w-full flex flex-wrap gap-[11px]" x-init="getCategories()">
                            <select name="category" x-on:change="filtersKey[2] = $event.target.value; filterArticle()" id="category" class="text-sm py-2 px-3 rounded-[10px] border-solid border border-primary dark:border-white w-full bg-white dark:bg-slate-primary dark:text-white font-medium" x-ref="category">
                                <option value="" @click="getCategories()">  Select a category... </option>
                                <template x-for="(item, index) in categoriesArticle">
                                    <option x-bind:value="item.id" x-text="item.name" ></option>
                                </template>
                            </select>
                        </div>
                        <div class="flex items-center gap-2">
                            <button class="px-4 py-1 border border-primary rounded-pill text-slate-primary dark:text-white font-medium dark:border dark:border-white dark:bg-slate-secondary text-sm hover:text-opacity-80 dark:hover:text-opacity-80 transition duration-200 ease-in-out">
                                <span>PAID</span>
                            </button>
                            <button class="px-4 py-1 border border-primary rounded-pill text-slate-primary dark:text-white font-medium dark:border dark:border-white dark:bg-slate-secondary text-sm hover:text-opacity-80 dark:hover:text-opacity-80 transition duration-200 ease-in-out">
                                <span>FREE</span>
                            </button>
                        </div>
                    </div>
        
                    <div class="my-8 text-center p-8 dark:bg-slate-secondary rounded-lg">
                        <p class="text-md text-black font-medium font-poppins mb-8 dark:text-white">Get Unlimited Access Now for All Content</p>
                        <a href="{{ route('transaction.create') }}" class="px-4 py-2 rounded-pill bg-primary dark:bg-slate-secondary text-white dark:border dark:border-white hover:text-opacity-80 transition-none duration-200 ease-in-out">Join Now</a>
                    </div>
        
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-4" x-data="helpers">
                        <template x-for="(item, index) in listArticle">
                            <div class="hover:-translate-y-2 dark:hover:shadow-[0px_2px_8px_rgba(255,255,255,.30)] transition duration-200 ease-linear">
                                <figure class="bg-no-repeat w-full h-[270px] rounded-t-[6px] overflow-hidden relative">
                                    <img x-bind:src="imgUrl+item.thumbnail" class="w-full h-full object-fill" alt="">
                                </figure>
                                <div class="relative h-[230px] pt-12 dark:bg-[#111] shadow-lg dark:shadow-none flex-1 rounded-b-[6px] overflow-hidden px-3 pb-6">
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
                                    <a href="" class="font-bold text-[20px] font-lato leading-9 dark:text-white" x-text="item.title.length > 30 ? item.title.substring(0, 30) + '...' : item.title"></a>
                                    <p class="font-normal text-sm dark:text-gray-primary"
                                    x-text="item.description.length > 120 ? parseToOriginalString(item.description, 120) : item.description">
        
                                    </p>
                                    <a href="" class="group flex items-center gap-1 absolute bottom-0 -translate-y-4 px-4 py-1 border border-primary text-primary dark:text-white dark:border-white dark:hover:bg-white dark:hover:text-slate-primary font-poppins font-medium transition duration-200 ease-in-out">
                                        Read More
                                        <span class="group-hover:translate-x-1 translate-y-0 transition duration-200 ease-linear">
                                            <i class="bi bi-arrow-right"></i>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </template>
                    </div>
        
                    <p class="text-center flex items-center justify-center gap-2 translate-y-14 dark:text-white">
                        <b class="font-semibold">
                            Halaman <span>1</span> dari <span class="span dark:text-slate-fourth">200</span>
                        </b>
                        <a href="" class="text-base font-semibold hover:text-primary dark:text-white dark:hover:text-opacity-80 transition duration-200 ease-in-out"><i class="bi bi-arrow-right"></i></a>
                    </p>
            
                </div>
            </template>

            <template x-if="isLoadingArticle">
                <x-loading-page />
            </template>
        </div>




</section>

<x-top-button />

@endsection
