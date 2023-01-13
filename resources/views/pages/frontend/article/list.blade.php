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

/* nav */

#all.active {
    color: #7C000B;
}

#free.active {
    color: #7C000B;
}

#paid.active {
    color: #7C000B;
}
    
</style>

<section class="lg:px-[12px] px-8 pt-[88px]" x-data="user">

    {{-- alert --}}
    <div x-data="user" class="container mx-auto w-full">
        <div x-init="flash()"></div>
        <div x-show="showFlash">
            <x-alert />
        </div>
    </div>

    <div class="flex container mx-auto justify-center mb-[226px] flex-col lg:flex-row" x-data="articles">
        
        {{-- kiri --}}
        <div class="w-full lg:col-3 lg:w-[270px] mx-auto h-max px-4 py-8 bg-white rounded-[19px] shadow-[0px_0px_4px_rgba(0,0,0,0.25)]">
            <div class="h-[44px] w-full py-2.5 px-3 rounded-[10px] border-solid border border-primary">
                <div class="flex justify-between">
                    <input 
                        x-model="keywordArticle"
                        x-on:change="searchArticle(keywordArticle)" 
                        class="w-[85%] md:w-[95%] lg:w-[85%] text-[#8B8585] font-normal text-sm" 
                        placeholder="Search Here..." />
                    <img class="w-[24px] h-[24px]" src="{{ asset('./assets/images/search.png') }}" alt="">
                </div>
            </div>

            <div class="flex flex-col justify-center gap-[9px] mt-[28px]">
                <div class="text-black font-extrabold">
                    <h1 class="text-sm leading-[21px] font-extrabold">Or <span class="text-primary font-bold">Filter By</span> :</h1>
                </div>
                <div class="flex items-center gap-[5px]">
                    <input class="bg-primary" type="radio" id="free" name="fav_language" value="free" @click="getFreeArticle()">
                    <label class="mt-[2px] text-sm leading-[21px]" for="free">Free</label><br>
                </div>
                <div class="flex items-center gap-[5px]">
                    <input class="bg-primary" type="radio" id="paid" name="fav_language" value="paid" @click="getPaidArticle()">
                    <label class="mt-[2px] text-sm leading-[21px]" for="paid">Paid</label><br>
                </div>
                {{-- <div class="flex items-center gap-[5px]">
                    <input class="bg-primary" type="radio" id="html" name="fav_language" value="description">
                    <label class="mt-[2px] text-sm leading-[21px]" for="html">Description</label><br>
                </div> --}}

            </div>

            <div class="mt-[33px] flex flex-wrap gap-[11px]" x-init="getCategories()">
                {{-- <template x-for="(item, index) in categoriesArticle">
                    <a x-bind:id=`category${item.id}` class="category font-bold bg-white hover:bg-primary hover:text-white text-primary border border-primary rounded-[6px] text-xs px-[12px] py-[5px]" href="#" x-text="item.name" @click="
                    fetchArticleByCategory(item.id);
                    ">Category 1</a>
                </template> --}}
                <select name="category" id="category" class="py-2.5 px-3 rounded-[10px] border-solid border border-primary w-full bg-white" x-ref="category">
                    <option value="" @click="getArticle()">--Select a Category--</option>
                    <template x-for="(item, index) in categoriesArticle">
                        <option x-bind:value="item.id" x-text="item.name" x-on:click="fetchArticleByCategory(item.id)"></option>
                    </template>
                </select>
                <button type="button" @click="resetFilters()" class="w-full py-2 bg-primary mt-2 rounded-pill text-white hover:text-opacity-80 transition duration-200 ease-in-out">
                    Reset Filter
                </button>
            </div>



        </div>

        {{-- kanan --}}
        <div class="lg:col-9 mt-5 lg:mt-0 bg-white lg:ml-[30px] md:mt-20">
            <div x-init="fetchMe()"></div>
            <div x-init="getArticle()"></div>

            <template x-if="!data_user.subscribe_status">
                <div id="alertSubscribe" style="display: none"
                x-init="
                    setTimeout(() => {
                        document.getElementById('alertSubscribe').style.display = 'block';
                    }, 600)
                ">
                    <div class="lg:w-full w-[320px] md:w-full bg-primary rounded-[10px] mb-2 lg:mb-[29px] md:mb-[29px] bg-opacity-20 lg:h-[50px] md:h-[50px] mt-5 lg:mt-0 h-[70px] font-normal text-sm px-[27px] py-[13px]">
                        You have to 
                        <span class="font-bold text-primary leading-[27px]">
                            Subscribe</span>  to Get Unlimited Access
                    </div>
                </div>
            </template>

            <div class="flex lg:justify-between md:justify-between mx-auto gap-5 flex-col-reverse md:w-full md:flex-row lg:flex-row items-center w-[320px] lg:w-full">
                {{-- <div class="flex gap-[47px]">
                    <h2 id="all" class="font-bold active text-[18px]"> <a href="#" @click="getArticle()">All</a></h2>
                    <h2 id="free" class="font-bold text-[18px]"><a href="#" @click="getFreeArticle()">Free</a></h2>
                    <h2 id="paid" class="font-bold text-[18px]"><a href="#" @click="getPaidArticle()">Paid</a></h2>
                </div> --}}
                <template  x-if="!data_user.subscribe_status">
                    <div>
                        <a id="buttonTransactionCreate" style="display: none;" href="{{ route('transaction.create') }}" class="bg-primary px-4 py-3 mb-3 rounded-[10px] flex items-center gap-2 mt-10 lg:mt-auto md:mt-auto"
                        x-init="
                            setTimeout(() => {
                                document.getElementById('buttonTransactionCreate').style.display = 'flex';
                            }, 600)
                        "
                        >
                            <img class="w-6 h-6" src="{{ asset('./assets/images/check-circle.png') }}" alt="">
                            <h2 class="font-bold text-white"
                            >Get Unlimited Access</h2>
                        </a>
                    </div>
                </template>
            </div>

            {{-- wrapper content --}}

            <div class="flex flex-wrap items-center justify-center">

                
                {{-- <div class="content">
                    <div class="border mt-5"></div>
                    
                    <div class="flex lg:justify-between mt-[22px] flex-wrap lg:flex-nowrap md:flex-nowrap">
                        <div class="h-50 w-50 flex flex-col ">
                            <div class="flex lg:gap-[22px] lg:px-0 gap-5 ">
                                <div class="bg-[#D9D9D9] rounded-full w-[50px] h-[50px]">
        
                                </div>
                                <div>
                                    <h1 class="text-[18px] font-bold mb-2 leading-[27px]">Nama Author</h1>
                                    <div class="flex lg:gap-5 gap-3 flex-wrap">
                                        <p class="text-[14px] leading-[21px]">tanggal-bulan-tahun</p>
                                        <p class="text-[14px] leading-[21px]">1000 Views</p>
                                    </div>
                                </div>
                            </div>
        
                            <div class="bg-[#D9D9D9] w-[280px] h-[180px] mx-auto block md:hidden lg:hidden mt-10 mb-10">
        
                            </div>
        
                            <div class="flex lg:gap-5 justify-between items-center mt-5">
                                <div class="font-bold text-[24px] leading-9">JUDUL ARTIKEL</div>
                                <button class="w-[100px] h-[30px] bg-primary text-white font-bold text-sm leading-[21px] rounded-[10px]">
                                    PAID
                                </button>
                            </div>
                            <p class="font-normal text-sm mt-3 md:w-[400px] lg:w-full">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                eiusmod tempor incididunt ut labore et dolore magna aliqua. short desc
                                short desc short desc short desc short desc
                            </p>
        
                        </div>
                        <div class="bg-[#D9D9D9] w-[280px] h-[180px] my-auto mx-5 hidden md:block lg:block">
        
                        </div>
                    </div>
                                    
                </div>
                <div class="content">
                    <div class="border mt-5"></div>
                    
                    <div class="flex lg:justify-between mt-[22px] flex-wrap lg:flex-nowrap md:flex-nowrap">
                        <div class="h-50 w-50 flex flex-col ">
                            <div class="flex lg:gap-[22px] lg:px-0 gap-5 ">
                                <div class="bg-[#D9D9D9] rounded-full w-[50px] h-[50px]">
        
                                </div>
                                <div>
                                    <h1 class="text-[18px] font-bold mb-2 leading-[27px]">Nama Author</h1>
                                    <div class="flex lg:gap-5 gap-3 flex-wrap">
                                        <p class="text-[14px] leading-[21px]">tanggal-bulan-tahun</p>
                                        <p class="text-[14px] leading-[21px]">1000 Views</p>
                                    </div>
                                </div>
                            </div>
        
                            <div class="bg-[#D9D9D9] w-[280px] h-[180px] mx-auto block md:hidden lg:hidden mt-10 mb-10">
        
                            </div>
        
                            <div class="flex lg:gap-5 justify-between items-center mt-5">
                                <div class="font-bold text-[24px] leading-9">JUDUL ARTIKEL</div>
                                <button class="w-[100px] h-[30px] bg-primary text-white font-bold text-sm leading-[21px] rounded-[10px]">
                                    PAID
                                </button>
                            </div>
                            <p class="font-normal text-sm mt-3 md:w-[400px] lg:w-full">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                eiusmod tempor incididunt ut labore et dolore magna aliqua. short desc
                                short desc short desc short desc short desc
                            </p>
        
                        </div>
                        <div class="bg-[#D9D9D9] w-[280px] h-[180px] my-auto mx-5 hidden md:block lg:block">
        
                        </div>
                    </div>
                                    
                </div>
                <div class="content">
                    <div class="border mt-5"></div>
                    
                    <div class="flex lg:justify-between mt-[22px] flex-wrap lg:flex-nowrap md:flex-nowrap">
                        <div class="h-50 w-50 flex flex-col ">
                            <div class="flex lg:gap-[22px] lg:px-0 gap-5 ">
                                <div class="bg-[#D9D9D9] rounded-full w-[50px] h-[50px]">
        
                                </div>
                                <div>
                                    <h1 class="text-[18px] font-bold mb-2 leading-[27px]">Nama Author</h1>
                                    <div class="flex lg:gap-5 gap-3 flex-wrap">
                                        <p class="text-[14px] leading-[21px]">tanggal-bulan-tahun</p>
                                        <p class="text-[14px] leading-[21px]">1000 Views</p>
                                    </div>
                                </div>
                            </div>
        
                            <div class="bg-[#D9D9D9] w-[280px] h-[180px] mx-auto block md:hidden lg:hidden mt-10 mb-10">
        
                            </div>
        
                            <div class="flex lg:gap-5 justify-between items-center mt-5">
                                <div class="font-bold text-[24px] leading-9">JUDUL ARTIKEL</div>
                                <button class="w-[100px] h-[30px] bg-primary text-white font-bold text-sm leading-[21px] rounded-[10px]">
                                    PAID
                                </button>
                            </div>
                            <p class="font-normal text-sm mt-3 md:w-[400px] lg:w-full">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                eiusmod tempor incididunt ut labore et dolore magna aliqua. short desc
                                short desc short desc short desc short desc
                            </p>
        
                        </div>
                        <div class="bg-[#D9D9D9] w-[280px] h-[180px] my-auto mx-5 hidden md:block lg:block">
        
                        </div>
                    </div>
                                    
                </div> --}}
                
                <template x-if="listArticle[0].type == 'free' && 
                document.getElementById('free').classList.contains('active');">
                    <div x-init="getFreeArticle()"></div>
                </template>

                <template x-if="listArticle[0].type == 'paid' && document.getElementById('paid').classList.contains('active')">
                    <div x-init="getPaidArticle()"></div>
                </template>
                
                <template x-if="isLoadingArticle && isLoadMore == false">
                    <span class="span text-md">Loading...</span>
                </template>

                <template x-for="(item, index) in listArticle.length > 1 ? listArticle.slice(0, itemArticle) : listArticle">
                
                    <div class="content first-of-type:mt-0 mt-[22px]" x-data="helpers">
                        
                        {{-- <div class="border mt-5 first:border-none"></div> --}}
                        
                        <div class="flex lg:justify-between flex-wrap lg:flex-nowrap md:flex-nowrap shadow-[0px_0px_4px_rgba(0,0,0,0.25)] bg-white rounded-primary px-3 py-2">
                            <div class="flex flex-col col-12 md:col-8">
                                <div class="flex lg:gap-[22px] lg:px-0 gap-5 ">
                                    <div class="bg-[#D9D9D9] rounded-full w-[50px] h-[50px]">
            
                                    </div>
                                    <div>
                                        <h1 class="text-[18px] font-bold mb-2 leading-[27px]" x-text="item.author.username">Nama Author</h1>
                                        <div class="flex gap-3 flex-wrap">
                                            <p class="text-[14px] leading-[21px]" x-text="convertDate(item.created_at)">tanggal-bulan-tahun</p>
                                            <p class="text-[14px] leading-[21px]">
                                                <span x-text="item.total_views_sum > 0 ? item.total_views_sum : 'No'">
                                                    1000 
                                                </span> Views
                                            </p>
                                        </div>
                                    </div>
                                </div>
            
                                <div class="bg-[#D9D9D9] w-[280px] h-[180px] mx-auto block md:hidden lg:hidden mt-10 mb-6 md:mb-10">
            
                                </div>
            
                                <div class="flex lg:gap-5 justify-between items-center mt-0 md:mt-5">
                                    <a x-bind:href="baseUrl + `article/detail/${item.id}`"
                                    class="font-bold text-[24px] leading-9" x-text="item.title">JUDUL ARTIKEL</a>
                                    <button class="w-[100px] h-[30px] bg-primary text-white font-bold text-sm leading-[21px] rounded-[10px]" x-text="item.type.charAt(0).toUpperCase() + item.type.slice(1)">
                                        PAID
                                    </button>
                                </div>
                                <p class="font-normal text-sm mt-3 md:w-[400px] lg:w-full" x-text="item.description.length > 150 ? item.description.substring(0, 150) + '...' : item.description">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                    eiusmod tempor incididunt ut labore et dolore magna aliqua. short desc
                                    short desc short desc short desc short desc
                                </p>
            
                            </div>
                            <div class="bg-[#D9D9D9] rounded-lg max-w-[180px] w-[180px] h-[180px] my-auto mx-5 hidden md:block lg:block col-4">
                                <img x-bind:src="imgUrl+item.thumbnail" class="w-full h-full object-fill rounded-lg" alt="">
                            </div>
                        </div>
                        
                    </div>
        
                </template>


                <template x-if="listArticle == null || listArticle.length == 0 && keywordArticle != ''">
                    <p id="articleNotFound" class="text-md mt-10" style="display: none;"
                        x-init="
                            setTimeout(() => {
                                document.getElementById('articleNotFound').style.display = 'block';
                            }, 550)
                        "
                    >
                        <img src="{{ asset("assets/images/nodata.svg") }}" class="h-[200px] w-[200px] mx-auto mb-4" alt="">
                        <span class="span">Oops</span>, We can't find your article
                    </p>
                </template>

                <template x-if="listArticle == null || listArticle.length == 0 && keywordArticle == ''">
                    <p id="articleNotFound" class="text-md mt-10" style="display: none;"
                        x-init="
                            setTimeout(() => {
                                document.getElementById('articleNotFound').style.display = 'block';
                            }, 550)
                        "
                    >
                        <img src="{{ asset("assets/images/nodata.svg") }}" class="h-[200px] w-[200px] mx-auto mb-4" alt="">
                        <span class="span">We</span> still don't have any articles 
                    </p>
                </template>

            </div>

                
            <template x-if="listArticle.length > 1 && listArticle.length > itemArticle">
                <div class="flex items-center justify-center mt-20">

                    <template x-if="isLoadMore">
                        <span class="span">Loading...</span>
                    </template>

                    <template x-if="!isLoadingArticle">
                        <button @click="
                            loadMoreArticle()
                        " id="loadMore" class="px-4 py-2 outline outline-1 outline-primary rounded-pill text-primary hover:bg-primary hover:outline-none hover:text-white transition duration-200 ease-in-out">Load More</button>
                    </template>

                    
                </div>            
            </template> 
            
            <span x-text="console.log(itemArticle > listArticle.length)"></span>
            <span x-text="console.log(listArticle.length < itemArticle)"></span>
            <template x-if="itemArticle > listArticle.length && keywordArticle == '' && listArticle.length > 1">
                <div class="flex items-center justify-center">
                    <div id="resetButton" class="flex items-center justify-center mt-20" style="display: none;"
                        x-init="
                            setTimeout(() => {
                                document.getElementById('resetButton').style.display = 'block';
                            }, 300)
                        "
                    >
                        
                        <button 
                        x-on:click="itemArticle = 3"
                        class="px-4 py-2 outline outline-1 outline-primary rounded-pill text-primary hover:bg-primary hover:outline-none hover:text-white transition duration-200 ease-in-out">Reset</button>
    
                    </div>
                </div>
            </template>
                    


        </div>

    </div>


    
</section>

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script>
    $(document).ready(function(){
        $(".content").slice(0, 2).show();
        
        $("#loadMore").on("click", function(e){
            e.preventDefault();
            $(".content:hidden").slice(0, 2).slideDown();
            if($(".content:hidden").length == 0) {
                $("#loadMore").text("No Content").addClass("noContent");
            }
        });
    })
</script> --}}

@endsection
