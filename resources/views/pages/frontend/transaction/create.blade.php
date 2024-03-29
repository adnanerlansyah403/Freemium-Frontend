<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield("title", "Freemium App")</title>

    {{-- Custome CSS Link --}}

    <link rel="stylesheet" href="{{ asset("assets/css/style.css") }}">

    <!-- Vite Link CSS -->

    @vite('resources/css/app.css')

    <!-- Ionicons -->

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>



    <style>

        .plan.active {
            background-color: #7C000B;
            border: none;
            color: #ffffff;
        }

        .plan.active > p {
            color: #ffffff;
        }

        .plan.active > button {
            background-color: #ffffff;
            color: #7C000B;
        }

    </style>

    {{-- SweetAlert --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- AlpineJS Link --}}

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="{{ asset('assets/js/auth.js') }}"></script>
    <script src="{{ asset('assets/js/user.js') }}"></script>


</head>
<body x-data="user" x-init="checkSession()"
style="display: none;" class="dark:bg-slate-primary dark:text-white has-scrollbar">

{{-- Title Section --}}
<template x-if="isLogedIn">
    <script>
        document.title = 'Plans - Freemium App';
    </script>
</template>

<template x-if="isLoading">
    <div class="flex justify-center px-32 py-4">
        <x-loading-page />
    </div>
</template>


<div x-init="fetchMyTransactions()"></div>
    <section class="pt-[140px] pb-[100px]"
        x-init="
            if(isLogedIn == true && myTransactions != null) {
                setTimeout(function() {
                    return document.body.style.display = 'block';
                }, 1000)
            }
        "
    >

        <div x-data="user" class="relative container mx-auto flex flex-col">


            <div class="absolute top-0 -translate-y-8 right-0 -translate-x-8 lg:-translate-x-20" x-data="helpers">
                <button id="buttonMode" @click="darkMode()" class="p-2 text-sm rounded-full bg-slate-primary dark:bg-white text-white dark:text-slate-secondary flex items-center gap-2 overflow-hidden transition duration-200 ease-in-out" title="Light Mode">
                    {{-- <ion-icon id="iconMode" class="dark:text-white" name="moon-outline"></ion-icon> --}}
                    {{-- <i id="iconMode" data-feather="moon"></i> --}}
                    <img src="{{ asset("assets/images/icons/sun.svg") }}" id="iconMode" alt="" class="transition duration-200 ease-in-out">
                </button>
            </div>

            <a href="#" class="flex items-center justify-center">
                <span class="span text-2xl dark:text-slate-third">F</span>
                <p class="text-xl font-iceberg">reemium</p>
            </a>

            <h1 class="text-md md:text-lg lg:text-xl text-center">
                GET UNLIMITED ACCESS TO <br>
                EVERYTHING IN FREEMIUM
            </h1>

            <div class="mt-14 mb-10 flex flex-col items-center text-center">
                <h3 class="text-[20px] md:text-md text-gray-secondary">Whats you get?</h3>
                <ul class="mt-4">
                    <li class="flex items-center gap-2 text-sm">
                        <i data-feather="check-circle" class="text-primary dark:text-slate-third"></i>
                        <span>Unlimited Content both free and paid</span>
                    </li>
                </ul>
            </div>

            <div x-init="fetchListPlan()"></div>
            <div class="mb-14 flex flex-wrap lg:flex-nowrap items-center justify-center gap-6" x-data="helpers">
                <template x-for="(item, index) in listPlan">
                    <div class="cardplan w-[300px] text-center py-5 border border-primary dark:border-gray-secondary rounded-primary transition duration-200 ease-in-out plan" x-bind:id="`cardplan${item.id}`">
                        {{-- <span x-text="console.log(item)"></span> --}}
                        <span class="text-md" x-text="item.name"></span>

                        <p class="mt-12 mb-8 text-base text-slate-secondary dark:text-slate-fourth">
                            <span x-text=" 'IDR' + parseFloat(item.price).toFixed(2)"></span> /
                            <b x-text="convertExpiredPlan(item.expired)"></b>
                        </p>

                        <button type="button"
                            class="px-4 py-2 bg-primary dark:bg-slate-secondary text-white hover:text-opacity-80 rounded-pill"
                            @click="
                                selectedPlan(item)
                            "
                        >
                            <span x-bind:id="`selectedplan${item.id}`" class="selectplan">Select</span>
                            <input type="radio" name="plan" x-model="plan" x-bind:value="item.id ? item.id : '1'" x-bind:id="`plan${item.id}`" style="display: none;">
                        </button>

                    </div>

                </template>
            </div>

            {{-- <div class="px-4 lg:px-0 lg:w-[630px] lg:mx-auto">
                <span class="text-md font-semibold">Pay With : </span>

                <div class="flex items-center gap-5 mt-7 pr-2 bg-white dark:bg-slate-primary rounded-primary shadow-[0px_0px_4px_rgba(0,0,0,0.25)]">
                    <span class="bg-primary dark:bg-slate-secondary text-white text-center px-4 py-2 rounded-primary">
                        <i data-feather="credit-card"></i>
                    </span>
                    <span class="py-3 font-semibold">Virtual Account</span>
                </div>
            </div> --}}

            <div class="flex items-center justify-center mt-10">
                <button @click.prevent="paySubscription()" type="submit" class="px-4 py-2 rounded-pill text-white bg-primary dark:bg-slate-secondary hover:text-opacity-80 transition duration-200 ease-in-out">
                    Pay Now
                </button>

            </div>



        </div>


    </section>



    <!-- Feather Icons Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace()
    </script>


    <script type="text/javascript">


        window.addEventListener("DOMContentLoaded", function() {
            
            if (localStorage.theme === 'light') {
                document.documentElement.classList.add('light')
                document.documentElement.classList.remove('dark')
                localStorage.theme = 'light'
                document.getElementById("buttonMode").setAttribute("title", "Light Mode")
                document.getElementById("iconMode").setAttribute("src", "http://localhost:8000/" + "assets/images/icons/sun.svg")
            } else if(localStorage.theme === 'dark') {
                document.documentElement.classList.add('dark')
                document.documentElement.classList.remove('light')
                localStorage.theme = 'dark'
                document.getElementById("buttonMode").setAttribute("title", "Dark Mode")
                document.getElementById("iconMode").setAttribute("src", "http://localhost:8000/" + "assets/images/icons/moon.svg")
            }

        });

    </script>

</body>
</html>
