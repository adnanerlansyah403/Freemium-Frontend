@extends("homepage")


@section("content")

<div x-data="user" x-init="checkSession()">
    {{-- <div x-init="fetchMe()"></div> --}}
    <template x-if="isLogedIn && data_user.role == 1">
        <script>
            document.title = 'Dashboard Admin - Freemium App';
        </script>
    </template>
</div>

<section class="pt-[140px] pb-[100px]" x-data="admin" x-init="checkSession()" >
    <div x-init="checkRole();"></div>
    <div x-init="fetchAdminData()"></div>

    <div x-init="flash()"></div>
    <div x-show="showFlash" x-init="setTimeout(() => {
        showFlash = false
        }, 4000);
    ">
        <x-alert />
    </div>
    <template x-if="isLoading">
        <div class="w-full col-12 flex items-center justify-center mt-10">
            <x-loading-page />
        </div>
    </template>
    
    <div x-ref="wrapperDashboard">

        <template x-if="!isLoading">
            @include("layouts.partials.user.dashboard")
        </template>

        <div class="flex flex-wrap lg:flex-nowrap gap-8 container mx-auto px-3 lg:px-0 mt-9">
            <template x-if="!isLoading">
                <div class="w-full lg:col-3">
                    @include("pages.admin.layouts.partials.sidebar")
                </div>
            </template>

            <div class="w-full lg:col-9">
                <template x-if="!isLoading">
                    <div>
                        <h2 class="w-full flex items-center justify-center gap-2 py-3 border border-primary dark:border-white dark:bg-slate-secondary rounded-primary text-[20px]">
                            <i class="span font-bold dark:text-white" data-feather="activity"></i>
                            <p>
                                <span class="span dark:text-white">Dashboard</span>
                                Admin
                            </p>
                        </h2>
        
                        {{-- List Report --}}
        
                        <ul class="mt-8 flex items-center justify-center flex-wrap gap-3 w-full">
                            <li class="w-full col-12 md:col-6 lg:w-[30%] px-6 py-8 flex items-start gap-4 rounded-primary shadow-[0px_0px_4px_#7C000B] dark:shadow-none dark:border dark:border-white dark:bg-slate-secondary">
                                <i class="span dark:text-white font-bold" data-feather="users"></i>
                                <p class="dark:text-white">
                                    <b x-text="data_admin.total_users" class="block dark:text-slate-fourth">2000</b>
                                    Total <span class="span dark:text-white">Users</span>
                                </p>
                            </li>
                            <li class="w-full col-12 md:col-6 lg:w-[30%] px-6 py-8 flex items-start gap-4 rounded-primary shadow-[0px_0px_4px_#7C000B] dark:shadow-none dark:border dark:border-white dark:bg-slate-secondary">
                                <i class="span font-bold dark:text-white" data-feather="book"></i>
                                <p class="dark:text-white">
                                    <b x-text="data_admin.total_articles" class="block dark:text-slate-fourth">2000</b>
                                    Total <span class="span dark:text-white">Articles</span>
                                </p>
                            </li>
                            <li class="w-full col-12 md:col-6 lg:w-[30%] px-6 py-8 flex items-start gap-4 rounded-primary shadow-[0px_0px_4px_#7C000B] dark:shadow-none dark:border dark:border-white dark:bg-slate-secondary">
                                <i class="span font-bold dark:text-white" data-feather="users"></i>
                                <p class="dark:text-white">
                                    <b x-text="data_admin.total_members" class="block dark:text-slate-fourth">2000</b>
                                    Total <span class="span dark:text-white">Members</span>
                                </p>
                            </li>
                            <li class="w-full col-12 md:col-6 lg:w-[30%] px-6 py-8 flex items-start gap-4 rounded-primary shadow-[0px_0px_4px_#7C000B] dark:shadow-none dark:border dark:border-white dark:bg-slate-secondary">
                                <i class="span font-bold dark:text-white" data-feather="bookmark"></i>
                                <p class="dark:text-white">
                                    <b x-text="data_admin.total_categories" class="block dark:text-slate-fourth">2000</b>
                                    Total <span class="span dark:text-white">Categories</span>
                                </p>
                            </li>
                            <li class="w-full col-12 md:col-6 lg:w-[30%] px-6 py-8 flex items-start gap-4 rounded-primary shadow-[0px_0px_4px_#7C000B] dark:shadow-none dark:border dark:border-white dark:bg-slate-secondary">
                                <i class="span font-bold dark:text-white" data-feather="package"></i>
                                <p class="dark:text-white">
                                    <b x-text="data_admin.total_plans" class="block dark:text-slate-fourth">2000</b>
                                    Total <span class="span dark:text-white">Plans</span>
                                </p>
                            </li>
                            <li class="w-full col-12 md:col-6 lg:w-[30%] px-6 py-8 flex items-start gap-4 rounded-primary shadow-[0px_0px_4px_#7C000B] dark:shadow-none dark:border dark:border-white dark:bg-slate-secondary">
                                <i class="span font-bold dark:text-white" data-feather="credit-card"></i>
                                <p class="dark:text-white">
                                    <b x-text="data_admin.total_payments" class="block dark:text-slate-fourth">2000</b>
                                    Total <span class="span dark:text-white">Orders</span>
                                </p>
                            </li>
                        </ul>
                    </div>
                </template>

                {{-- Canvas Chart --}}

                <div style="display: none;"
                x-init="
                    setTimeout(() => {
                        $refs.canvasWrapper.style.display = 'block';
                    }, 500)
                " x-ref="canvasWrapper">
                    <div class="w-full mt-5">
                        <h2 class="text-base font-bold"><span class="span dark:text-white">Bar</span> Chart</h2>
                        <canvas id="barChart" class="dark:bg-slate-secondary"></canvas>
                    </div>
    
                    <div class="w-full mt-5">
                        <h2 class="text-base font-bold"><span class="span dark:text-white">Line</span> Chart</h2>
                        <canvas id="lineChart" class="dark:bg-slate-secondary"></canvas>
                    </div>
                </div>

            </div>

        </div>


    </div>

</section>



@endsection