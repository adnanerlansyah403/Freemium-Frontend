<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield("title", "Details Transaction - Freemium App")</title>

    {{-- Custome CSS Link --}}

    <link rel="stylesheet" href="{{ asset("assets/css/style.css") }}">

    <!-- Vite Link CSS -->

    @vite('resources/css/app.css')

    <!-- Ionicons -->
    
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</head>
<body>

    <section class="py-[60px]">
        <div class="container mx-auto flex flex-col">

            <a href="#" class="flex items-center justify-center">
                <span class="span text-2xl">F</span>
                <p class="text-xl font-iceberg">reemium</p>
            </a>

            <h1 class="text-xl text-center font-poppins mt-12 mb-14">
                Details Transaction  
            </h1>

            <div class="mb-8 text-center">
                <span class="text-md text-gray-secondary">Payment Code ( Transaction No. )</span>
                <p class="font-bold text-[20px] mt-2">
                    7489265872652078849
                </p>
            </div>

            <div class="max-w-[630px] mx-auto pt-3 pb-4 px-4 border border-primary rounded-primary">
                <div class="flex items-center justify-between mb-10">
                    <span class="text-slate-secondary text-base">Amount</span>
                    <span>100$/Year</span>
                </div>
                <div class="flex items-center justify-center gap-2">
                    <a href="#" class="bg-primary px-4 py-2 rounded-pill text-white hover:text-opacity-80 transition duration-200 ease-in-out">
                        Confirm Payment
                    </a>

                    <a href="#" class="bg-primary px-4 py-2 rounded-pill text-white hover:text-opacity-80 transition duration-200 ease-in-out">
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

</body>
</html>