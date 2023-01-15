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
                    Admin (Category)
                </p>
                </h2>

                <div class="mt-6 mb-10 flex items-center justify-between flex-wrap gap-y-4">

                    <button class="flex items-center gap-1">
                        <i class="span" data-feather="plus-square"></i>
                        Add Category
                    </button>

                    <div class="w-full flex items-center flex-wrap gap-2 gap-y-3">

                        <div class="p-2 w-full flex items-center justify-between bg-white shadow-[0px_0px_4px_#7C000B] rounded-lg">
                            <input type="text" placeholder="Search Here..." class="w-[93%]">
                            <img class="w-[24px] h-[24px]" src="{{ asset('./assets/images/search.png') }}" alt="">
                        </div>

                        <button class="group w-full flex items-center justify-center gap-2 p-2 rounded-primary border outline-1 hover:text-white outline-primary hover:outline-none hover:bg-primary transition duration-200 ease-in-out">
                            <p>
                                <span class="span group-hover:text-white">Sort By:</span>A/Z
                            </p>
                            <i data-feather="repeat" class="rotate-90 w-4 h-4 text-gray-secondary group-hover:text-white"></i>
                        </button>

                    </div>

                </div>

                <div class="w-full rounded-primary bg-white shadow-lg">
                    <div class="w-full text-center bg-primary py-2 text-white">List Category</div>
                    <div class="overflow-x-auto">
                        <table class="w-full overflow-x-scroll items-center bg-transparent border-collapse">
                            <thead>
                              <tr>
                                <th class="px-6 align-middle border border-primary py-3 text-xs uppercase whitespace-nowrap font-semibold text-left bg-pink-800">Name</th>
                                <th class="px-6 align-middle border border-primary py-3 text-xs uppercase whitespace-nowrap font-semibold text-left bg-pink-800">Icon</th>
                                <th class="px-6 align-middle border border-primary py-3 text-xs uppercase whitespace-nowrap font-semibold text-left bg-pink-800">Actions</th>
                              </tr>
                            </thead>
                    
                            <tbody>
                              <tr class="border border-b-primary">
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 font-semibold">Laravel</td>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                  <i class="fas fa-circle text-orange-500 mr-2"></i>laravel
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


    </div>
</section>


@endsection