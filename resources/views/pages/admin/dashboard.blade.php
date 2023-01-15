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

            <div class="w-full lg:col-10">
                <h2 class="w-full flex items-center justify-center gap-2 py-3 border border-primary rounded-primary text-[20px]">
                    <i class="span font-bold" data-feather="activity"></i>
                    <p>
                        <span class="span">Dashboard</span>
                        Admin
                    </p>
                </h2>

                {{-- List Report --}}

                <ul class="mt-8 flex items-center justify-center flex-wrap gap-3 w-full">
                    <li class="w-full col-12 md:col-6 lg:col-3 px-6 py-8 flex items-start gap-4 rounded-primary shadow-[0px_0px_4px_#7C000B]">
                        <i class="span font-bold" data-feather="users"></i>
                        <p>
                            <b class="block">2000</b>
                            Total <span class="span">Users</span>
                        </p>
                    </li>
                    <li class="w-full col-12 md:col-6 lg:col-3 px-6 py-8 flex items-start gap-4 rounded-primary shadow-[0px_0px_4px_#7C000B]">
                        <i class="span font-bold" data-feather="book"></i>
                        <p>
                            <b class="block">2000</b>
                            Total <span class="span">Articles</span>
                        </p>
                    </li>
                    <li class="w-full col-12 md:col-6 lg:col-3 px-6 py-8 flex items-start gap-4 rounded-primary shadow-[0px_0px_4px_#7C000B]">
                        <i class="span font-bold" data-feather="users"></i>
                        <p>
                            <b class="block">2000</b>
                            Total <span class="span">Members</span>
                        </p>
                    </li>
                    <li class="w-full col-12 md:col-6 lg:col-3 px-6 py-8 flex items-start gap-4 rounded-primary shadow-[0px_0px_4px_#7C000B]">
                        <i class="span font-bold" data-feather="bookmark"></i>
                        <p>
                            <b class="block">2000</b>
                            Total <span class="span">Categories</span>
                        </p>
                    </li>
                    <li class="w-full col-12 md:col-6 lg:col-3 px-6 py-8 flex items-start gap-4 rounded-primary shadow-[0px_0px_4px_#7C000B]">
                        <i class="span font-bold" data-feather="package"></i>
                        <p>
                            <b class="block">2000</b>
                            Total <span class="span">Plans</span>
                        </p>
                    </li>
                    <li class="w-full col-12 md:col-6 lg:col-3 px-6 py-8 flex items-start gap-4 rounded-primary shadow-[0px_0px_4px_#7C000B]">
                        <i class="span font-bold" data-feather="credit-card"></i>
                        <p>
                            <b class="block">2000</b>
                            Total <span class="span">Orders</span>
                        </p>
                    </li>
                </ul>

                {{-- Canvas Chart --}}

                <div class="w-full mt-5">
                    <h2 class="text-base font-bold"><span class="span">Bar</span> Chart</h2>
                    <canvas id="barChart"></canvas>
                </div>

                <div class="w-full mt-5">
                    <h2 class="text-base font-bold"><span class="span">Line</span> Chart</h2>
                    <canvas id="lineChart"></canvas>
                </div>

            </div>

        </div>


    </div>
</section>

<script>
    const barChart = document.getElementById('barChart');
    const lineChart = document.getElementById('lineChart');

    // Chart.defaults.backgroundColor = '#7C000B';
    // Chart.defaults.borderColor = '#fff';
    // Chart.defaults.color = '#000';

    new Chart(barChart, {
        type: 'bar',
        data: {
        labels: ['2022', '2023', '2024', '2025', '2026', '2027'],
        datasets: [
            {
                label: 'Total Members',
                data: [10, 20, 30, 40, 50, 60, 70, 80, 90, 100],
                borderWidth: 1,
                backgroundColor: '#7C000B',
            },
            {
                label: 'Total Orders',
                data: [50, 20, 30, 40, 50, 60, 70, 80, 90, 100],
                borderWidth: 1,
                backgroundColor: 'lightgreen',
            },
        ]
        },
        options: {
            scales: {
                y: {
                beginAtZero: true
                }
            }
        },
    });

    new Chart(lineChart, {
        type: 'line',
        data: {
        labels: ['2022', '2023', '2024', '2025', '2026', '2027'],
        datasets: [
            {
                label: 'Total Members',
                data: [10, 20, 30, 40, 50, 60, 70, 80, 90, 100],
                borderWidth: 1,
                backgroundColor: '#7C000B',
            },
            {
                label: 'Total Orders',
                data: [50, 20, 30, 40, 50, 60, 70, 80, 90, 100],
                borderWidth: 1,
                backgroundColor: 'lightgreen',
            },
        ]
        },
        options: {
            scales: {
                y: {
                beginAtZero: true
                }
            }
        },
    });
</script>


@endsection