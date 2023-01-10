
@section("title", "Me - Freemium App")

<section class="py-[100px]">
    <h1 class="font-iceberg text-lg text-center text-primary mb-16">ME</h1>

    <div class="container mx-auto mb-9">

        <nav class="col col-12" style="margin-inline: 0;">
            <ul class="flex items-center justify-center lg:justify-start gap-7">
                <li class="pb-2 border-b border-primary cursor-pointer">
                    <a href="{{ route('profile.index') }}" class="text-base font-iceberg">
                        <span class="span">My</span> 
                        Profile 
                    </a>
                </li>
                <li class="pb-2 cursor-pointer">
                    <a href="{{ route('article.index') }}" class="text-base font-iceberg">
                        <span class="span">My</span> 
                        Articles 
                    </a>
                </li>
            </ul>
        </nav>

    </div>

    <div class="container mx-auto flex flex-wrap md:flex-nowrap gap-10 lg:gap-0">
        

        <div class="col col-12 order-2 lg:order-1 lg:col-8" style="margin-left: 0px;">
            <form action="">

                <div class="flex items-center gap-5 mb-7 pl-4 lg:pl-0 pr-2 bg-white rounded-primary shadow-[0px_0px_4px_rgba(0,0,0,0.25)]">
                    <span class="bg-primary text-white text-center hidden lg:block lg:px-6 py-3 rounded-primary">
                        Full Name
                    </span>
                    <input type="text" class="py-3 lg:w-4/5" placeholder="Your full name..." title="Full Name">
                </div>

                <div class="flex items-center gap-5 mb-7 pl-4 lg:pl-0 pr-2 bg-white rounded-primary shadow-[0px_0px_4px_rgba(0,0,0,0.25)]">
                    <span class="bg-primary text-white text-center hidden lg:block lg:px-6 py-3 rounded-primary">
                        Username
                    </span>
                    <input type="text" class="py-3 w-full lg:w-4/5" placeholder="Your username..." title="Username">
                </div>

                <div class="flex items-center gap-5 mb-7 pl-4 lg:pl-0 pr-2 bg-white rounded-primary shadow-[0px_0px_4px_rgba(0,0,0,0.25)]">
                    <span class="bg-primary text-white text-center hidden lg:block lg:px-6 py-3 rounded-primary" title="Email">
                        Email
                    </span>
                    <input type="email" class="py-3 w-full lg:w-4/5" placeholder="Your email...">
                </div>
                
                <div class="flex items-center gap-5 mb-7 pl-4 lg:pl-0 pr-2 bg-white rounded-primary shadow-[0px_0px_4px_rgba(0,0,0,0.25)]">
                    <span class="bg-primary text-white text-center hidden lg:block lg:px-6 py-3 rounded-primary" title="Password">
                        Password
                    </span>
                    <input type="password" class="py-3 w-full lg:w-4/5" placeholder="Your password...">
                </div>
                
                <div class="flex items-center gap-5 mb-7 pr-2 bg-white rounded-primary shadow-[0px_0px_4px_rgba(0,0,0,0.25)]">
                    <span class="cursor-pointer bg-primary text-white text-center px-4 lg:px-6 py-3 rounded-primary" title="Upload Photo Profile">
                        Upload
                    </span>
                    <input type="file" class="py-3 w-full lg:w-4/5" placeholder="Your password...">
                </div>
                
                <ul class="flex items-center justify-center gap-4 my-12">
                    <li class="w-max cursor-pointer p-3 rounded-full bg-[#4267B2] text-white hover:bg-primary transition duration-200 ease-in-out">
                        <i data-feather="facebook"></i>
                    </li>
                    <li class="w-max cursor-pointer p-3 rounded-full bg-[#0077B5] text-white hover:bg-primary transition duration-200 ease-in-out">
                        <i data-feather="linkedin"></i>
                    </li>
                    <li class="w-max cursor-pointer p-3 rounded-full bg-[#C13584] text-white hover:bg-primary transition duration-200 ease-in-out">
                        <i data-feather="instagram"></i>
                    </li>
                    <li class="w-max cursor-pointer p-3 rounded-full bg-[#1DA1F2] text-white hover:bg-primary transition duration-200 ease-in-out">
                        <i data-feather="twitter"></i>
                    </li>
                </ul>

                <div class="flex items-center gap-5 mb-7 pl-4 lg:pl-0 pr-2 bg-white rounded-primary shadow-[0px_0px_4px_rgba(0,0,0,0.25)]">
                    <span class="bg-primary text-white text-center hidden lg:block lg:px-6 py-3 rounded-primary">
                        Link Social Media
                    </span>
                    <input type="url" class="py-3 w-full lg:w-[70%]" placeholder="Your link social..." title="Link Social Media">
                </div>

                <div class="flex items-center justify-center mt-10">
                    <button type="submit" class="py-2 px-4 rounded-primary outline outline-1 outline-primary text-primary hover:bg-primary hover:text-white hover:outline-none transition duration-200 ease-in-out">
                        Save
                    </button>
                </div>
            </form>
        </div>
        
        <div class="col col-12 lg:col-4 md:order-2 h-max py-5 px-4 rounded-primary bg-white shadow-[0px_0px_4px_rgba(0,0,0,0.25)] flex flex-col items-center">
            <figure>
                <img src="" class="w-[100px] h-[100px] bg-gray-secondary rounded-full" alt="">
            </figure>
            <span class="text-md font-semibold">Adnan Erlansyah</span>
            <p>adnanerlansyah403@gmail.com</p>
            <div class="mt-12 flex flex-col items-center justify-center">
                <span class="mb-4 font-semibold text-primary">AUTHOR</span>
                <p class="flex items-center gap-2">
                    <span class=" font-bold">Status : </span>
                    <span class="bg-primary rounded-primary py-1 px-3 text-white">Member - Lifetime</span>
                </p>
            </div>
        </div>

    </div>
    
    <script>
        async function getData() {
          try {
            const response = await fetch('https://localhost:8001/api/article', {
                    method: 'GET',
                    headers: new Headers({
                        'Access-Control-Allow-Origin': '*'
                    }),
                });

            const data = await response.json();
            this.data = data;
            console.log(data);
          } catch (e) {
            this.error = e.message;
            console.log(e.message);
          }
        }
        getData();
      </script>

</section>