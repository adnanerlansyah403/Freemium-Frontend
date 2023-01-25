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
            document.title = 'Dashboard Admin (Orders) - Freemium App';
        </script>
    </template>
</div>

<section class="pt-[140px] pb-[100px]" x-data="user" x-init="checkSession()">
    <div x-init="checkRole()"></div>
    <template x-if="!isLoading">
        <div>
    
    
            @include("layouts.partials.user.dashboard")
    
            <div class="flex flex-wrap lg:flex-nowrap gap-8 container mx-auto px-3 lg:px-0 mt-9" x-data="admin">
                <div x-init="fetchListOrder()"></div>
                <div class="w-full lg:col-3">
                    @include("pages.admin.layouts.partials.sidebar")
                </div>
    
                <div class="w-full col-12 lg:col-9">
    
                    <h2 class="w-full flex items-center justify-center gap-2 py-3 border border-primary dark:border-white dark:bg-slate-secondary rounded-primary text-[20px]">
                        <i class="span font-bold dark:text-white" data-feather="credit-card"></i>
                        <p>
                        <span class="span dark:text-white">Dashboard</span>
                        Admin (Orders)
                    </p>
                    </h2>
    
                    <div class="relative mt-6 mb-10 flex items-center justify-between flex-wrap lg:flex-nowrap gap-y-4 col-12">
    
                        <div class="w-full flex items-center flex-wrap lg:flex-nowrap gap-2 gap-y-3" >
    
                            <div class="p-2 w-full flex items-center justify-between bg-white dark:bg-slate-secondary shadow-[0px_0px_4px_#7C000B] dark:shadow-none dark:border dark:border-white rounded-lg">
                                <input type="text" placeholder="Search Here..." @change="searchOrder(keyword)" x-model="keyword" class="w-[93%] dark:text-white">
                                <img class="w-[24px] h-[24px]" src="{{ asset('./assets/images/search.png') }}" alt="">
                            </div>
    
                            <button @click="sortOrder('payment_date')" class="group w-full lg:col-2 flex items-center justify-center gap-2 p-2 rounded-primary border border-primary dark:bg-slate-secondary dark:border-white dark:text-slate-fourth transition duration-200 ease-in-out">
                                <p>
                                    <span class="span dark:text-white">Sort By:</span>A/Z
                                </p>
                                <i data-feather="repeat" class="rotate-90 w-4 h-4 text-gray-secondary group-hover:-rotate-90 dark:group-hover:text-white transition duration-200 ease-in-out"></i>
                            </button>
    
                        </div>
    
                    </div>
    
                    <template x-if="!isLoading">
                        <div class="w-full">
                            <div class="w-full rounded-primary bg-white shadow-lg">
                                <div class="w-full text-center bg-primary dark:bg-slate-secondary py-2 text-white">List Orders</div>
                                <div class="overflow-x-auto">
                                    <table class="w-full overflow-x-scroll items-center bg-transparent border-collapse">
                                        <thead>
                                          <tr>
                                            <th class="px-6 align-middle dark:bg-slate-third dark:text-white border border-primary dark:border-none py-3 text-xs uppercase whitespace-nowrap font-semibold text-left bg-pink-800">Name</th>
                                            <th class="px-6 align-middle dark:bg-slate-third dark:text-white border border-primary dark:border-none py-3 text-xs uppercase whitespace-nowrap font-semibold text-left bg-pink-800">Plan</th>
                                            <th class="px-6 align-middle dark:bg-slate-third dark:text-white border border-primary dark:border-none py-3 text-xs uppercase whitespace-nowrap font-semibold text-left bg-pink-800">Virtual Number</th>
                                            <th class="px-6 align-middle dark:bg-slate-third dark:text-white border border-primary dark:border-none py-3 text-xs uppercase whitespace-nowrap font-semibold text-left bg-pink-800">Payment Date</th>
                                            <th class="px-6 align-middle dark:bg-slate-third dark:text-white border border-primary dark:border-none py-3 text-xs uppercase whitespace-nowrap font-semibold text-left bg-pink-800">Actions</th>
                                          </tr>
                                        </thead>
            
                                        <tbody>
                                            <template x-for="(item, index) in listOrder.data">
                                                <tr class="border border-b-slate-secondary dark:bg-slate-fourth dark:text-slate-secondary">
                                                    {{-- not defined --}}
                                                    <td x-bind:class="item.user.name ? 'border-t-0 px-5 py-2 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap font-semibold' : 'border-t-0 px-5 py-2 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap font-semibold text-[#86A3B8] dark:text-[#787A91] italic' " x-text="item.user.name ? item.user.name : 'Undefined'"></td>
                                                    <td x-bind:class="item.plan.name ? 'border-t-0 px-5 py-2 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap' : 'border-t-0 px-5 py-2 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap text-[#86A3B8] dark:text-[#787A91] italic' " x-text="item.plan.name ? item.plan.name : 'Undefined'">
                                                    <i class="fas fa-circle text-orange-500 mr-2"></i>
                                                    </td>
                                                    <td class="border-t-0 px-5 py-2 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap">
                                                    <i class="fas fa-circle text-orange-500 mr-2" x-text="item.virtual_account_number ? item.virtual_account_number : 'No data'"></i>
                                                    </td>
                                                    <td class="border-t-0 px-5 py-2 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap">
                                                    <i class="fas fa-circle text-orange-500 mr-2" x-text="item.payment_date ? convertDate(item.payment_date) : 'No data'"></i>
                                                    </td>
                                                    <td class="flex items-center w-full h-full border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 gap-2">
                                                        <button @click="showOrder(true, item.id)" class="group" title="Details">
                                                            <i data-feather="eye" class="group-hover:text-primary dark:group-hover:text-white transition duration-200 ease-in-out w-5 h-5 lg:w-6 lg:h-6"></i>
                                                        </button>
                                                    </td>
                                                    <script>
                                                        feather.replace()
                                                    </script>
                                                </tr>
                                            </template>
                                            <template x-if="listOrder.data.length == 0">
                                                <tr class="text-center border border-b-slate-secondary dark:bg-slate-fourth">
                                                    <td colspan="5">
                                                        <span class="text-base dark:text-white">Empty Data</span>
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
                                    <b>
                                        <span x-text="listOrder.current_page"></span> /
                                        <span class="span dark:text-slate-third" x-text="listOrder.last_page"></span>
                                    </b>
                                </p>
                                <ul class="flex items-center justify-center gap-2">
                                    <template x-if="listOrder.current_page != 1">
            
                                        <a @click="paginateOrder(listOrder.prev_page_url)" class="w-8 h-8 cursor-pointer leading-7 rounded-full text-center border border-primary dark:border-white hover:bg-primary dark:bg-slate-third hover:text-white transition duration-200 ease-in-out">
            
                                            <
            
                                        </a>
            
                                    </template>
                                    <template x-for="(order, index) in listOrder.links">
                                        <template x-if="index != 0 && index != (listOrder.links.length - 1) && listOrder.last_page > 1">
                                            <li :class="
                                            {
                                                'bg-active' : listOrder.current_page == order.label,
                                                '' : listOrder.current_page != order.label,
                                            }" @click="paginateOrder(order.url); console.log(order.url)" class="w-8 h-8 cursor-pointer leading-7 rounded-full text-center border border-primary dark:border-white hover:bg-primary dark:bg-slate-third hover:text-white dark:hover:text-white transition duration-200 ease-in-out">
                                            {{-- <span x-text="console.log(categoriesArticle)"></span> --}}
                                                <button
                                                x-text="order.label">
                                                </button>
                                            </li>
                                        </template>
                                    </template>
                                    <template x-if="listOrder.current_page < listOrder.last_page">
                                        <a @click="paginateOrder(listOrder.next_page_url)" class="w-8 h-8 cursor-pointer leading-7 rounded-full text-center border border-primary dark:border-white hover:bg-primary dark:bg-slate-third hover:text-white transition duration-200 ease-in-out">
            
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
    
    
            <div class="hidden py-12 bg-gray-700 transition duration-150 ease-in-out z-10 top-0 w-full h-full" id="modal" style="position: fixed; background: rgba(0, 0, 0, 50%)" x-data="admin">
                <div role="alert" class="relative top-[13%] lg:top-[17%] container mx-auto w-11/12 md:w-2/3 max-w-lg">
                    <div class="relative py-8 px-5 md:px-10 bg-white dark:text-white dark:bg-slate-secondary shadow-md rounded border border-gray-400">
                        <div class="w-full flex justify-start text-primary dark:text-white mb-3">
                            <i data-feather="credit-card" class="w-14 h-14"></i>
                        </div>
                        <h1 class="text-gray-800 font-lg font-bold tracking-normal leading-tight mb-4">Details Order</h1>
                        <p class="mt-3">
                            <b class="span dark:text-slate-fourth">Name : </b>
                            <span class="dark:text-white" id="nameOrder">Adnan Erlansyah</span>
                        </p>
                        <p class="mt-3">
                            <b class="span dark:text-slate-fourth">Email : </b>
                            <span class="dark:text-white" id="emailOrder">adnanerlasyah403@gmail.com</span>
                        </p>
                        <p class="mt-3">
                            <b class="span dark:text-slate-fourth">Plan Order : </b>
                            <span class="dark:text-white" id="planOrder">Lifetime</span>
                        </p>
                        <p class="mt-3">
                            <b class="span dark:text-slate-fourth">Virtual Number : </b>
                            <span class="dark:text-white" id="vaOrder"></span>
                        </p>
                        <p class="mt-3">
                            <b class="span dark:text-slate-fourth">Price : </b>
                            <span class="dark:text-white" id="priceOrder">$100.00</span>
                        </p>
                        <p class="mt-3">
                            <b class="span dark:text-slate-fourth">Payment Date : </b>
                            <span class="dark:text-white" id="paymentDateOrder">27 Jan, 2023</span>
                        </p>
                        <p class="mt-3" id="imageOrderWrapper" style="display: none;">
                            <b class="span dark:text-slate-fourth">Screenshoot : </b> <br>
                            <img src="" id="imageOrder" class="mt-2 w-full h-[200px]" alt="">
                        </p>
                        <button class="cursor-pointer absolute top-0 right-0 mt-4 mr-5 text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out rounded focus:ring-2 focus:outline-none focus:ring-gray-600" @click="showOrder()" aria-label="close modal" role="button">
                            <svg  xmlns="http://www.w3.org/2000/svg"  class="icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" />
                                <line x1="18" y1="6" x2="6" y2="18" />
                                <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>
                        </button>
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
    // let modal = document.getElementById("modal");
    // function modalHandler(val) {
    //     if (val) {
    //         fadeIn(modal);
    //     } else {
    //         fadeOut(modal);
    //     }
    // }
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
