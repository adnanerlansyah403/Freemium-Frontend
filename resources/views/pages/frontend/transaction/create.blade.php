<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield("title", "Plans - Freemium App")</title>

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

    {{-- AlpineJS Link --}}

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="{{ asset('assets/js/auth.js') }}"></script>
    <script src="{{ asset('assets/js/user.js') }}"></script>


</head>
<body x-data="user" x-init="checkSession()"
>
    <section class="py-[60px]" style="display: none;"
        x-init="
            if(isLogedIn == true) {
                return document.querySelector('section').style.display = 'block';
            }
        "
    >
        <div class="container mx-auto flex flex-col">

            <a href="#" class="flex items-center justify-center">
                <span class="span text-2xl">F</span>
                <p class="text-xl font-iceberg">reemium</p>
            </a>

            <h1 class="text-lg lg:text-xl text-center">
                GET UNLIMITED ACCESS TO <br>
                EVERYTHING IN FREEMIUM
            </h1>

            <div class="mt-14 mb-10 flex flex-col items-center text-center">
                <h3 class="text-md text-gray-secondary">Plans at less 100$/Year</h3>
                <ul class="mt-4">
                    <li class="flex items-center gap-2">
                        <i data-feather="check-circle" class="text-primary"></i>
                        <span>Unlimited Content both free and paid</span>
                    </li>
                </ul>
            </div>


                <div class="mb-14 flex flex-wrap lg:flex-nowrap items-center justify-center gap-6">
                    <div class="w-[300px] text-center py-5 border border-primary rounded-primary transition duration-200 ease-in-out plan" x-ref="cardplan1">
                        <span class="text-md">Yearly</span>

                        <p class="mt-12 mb-8 text-base text-slate-secondary">100$/Year</p>

                        <button type="button"
                            class="px-4 py-2 bg-primary text-white hover:text-opacity-80 rounded-pill"
                            @click="
                                $refs.plan1.click();
                                $refs.textplan2.innerText = 'Select';
                                $refs.cardplan2.classList.remove('active');
                                $refs.cardplan1.classList.add('active');
                                $refs.textplan1.innerText = 'Selected'
                            "
                        >
                            <span x-ref="textplan1">Select</span>
                            <input type="radio" name="plan" x-model="plan" value="1" id="plan" style="display: none;" x-ref="plan1">
                        </button>

                    </div>

                    <div class="w-[300px] text-center py-5 border border-primary rounded-primary transition duration-200 ease-in-out plan" x-ref="cardplan2">
                        <span class="text-md">Unlimited</span>

                        <p class="mt-12 mb-8 text-base text-slate-secondary">300$/Lifetime</p>

                        <button type="button"
                            class="px-4 py-2 bg-primary text-white hover:text-opacity-80 rounded-pill"
                            @click="
                                $refs.plan2.click();
                                $refs.textplan1.innerText = 'Select'
                                $refs.cardplan1.classList.remove('active');
                                $refs.cardplan2.classList.add('active');
                                $refs.textplan2.innerText = 'Selected'
                            "
                        >
                            <span x-ref="textplan2">Select</span>
                            <input type="radio" name="plan" x-model="plan" value="2" id="plan" x-ref="plan2" style="display: none;">
                        </button>

                    </div>

                </div>

                <div class="lg:w-[630px] lg:mx-auto">
                    <span class="text-md font-semibold">Pay With : </span>

                    <div class="flex items-center gap-5 mt-7 pr-2 bg-white rounded-primary shadow-[0px_0px_4px_rgba(0,0,0,0.25)]">
                        <span class="bg-primary text-white text-center px-4 py-2 rounded-primary">
                            <i data-feather="credit-card"></i>
                        </span>
                        <span class="py-3 font-semibold">Virtual Account</span>
                    </div>
                </div>

                <div class="flex items-center justify-center mt-10">
                    <button @click.prevent="paySubscription()" type="submit" class="px-4 py-2 rounded-pill text-white bg-primary hover:text-opacity-80 transition duration-200 ease-in-out">
                        Pay Now
                    </button>
                    <h1 x-text="plan"></h1>
                </div>



        </div>
    </section>



    <!-- Feather Icons Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace()
    </script>

</body>
</html>
