<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield("title", "Freemium App")</title>

    {{-- Custome CSS Link --}}

    <link rel="stylesheet" href="{{ asset("assets/css/style.css") }}">

    {{-- AlpineJS Link --}}

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="{{ asset('assets/js/auth.js') }}"></script>
    <script src="{{ asset('assets/js/user.js') }}"></script>

    {{-- SweetAlert --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Vite Link CSS -->

    @vite('resources/css/app.css')

    <!-- Ionicons -->

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</head>
<body x-data="user" x-init="checkSession()"
style="display: none;" class="dark:bg-slate-primary dark:text-white has-scrollbar">

{{-- Title Section --}}
<template x-if="isLogedIn">
    <script>
        document.title = 'Details Transaction - Freemium App';
    </script>
</template>

<div x-init="fetchMyTransactions()"></div>
    <section class="py-[60px]"
        x-init="
            if(isLogedIn == true) {
                setTimeout(() => {
                    return document.body.style.display = 'block';
                }, 1000)
            }
        ">

        <div class="relative container mx-auto flex flex-col">

            <div class="absolute top-0 -translate-y-8 right-0 -translate-x-8" x-data="helpers">
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

            <h1 class="text-lg md:text-xl text-center font-poppins mt-12 mb-14">
                Details Transaction
            </h1>

            <span x-text="console.log(myTransactions[0])"></span>

            <div class="mb-8 text-center">
                <span class="text-base md:text-md text-gray-secondary dark:text-gray-third">Payment Code ( Transaction No. )</span>
                <p class="font-bold text-[20px] mt-2" x-text="myTransactions[0].virtual_account_number">

                </p>
            </div>

            <div class="max-w-[630px] mx-auto pt-3 pb-4 px-4 border border-primary dark:border-slate-third rounded-primary">

                <div class="flex items-center justify-center flex-wrap">
                    <span class="text-slate-secondary dark:text-slate-fourth text-base">Amount</span>
                </div>
                <div class="mt-2 mb-10 text-center">
                    $<span x-text="myTransactions[0].total_price">

                    </span>/<span x-text="myTransactions[0].plan.name" class="span dark:text-slate-fourth"></span>
                </div>

                <div class="mb-5">
                    <label for="text" class="text-[20px]">Screenshoot Transaction</label>
                    <input type="file" name="attachment" id="attachment" placeholder="Your screenshoot..."
                        hidden
                        x-ref="file"
                        @change="
                            if ($refs.file) {
                                $refs.iconimage.style.display = 'none';
                                var reader = new FileReader();
                                reader.readAsDataURL($refs.file.files[0]);
                                reader.onload = function (e) {
                                    $refs.image.src = e.target.result;
                                    $refs.image.alt = $refs.file.name;
                                    $refs.filename.classList.add('active');
                                    $refs.filename.innerText = $refs.file.files[0].name;
                                }
                            }
                        ">
                    <span
                        class="relative cursor-pointer flex items-center justify-center h-[200px] px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white dark:text-slate-secondary mt-4 overflow-y-hidden"
                        @click="
                            $refs.file.click();
                        "
                    >
                        <img src="{{ asset('assets/images/icons/sun.svg') }}"
                        x-ref="image" class="absolute w-full h-full object-cover rounded-lg" alt="">
                        <i
                            data-feather="image"
                            class="w-[100px] h-[100px] lg:h-[100px] text-gray-secondary"
                            x-ref="iconimage"
                        >
                        </i>
                        {{-- <span class="removefile absolute w-max top-3 -right-full p-2 bg-primary text-white text-center font-semibold rounded-lg hover:text-opacity-80 transition duration-200 ease-in-out" x-ref="removefile"
                        @click="">
                        </span> --}}
                        <p
                            class="filename absolute w-full -bottom-full py-2 bg-primary text-white text-center font-semibold rounded-lg transition duration-200 ease-in-out"
                            x-ref="filename"
                        >
                        </p>
                    </span>
                </div>

                <div class="flex items-center justify-center gap-2">
                    <button type="submit" @click="updateMyTransaction()" class="bg-primary dark:bg-slate-secondary px-4 py-2 rounded-pill text-white hover:text-opacity-60 transition duration-200 ease-in-out">
                        Confirm Payment
                    </button>

                    <a href="{{ route('homepage') }}" class="bg-primary dark:bg-slate-secondary px-4 py-2 rounded-pill text-white hover:text-opacity-60 transition duration-200 ease-in-out">
                        Go Back to Home
                    </a>
                </div>
            </div>

        </div>


    </section>


    <!-- Feather Icons Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace()
    </script>

    <script>

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
