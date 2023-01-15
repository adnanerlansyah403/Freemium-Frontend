@extends("homepage")


@section("content")

<div x-data="user" x-init="checkSession()">
    <div x-init="fetchMe()"></div>
    <template x-if="isLogedIn && data_user.role == 1">
        <script>
            document.title = 'Dashboard Admin - Freemium App';
        </script>
    </template>
</div>

<section class="py-[100px]" x-data="user" x-init="checkSession()" style="display: none;">
    <div x-init="checkRole()"></div>
    <div
    x-init="
        if(isLogedIn == true) {
            setTimeout(function() {
                return document.querySelector('section').style.display = 'block';
            }, 1000)
        }"
    >


        @include("layouts.partials.user.dashboard")

        <div class="flex flex-wrap lg:flex-nowrap gap-8 container mx-auto px-3 lg:px-0 mt-9">

            <div class="w-full lg:col-2">
                @include("pages.admin.layouts.partials.sidebar")
            </div>

            <div class="w-full col-12 lg:col-10">
                
                <h2 class="w-full flex items-center justify-center gap-2 py-3 border border-primary rounded-primary text-[18px]">
                    <i class="span font-bold" data-feather="activity"></i>
                    <p>
                    <span class="span">Dashboard</span>
                    Admin (Plan)
                </p>
                </h2>

                <div class="mt-6 mb-10 flex items-center justify-between flex-wrap gap-y-4">

                    <button class="flex items-center gap-1" onclick="modalHandler(true)">
                        <i class="span" data-feather="plus-square"></i>
                        Add Plan
                    </button>

                    <div class="w-full flex items-center flex-wrap gap-2 gap-y-3">

                        <div class="p-2 w-full flex items-center justify-between bg-white shadow-[0px_0px_4px_#7C000B] rounded-lg">
                            <input type="text" placeholder="Search Here..." class="w-[93%]">
                            <img class="w-[24px] h-[24px]" src="{{ asset('./assets/images/search.png') }}" alt="">
                        </div>

                        <button class="group w-full flex items-center justify-center gap-2 p-2 rounded-primary border outline-1 outline-primary transition duration-200 ease-in-out">
                            <p>
                                <span class="span group-hover:animate-bounce5">Sort By:</span>A/Z
                            </p>
                            <i data-feather="repeat" class="rotate-90 w-4 h-4 text-gray-secondary group-hover:-rotate-90 transition duration-200 ease-in-out"></i>
                        </button>

                    </div>

                </div>

                <div class="w-full rounded-primary bg-white shadow-lg">
                    <div class="w-full text-center bg-primary py-2 text-white">List Plans</div>
                    <div class="overflow-x-auto">
                        <table class="w-full overflow-x-scroll items-center bg-transparent border-collapse">
                            <thead>
                              <tr>
                                <th class="px-6 align-middle border border-primary py-3 text-xs uppercase whitespace-nowrap font-semibold text-left bg-pink-800">Name</th>
                                <th class="px-6 align-middle border border-primary py-3 text-xs uppercase whitespace-nowrap font-semibold text-left bg-pink-800">Price</th>
                                <th class="px-6 align-middle border border-primary py-3 text-xs uppercase whitespace-nowrap font-semibold text-left bg-pink-800">Expired</th>
                                <th class="px-6 align-middle border border-primary py-3 text-xs uppercase whitespace-nowrap font-semibold text-left bg-pink-800">Actions</th>
                              </tr>
                            </thead>
                    
                            <tbody>
                              <tr class="border border-b-primary">
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 font-semibold">Yearly</td>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                  <i class="fas fa-circle text-orange-500 mr-2"></i>$80.00
                                </td>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                  <i class="fas fa-circle text-orange-500 mr-2"></i>12 Month
                                </td>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 flex items-center gap-2">
                                    <a href="" class="hover:text-opacity-60 transition duration-200 ease-in-out" title="Edit">
                                        <i data-feather="edit" class="w-5 h-5 lg:w-8 lg:h-8"></i>
                                    </a>
                                    <a href="" class="hover:text-opacity-60 transition duration-200 ease-in-out" title="Delete">
                                        <i data-feather="trash-2" class="w-5 h-5 lg:w-8 lg:h-8"></i>
                                    </a>
                                </td>
                              </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-4">
                    <ul class="flex items-center justify-center gap-2">
                        <li class="w-8 h-8 cursor-pointer leading-7 rounded-full text-center border border-primary hover:bg-primary hover:text-white transition duration-200 ease-in-out">
                            <a href="" class="">1</a>
                        </li>
                        <li class="w-8 h-8 cursor-pointer leading-7 rounded-full text-center border border-primary hover:bg-primary hover:text-white transition duration-200 ease-in-out">
                            <a href="" class="">2</a>
                        </li>
                        <li class="w-8 h-8 cursor-pointer leading-7 rounded-full text-center border border-primary hover:bg-primary hover:text-white transition duration-200 ease-in-out">
                            <a href="" class="">3</a>
                        </li>
                    </ul>
                </div>

            </div>

        </div>

        
        <div class="hidden py-12 bg-gray-700 transition duration-150 ease-in-out z-10 top-0 w-full h-full" id="modal" style="position: fixed; background: rgba(0, 0, 0, 50%)">
            <div role="alert" class="relative top-[13%] lg:top-[11%] container mx-auto w-11/12 md:w-2/3 max-w-lg">
                <div class="relative py-8 px-5 md:px-10 bg-white shadow-md rounded border border-gray-400">
                    <div class="w-full flex justify-start text-primary mb-3">
                        <i data-feather="bookmark" class="w-14 h-14"></i>
                    </div>
                    <h1 class="text-gray-800 font-lg font-bold tracking-normal leading-tight mb-4">Enter a Plan</h1>
                    <label for="name" class="text-gray-800 text-sm font-bold leading-tight tracking-normal">Name</label>
                    <input id="name" class="mb-5 mt-2 text-gray-600 font-normal w-full h-10 flex items-center pl-3 text-sm border border-primary rounded-primary" placeholder="Name..." />
                    <label for="price" class="text-gray-800 text-sm font-bold leading-tight tracking-normal">Price</label>
                    <input id="price" class="mb-5 mt-2 text-gray-600 font-normal w-full h-10 flex items-center pl-3 text-sm border border-primary rounded-primary" type="number" placeholder="price..." />
                    <label for="expired" class="text-gray-800 text-sm font-bold leading-tight tracking-normal">Expired</label>
                    <input id="expired" class="mb-5 mt-2 text-gray-600 font-normal w-full h-10 flex items-center pl-3 text-sm border border-primary rounded-primary" type="number" placeholder="expired..." />
                    <button class="cursor-pointer absolute top-0 right-0 mt-4 mr-5 text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out rounded focus:ring-2 focus:outline-none focus:ring-gray-600" onclick="modalHandler()" aria-label="close modal" role="button">
                        <svg  xmlns="http://www.w3.org/2000/svg"  class="icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" />
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </button>
                    <div class="flex items-center justify-start w-full">
                        <button class="focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 transition duration-150 ease-in-out hover:bg-indigo-600 bg-primary hover:text-opacity-80 rounded text-white px-8 py-2 text-sm">Submit</button>
                        <button class="relative overflow-hidden ml-3 bg-gray-100 border border-primary text-slate-primary hover:text-opacity-70 transition duration-150 ease-in-out px-8 py-2 text-sm before:absolute" onclick="modalHandler()">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        


    </div>
</section>

<script>
    let modal = document.getElementById("modal");
    function modalHandler(val) {
        if (val) {
            fadeIn(modal);
        } else {
            fadeOut(modal);
        }
    }
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