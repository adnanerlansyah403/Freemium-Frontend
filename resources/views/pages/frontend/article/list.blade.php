@extends("homepage")

@section("title", "List - Freemium App")

@section("content")

<section id="filter">
    <div class="py-[88px] px-[60px] flex">
        {{-- kiri --}}
        <div class="col-3 w-[270px] h-[340px] px-8 py-8 bg-white rounded-[19px] shadow-[0px_0px_4px_rgba(0,0,0,0.25)]">
            <div class="h-[44px] w-[229px] py-2.5 px-3 rounded-[10px] border-solid border border-primary ">
                <div class="flex gap-[83px]">
                    <h1 class="text-[#8B8585] font-normal">Search Here...</h1>
                    <img class="w-[24px] h-[24px]" src="{{ asset('./assets/images/search.png') }}" alt="">
                </div>
            </div>

            <div class="flex flex-col justify-center gap-[9px] mt-[28px]">
                <div class="text-black font-extrabold"">
                    <h1 class="text-sm leading-[21px] font-extrabold">Or <span class="text-primary font-bold">Filter By</span> :</h1>
                </div>
                <div class="flex items-center gap-[5px]">
                    <div class="h-2.5 w-2.5 bg-primary rounded-full"></div>
                    <h1 class="mt-[2px] text-sm leading-[21px]"> <a href="#">Author</a></h1>
                </div>
                <div class="flex items-center gap-[5px]">
                    <div class="h-2.5 w-2.5 bg-white border border-[#8B8585] rounded-full"></div>
                    <h1 class="mt-[2px] text-sm leading-[21px]"><a href="#">Title</a></h1>
                </div>
                <div class="flex items-center gap-[5px]">
                    <div class="h-2.5 w-2.5 bg-white border border-[#8B8585] rounded-full"></div>
                    <h1 class="mt-[2px] text-sm leading-[21px]"><a href="#">Deskription</a></h1>
                </div>
            </div>

            <div class="mt-[33px] flex flex-wrap gap-[11px]">
                <div class="h-[25px] w-[101px] font-bold bg-white hover:bg-primary hover:text-white text-primary border border-primary rounded-[6px]"> <a class="text-xs leading-[18px] px-[15px] py-[5px]" href="#">Category 1</a></div>
                <div class="h-[25px] w-[101px] font-bold bg-white hover:bg-primary hover:text-white text-primary border border-primary rounded-[6px]"> <a class="text-xs leading-[18px] px-[15px] py-[5px]" href="#">Category 1</a> </div>
                <div class="h-[25px] w-[101px] font-bold bg-white hover:bg-primary hover:text-white text-primary border border-primary rounded-[6px]"> <a class="text-xs leading-[18px] px-[15px] py-[5px]" href="#">Category 1</a> </div>
                <div class="h-[25px] w-[101px] font-bold bg-white hover:bg-primary hover:text-white text-primary border border-primary rounded-[6px]"> <a class="text-xs leading-[18px] px-[15px] py-[5px]" href="#">Category 1</a> </div>

            </div>



        </div>

    {{-- kanan --}}
    <div class="col-8 bg-white ml-[30px]">
        <div class="flex justify-between items-center">
            <div class="flex gap-[47px]">
                <h2 class="font-bold text-primary"> <a href="#">All</a></h2>
                <h2 class="font-bold"><a href="#">Free</a></h2>
                <h2 class="font-bold"><a href="#">Paid</a></h2>
            </div>
            <button class="bg-primary h-[50px] w-[270px] px-5 py-3 mb-3 rounded-[10px] flex items-center gap-2">
                <img class="w-6 h-6" src="{{ asset('./assets/images/check-circle.png') }}" alt="">
                <h2 class="font-bold text-white">Get Unlimited Access</h2>
            </button>
        </div>

        {{-- list article --}}
        <div class="border mt-2.5"></div>
        <div class="flex justify-between mt-[22px]">
            <div class="h-50 w-50 flex flex-col">
                <div class="flex gap-[22px]">
                    <div class="bg-[#D9D9D9] rounded-[50px] w-[50px] h-[50px]">

                    </div>
                    <div>
                        <h1 class="text-lg font-bold mb-2">Nama Author</h1>
                        <div class="flex gap-5">
                            <p>tanggal-bulan-tahun</p>
                            <p>1000 Views</p>
                        </div>
                    </div>
                </div>


                <div class="flex justify-between items-center mt-5">
                    <div class="font-bold text-3xl leading-9">JUDUL ARTIKEL</div>
                    <button class="w-[100px] h-[30px] bg-primary text-white font-bold text-sm leading-[21px] rounded-[10px]">
                        PAID
                    </button>
                </div>
                <p class="font-normal text-sm mt-3">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                    eiusmod tempor incididunt ut labore et dolore magna aliqua. short desc
                    short desc short desc short desc short desc
                </p>

            </div>
            <div class="bg-[#D9D9D9] w-[280px] h-[180px] ml-[30px]">

            </div>
        </div>

        {{-- list article --}}
        <div class="border mt-2.5"></div>
        <div class="flex justify-between mt-[22px]">
            <div class="h-50 w-50 flex flex-col">
                <div class="flex gap-[22px]">
                    <div class="bg-[#D9D9D9] rounded-[50px] w-[50px] h-[50px]">

                    </div>
                    <div>
                        <h1 class="text-lg font-bold mb-2">Nama Author</h1>
                        <div class="flex gap-5">
                            <p>tanggal-bulan-tahun</p>
                            <p>1000 Views</p>
                        </div>
                    </div>
                </div>


                <div class="flex justify-between items-center mt-5">
                    <div class="font-bold text-3xl leading-9">JUDUL ARTIKEL</div>
                    <button class="w-[100px] h-[30px] bg-primary text-white font-bold text-sm leading-[21px] rounded-[10px]">
                        PAID
                    </button>
                </div>
                <p class="font-normal text-sm mt-3">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                    eiusmod tempor incididunt ut labore et dolore magna aliqua. short desc
                    short desc short desc short desc short desc
                </p>

            </div>
            <div class="bg-[#D9D9D9] w-[280px] h-[180px] ml-[30px]">

            </div>
        </div>

        {{-- list article --}}
        <div class="border mt-2.5"></div>
        <div class="flex justify-between mt-[22px]">
            <div class="h-50 w-50 flex flex-col">
                <div class="flex gap-[22px]">
                    <div class="bg-[#D9D9D9] rounded-[50px] w-[50px] h-[50px]">

                    </div>
                    <div>
                        <h1 class="text-lg font-bold mb-2">Nama Author</h1>
                        <div class="flex gap-5">
                            <p>tanggal-bulan-tahun</p>
                            <p>1000 Views</p>
                        </div>
                    </div>
                </div>


                <div class="flex justify-between items-center mt-5">
                    <div class="font-bold text-3xl leading-9">JUDUL ARTIKEL</div>
                    <button class="w-[100px] h-[30px] bg-primary text-white font-bold text-sm leading-[21px] rounded-[10px]">
                        PAID
                    </button>
                </div>
                <p class="font-normal text-sm mt-3">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                    eiusmod tempor incididunt ut labore et dolore magna aliqua. short desc
                    short desc short desc short desc short desc
                </p>

            </div>
            <div class="bg-[#D9D9D9] w-[280px] h-[180px] ml-[30px]">

            </div>
        </div>

        {{-- list article --}}
        <div class="border mt-2.5"></div>
        <div class="flex justify-between mt-[22px]">
            <div class="h-50 w-50 flex flex-col">
                <div class="flex gap-[22px]">
                    <div class="bg-[#D9D9D9] rounded-[50px] w-[50px] h-[50px]">

                    </div>
                    <div>
                        <h1 class="text-lg font-bold mb-2">Nama Author</h1>
                        <div class="flex gap-5">
                            <p>tanggal-bulan-tahun</p>
                            <p>1000 Views</p>
                        </div>
                    </div>
                </div>


                <div class="flex justify-between items-center mt-5">
                    <div class="font-bold text-3xl leading-9">JUDUL ARTIKEL</div>
                    <button class="w-[100px] h-[30px] bg-primary text-white font-bold text-sm leading-[21px] rounded-[10px]">
                        PAID
                    </button>
                </div>
                <p class="font-normal text-sm mt-3">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                    eiusmod tempor incididunt ut labore et dolore magna aliqua. short desc
                    short desc short desc short desc short desc
                </p>

            </div>
            <div class="bg-[#D9D9D9] w-[280px] h-[180px] ml-[30px]">

            </div>
        </div>

    </div>



    </div>



</section>








@endsection
