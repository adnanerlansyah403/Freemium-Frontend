<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield("title", "Details Transaction - Freemium App")</title>

    {{-- Custome CSS Link --}}

    <link rel="stylesheet" href="{{ asset("assets/css/style.css") }}">

    {{-- AlpineJS Link --}}

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="{{ asset('assets/js/auth.js') }}"></script>
    <script src="{{ asset('assets/js/user.js') }}"></script>
    
    <!-- Vite Link CSS -->

    @vite('resources/css/app.css')

    <!-- Ionicons -->
    
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</head>
<body x-data="user" x-init="checkSession()"
style="display: none;">
<div x-init="fetchMyTransactions()"></div>
    <section class="py-[60px]"
        x-init="
            if(isLogedIn == true) {
                setTimeout(() => {
                    return document.body.style.display = 'block';
                }, 1000)
            }
        ">
        
        <div class="container mx-auto flex flex-col">

            <a href="#" class="flex items-center justify-center">
                <span class="span text-2xl">F</span>
                <p class="text-xl font-iceberg">reemium</p>
            </a>

            <h1 class="text-lg md:text-xl text-center font-poppins mt-12 mb-14">
                Details Transaction  
            </h1>

            <div class="mb-8 text-center">
                <span class="text-base md:text-md text-gray-secondary">Payment Code ( Transaction No. )</span>
                <p class="font-bold text-[20px] mt-2" x-text="myTransactions.virtual_account_number">
                    
                </p>
            </div>

            <div class="max-w-[630px] mx-auto pt-3 pb-4 px-4 border border-primary rounded-primary">

                <div class="flex items-center justify-between flex-wrap mb-10">
                    <span class="text-slate-secondary text-base">Amount</span>
                    <div>
                        $<span x-text="myTransactions.total_price">
                            
                        </span>/<span x-text="myTransactions.plan[0].name" class="span"></span>
                    </div>
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
                                    $refs.removefile.classList.add('active')
                                }
                            }
                        ">
                    <span
                        class="relative cursor-pointer flex items-center justify-center h-[200px] lg:h-[500px] px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white mt-4 overflow-y-hidden"
                        @click="
                            $refs.file.click();
                        "
                    >
                        <img src="" 
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
                    <button type="submit" @click="updateMyTransaction()" class="bg-primary px-4 py-2 rounded-pill text-white hover:text-opacity-80 transition duration-200 ease-in-out">
                        Confirm Payment
                    </button>

                    <a href="{{ route('homepage') }}" class="bg-primary px-4 py-2 rounded-pill text-white hover:text-opacity-80 transition duration-200 ease-in-out">
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