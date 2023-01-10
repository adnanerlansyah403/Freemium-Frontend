@extends("homepage")

@section("title", "List - Freemium App")

@section("content")

<section class="lg:px-[12px] px-8 pt-[88px]">
    {{-- alert --}}
    <div x-data="user" class="container mx-auto">
        <div x-init="flash()"></div>
        <div x-show="showFlash">
            <x-alert />
        </div>
    </div>
    <div class="flex container mx-auto justify-center mb-[226px] flex-col lg:flex-row">
        {{-- kiri --}}
        <div class="w-full lg:col-3 lg:w-[270px] mx-auto h-max px-4 py-8 bg-white rounded-[19px] shadow-[0px_0px_4px_rgba(0,0,0,0.25)]">
            <form class="h-[44px] w-full py-2.5 px-3 rounded-[10px] border-solid border border-primary ">
                <div class="flex justify-between">
                    <input class="w-[85%] md:w-[95%] lg:w-[85%] text-[#8B8585] font-normal text-sm" placeholder="Search Here..." />
                    <img class="w-[24px] h-[24px]" src="{{ asset('./assets/images/search.png') }}" alt="">
                </div>
            </form>

            <div class="flex flex-col justify-center gap-[9px] mt-[28px]">
                <div class="text-black font-extrabold">
                    <h1 class="text-sm leading-[21px] font-extrabold">Or <span class="text-primary font-bold">Filter By</span> :</h1>
                </div>
                <div class="flex items-center gap-[5px]">
                    <input class="bg-primary" type="radio" id="html" name="fav_language" value="author">
                    <label class="mt-[2px] text-sm leading-[21px]" for="html">Author</label><br>
                </div>
                <div class="flex items-center gap-[5px]">
                    <input class="bg-primary" type="radio" id="html" name="fav_language" value="title">
                    <label class="mt-[2px] text-sm leading-[21px]" for="html">Title</label><br>
                </div>
                <div class="flex items-center gap-[5px]">
                    <input class="bg-primary" type="radio" id="html" name="fav_language" value="description">
                    <label class="mt-[2px] text-sm leading-[21px]" for="html">Description</label><br>
                </div>

            </div>

            <div class="mt-[33px] flex flex-wrap gap-[11px]">
                <a class="font-bold bg-white hover:bg-primary hover:text-white text-primary border border-primary rounded-[6px] text-xs px-[12px] py-[5px]" href="#">Category 1</a>
                <a class="font-bold bg-white hover:bg-primary hover:text-white text-primary border border-primary rounded-[6px] text-xs px-[12px] py-[5px]" href="#">Category 1</a>
                <a class="font-bold bg-white hover:bg-primary hover:text-white text-primary border border-primary rounded-[6px] text-xs px-[12px] py-[5px]" href="#">Category 1</a>
                <a class="font-bold bg-white hover:bg-primary hover:text-white text-primary border border-primary rounded-[6px] text-xs px-[12px] py-[5px]" href="#">Category 1</a>
                <a class="font-bold bg-white hover:bg-primary hover:text-white text-primary border border-primary rounded-[6px] text-xs px-[12px] py-[5px]" href="#">Category 1</a>

            </div>



        </div>

        {{-- kanan --}}
        <div class="lg:col-9 mt-5 lg:mt-0 bg-white lg:ml-[30px] md:mt-20" x-data="user">
            <div x-init="fetchMe()"></div>
            <template x-if="!data_user.subscribe_status">
                <div>
                    <div class="lg:w-full w-[320px] md:w-full bg-primary rounded-[10px] mb-2 lg:mb-[29px] md:mb-[29px] bg-opacity-20 lg:h-[50px] md:h-[50px] mt-5 lg:mt-0 h-[70px] font-normal text-sm px-[27px] py-[13px]">
                        You have to 
                        <span class="font-bold text-primary leading-[27px]">
                            Subscribe</span>  to Get Unlimited Access
                    </div>
                </div>
            </template>
            <div class="flex lg:justify-between md:justify-between mx-auto gap-5 flex-col-reverse md:w-full md:flex-row lg:flex-row items-center w-[320px] lg:w-full">
                <div class="flex gap-[47px]">
                    <h2 class="font-bold text-primary text-[18px]"> <a href="#">All</a></h2>
                    <h2 class="font-bold text-[18px]"><a href="#">Free</a></h2>
                    <h2 class="font-bold text-[18px]"><a href="#">Paid</a></h2>
                </div>
                <template  x-if="!data_user.subscribe_status">
                    <div>
                        <a href="{{ route('transaction.create') }}" class="bg-primary px-4 py-3 mb-3 rounded-[10px] flex items-center gap-2 mt-10 lg:mt-auto md:mt-auto">
                            <img class="w-6 h-6" src="{{ asset('./assets/images/check-circle.png') }}" alt="">
                            <h2 class="font-bold text-white">Get Unlimited Access</h2>
                        </a>
                    </div>
                </template>
            </div>

            {{-- list article --}}
            <div class=" border mt-5"></div>
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

            {{-- list article --}}
            <div class=" border mt-5"></div>
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

            {{-- list article --}}
            <div class=" border mt-5"></div>
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



    </div>



</section>








@endsection
