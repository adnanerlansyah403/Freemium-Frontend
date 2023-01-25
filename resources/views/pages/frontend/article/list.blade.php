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

</style>

<section class="lg:px-[12px] px-8 pt-[140px]" x-data="user">
    {{-- alert --}}
    <div x-init="flash()"></div>
    <div x-show="showFlash" x-init="setTimeout(() => {
        showFlash = false
        }, 4000);
    ">
        <x-alert />
    </div>

    <div class="flex container mx-auto justify-center mb-[226px] flex-col lg:flex-row" x-data="articles">

        <template>
            <span x-init="fetchArticleByCategory(1)"></span>
        </template>

        {{-- kiri --}}
        <div class="lg:col-3">
            <template  x-if="localStorage.getItem('token') && !data_user?.subscribe_status">
                <div id="buttonTransactionCreate" class="w-full lg:w-[270px] mx-auto h-max" style="display: none;">
                    <a href="{{ route('transaction.create') }}" class="w-full bg-primary dark:bg-slate-secondary px-4 py-2 lg:w-[270px text-center] text-sm rounded-[10px] mb-3 lg:mb-5 flex items-center justify-center gap-2 mt-10 lg:mt-auto md:mt-auto"
                    x-init="
                        window.addEventListener('DOMContentLoaded', function() {
                            setTimeout(() => {
                                document.getElementById('buttonTransactionCreate').style.display = 'flex';
                            }, 1000)
                        });
                    "
                    >
                        <img class="w-6 h-6" src="{{ asset('./assets/images/check-circle.png') }}" alt="">
                        <h2 class="font-bold text-white hover:text-opacity-80 transition duration-200 ease-in-out"
                        >Get Unlimited Access</h2>
                    </a>
                </div>
            </template>
            <div class="w-full lg:w-[270px] mx-auto h-max px-4 py-8 bg-white dark:bg-slate-secondary dark:text-white rounded-[19px] shadow-[0px_0px_4px_rgba(0,0,0,0.25)]">
                <div class="h-[44px] w-full py-2.5 px-3 rounded-[10px] border-solid border border-primary dark:border-white">
                    <div class="flex justify-between">
                        <input id="search"
                            x-on:change="filtersKey[0] = $event.target.value; filterArticle()"
                            class="w-[85%] md:w-[95%] lg:w-[85%] text-[#8B8585] font-normal text-sm"
                            placeholder="Search Here..." />
                        <img class="w-[24px] h-[24px]" src="{{ asset('./assets/images/search.png') }}" alt="">
                    </div>
                </div>

                <div class="flex flex-col justify-center gap-[9px] mt-[28px]">
                    <div class="text-black font-extrabold">
                        <h1 class="text-[16px] font-poppins dark:text-slate-fourth leading-[21px] font-extrabold">Or <span class="text-primary dark:text-white font-bold">Filter By : </span></h1>
                    </div>
                    <div class="flex items-center gap-2 mt-2">
                        <div class="flex items-center gap-[5px]">
                            <input class="checked:bg-primary dark:checked:bg-slate-third" type="radio" id="free" name="type_article" value="free" @click="filtersKey[1] = $event.target.value; filterArticle()">
                            <label class="mt-[2px] text-sm leading-[21px]" for="free">Free</label><br>
                        </div>
                        <div class="flex items-center gap-[5px]">
                            <input class="checked:bg-primary dark:checked:bg-slate-third" type="radio" id="paid" name="type_article" value="paid" @click="filtersKey[1] = $event.target.value; filterArticle()">
                            <label class="mt-[2px] text-sm leading-[21px]" for="paid">Paid</label><br>
                        </div>
                    </div>

                </div>

                <div class="mt-[33px] flex flex-wrap gap-[11px]" x-init="getCategories()">
                    <select name="category" x-on:change="filtersKey[2] = $event.target.value; filterArticle()" id="category" class="text-sm py-2 px-3 rounded-[10px] border-solid border border-primary dark:border-white w-full bg-white dark:bg-slate-primary dark:text-white" x-ref="category">
                        <option value="" @click="getCategories()">  Select a category... </option>
                        <template x-for="(item, index) in categoriesArticle">
                            <option x-bind:value="item.id" x-text="item.name" ></option>
                        </template>
                    </select>
                    <button type="button" @click="resetFilters()" class="w-full py-2 bg-primary dark:bg-slate-primary dark:border dark:border-white mt-2 rounded-pill text-white hover:text-opacity-80 transition duration-200 ease-in-out">
                        Reset Filter
                    </button>
                </div>



            </div>
        </div>

        {{-- kanan --}}
        <div class="lg:col-9 mt-5 lg:mt-0 lg:ml-[30px] md:mt-20">
            <div x-init="fetchMe()"></div>
            <div x-init="getArticle()"></div>

            <template x-if="localStorage.getItem('token') && !data_user?.subscribe_status">
                <div id="alertSubscribe" style="display: none"
                >
                    <div x-init="
                    window.addEventListener('DOMContentLoaded', function() {
                        setTimeout(() => {
                            document.getElementById('alertSubscribe').style.display = 'block';
                        }, 1000)
                    })
                    " class="w-full bg-primary dark:bg-slate-secondary rounded-[10px] dark:text-white mb-4 bg-opacity-20 mt-5 lg:-translate-y-1 lg:mt-0 font-normal text-sm px-4 py-2">
                        You have to
                        <span class="font-bold text-primary dark:text-slate-third leading-[27px]">
                            Subscribe</span>  to Get Unlimited Access
                    </div>
                </div>
            </template>

            {{-- wrapper content --}}

            <div class="flex flex-wrap items-center justify-center w-full" x-data="helpers">

                <div class="flex flex-col flex-wrap items-center justify-center">

                    <template x-if="isLoadingArticle && isLoadMore == false">
                        <x-loading />
                    </template>

                    <template x-if="listArticle == null || listArticle.length == 0">
                        <p id="articleNotFound" class="text-md mt-10 dark:text-white" style="display: none;"
                            x-init="
                                setTimeout(() => {
                                    document.getElementById('articleNotFound').style.display = 'block';
                                }, 800)
                            "
                        >
                            <img src="{{ asset("assets/images/nodata.svg") }}" class="h-[200px] w-[200px] mx-auto mb-4" alt="">
                            <span class="span dark:text-slate-fourth">Oops</span>, We can't find your article
                        </p>
                    </template>

                    <template x-if="listArticle == null || listArticle.length == 0">
                        <p id="articleNotFound" class="text-md mt-10 dark:text-white" style="display: none;"
                            x-init="
                                setTimeout(() => {
                                    document.getElementById('articleNotFound').style.display = 'block';
                                }, 700)
                            "
                        >
                            <img src="{{ asset("assets/images/nodata.svg") }}" class="h-[200px] w-[200px] mx-auto mb-4" alt="">
                            <span class="span dark:text-slate-fourth">We</span> still don't have any articles
                        </p>
                    </template>


                </div>


                <div class="flex flex-wrap items-center justify-center w-full">
                    <template x-for="(item, index) in listArticle.length > 1 ? listArticle.slice(0, itemArticle) : listArticle">
                        <div class="content first-of-type:mt-0 mt-[22px]" >

                            {{-- <div class="border mt-5 first:border-none"></div> --}}
                            <div class="flex lg:justify-between flex-wrap lg:flex-nowrap md:flex-nowrap shadow-[0px_0px_4px_rgba(0,0,0,0.25)] bg-white dark:bg-slate-secondary max-h-[250px] dark:text-white rounded-primary px-3 py-4">
                                <div class="flex flex-col col-12 md:col-9">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h1 class="text-[18px] font-bold font-bebasNeue" x-text="item.author.username">Nama Author</h1>
                                            <div class="flex gap-3 flex-wrap mt-2">
                                                <p class="text-[14px]" x-text="convertDate(item.created_at)">tanggal-bulan-tahun</p>
                                                <p class="flex items-center gap-1 text-[14px]">
                                                    <i data-feather="eye" class="w-4 h-4 -translate-y-[1px]"></i>
                                                    <span x-text="item.total_views_sum > 0 ? item.total_views_sum : 'No Views'">
                                                        1000
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="-translate-x-[24px]">
                                            {{-- <span x-text="console.log(data_user.photo != undefined)"></span> --}}
                                            <template x-if="item.author.photo != null">
                                                <img class="bg-[#D9D9D9] rounded-full w-[50px] h-[50px]" x-bind:src="imgUrl+item.author.photo" alt="">
                                            </template>
                                            <template x-if="item.author.photo == null">
                                                <img class="bg-[#D9D9D9] rounded-full w-[50px] h-[50px]" x-bind:src="imgUrl+'img/user1.png'" alt="">
                                            </template>
                                        </div>
                                    </div>

                                    <div class="bg-[#D9D9D9] w-full h-[200px] lg:w-[280px] lg:h-[180px] mx-auto block md:hidden lg:hidden mt-6 lg:mt-10 mb-6 md:mb-10">
                                        <img x-bind:src="imgUrl+item.thumbnail" class="w-full h-full object-fill rounded-lg" alt="">
                                    </div>

                                    <div class="flex flex-col lg:flex-row gap-y-2 lg:gap-5 justify-between items-start mt-0 md:mt-5">
                                        <a x-bind:href="baseUrl + `article/detail/${item.id}`"
                                        class="font-bold text-[24px] font-neucha leading-9" x-text="item.title.length > 60 ? item.title.substring(0, 60) + '...' : item.title">JUDUL ARTIKEL</a>
                                        <button class="w-[100px] h-[30px] bg-primary dark:bg-slate-primary text-white font-bold text-sm leading-[21px] rounded-[10px]" x-text="item.type.charAt(0).toUpperCase() + item.type.slice(1)"
                                        x-on:click="
                                            if(item.type == 'free') {
                                                getFreeArticle()
                                            } else {
                                                getPaidArticle()
                                            }
                                        ">
                                            PAID
                                        </button>
                                    </div>
                                    {{-- <span x-text="parseToOriginalString(item.description)"></span> --}}
                                    <p class="font-normal text-sm mt-4 md:w-[400px] lg:w-full dark:text-gray-primary" x-text="parseToOriginalString(item.description, 150)">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                        eiusmod tempor incididunt ut labore et dolore magna aliqua. short desc
                                        short desc short desc short desc short desc
                                    </p>

                                    <template x-for="(c, index) in item.tags">
                                        <span x-text="c.category.name" @click="fetchArticleByCategory(c.category.id)" class="mt-4 cursor-pointer py-1 px-3 rounded-lg shadow-[0px_0px_4px_rgba(0,0,0,0.3)] dark:shadow-[0px_0px_4px_#fff] text-sm text-[rgba(41,41,41,1)] font-medium dark:bg-slate-secondary dark:text-white w-max"></span>
                                    </template>

                                </div>
                                {{-- <span x-text="console.log(item.thumbnail)"></span> --}}
                                <template x-if="item.thumbnail != ''">
                                    <div class="bg-[#D9D9D9] rounded-lg max-w-[150px] w-[150px] h-[150px] my-auto mx-5 hidden md:block lg:block col-4">
                                        <img x-bind:src="imgUrl+item.thumbnail" class="w-full h-full object-fill rounded-lg" alt="">
                                    </div>
                                </template>
                                <template x-if="item.thumbnail == ''">
                                    <div class="bg-slate-secondary dark:bg-white rounded-lg max-w-[150px] w-[150px] h-[150px] my-auto mx-5 hidden md:block lg:block col-4">
                                    </div>
                                </template>
                            </div>
                            <script>
                                feather.replace()
                            </script>

                        </div>

                    </template>
                </div>

            </div>


            <template x-if="listArticle.length > 1 && listArticle.length > itemArticle">
                <div class="flex items-center justify-center mt-20">

                    <template x-if="isLoadMore">
                        <span class="span dark:text-slate-third">Loading...</span>
                    </template>

                    <template x-if="!isLoadingArticle">
                        <button @click="
                            loadMoreArticle()
                        " id="loadMore" class="px-4 py-2 outline outline-1 outline-primary dark:outline-white rounded-pill text-primary dark:text-white hover:bg-primary dark:bg-slate-secondary hover:outline-none hover:text-white transition duration-200 ease-in-out">Load More</button>
                    </template>


                </div>
            </template>

            {{-- <span x-text="console.log(itemArticle > listArticle.length)"></span>
            <span x-text="console.log(listArticle.length < itemArticle)"></span> --}}
            <template x-if="itemArticle > listArticle.length && listArticle.length > 3">
                <div class="flex items-center justify-center">
                    <div id="resetButton" class="flex items-center justify-center mt-20" style="display: none;"
                        x-init="
                            setTimeout(() => {
                                document.getElementById('resetButton').style.display = 'block';
                            }, 300)
                        "
                    >

                        <a :href="baseUrl+'article'"
                        class="px-4 py-2 outline outline-1 outline-primary dark:outline-white rounded-pill text-primary dark:text-white hover:bg-primary dark:bg-slate-secondary hover:outline-none hover:text-white transition duration-200 ease-in-out">Reset</a>

                    </div>
                </div>
            </template>



        </div>

    </div>



</section>

<x-top-button />

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
