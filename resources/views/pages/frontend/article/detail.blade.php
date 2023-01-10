@extends("homepage")

@section("title", "Details Article - Freemium App")

@section("content")

<section class="py-[100px]">
    <div class="container mx-auto">

        <figure class="mb-7">
            <img src="" class="w-full h-[250px] bg-gray-secondary" alt="">
        </figure>

    </div>

    <div class="container mx-auto flex flex-wrap lg:flex-nowrap gap-6">

        <div class="col col-12 lg:col-8">
            <div class="flex gap-3">
                <figure class="">
                    <img src="" class="w-[60px] h-[60px] bg-gray-secondary rounded-full border-none" alt="">
                </figure>
                <div class="">
                    <b class="text-md">Nama Author</b>
                    <div class="flex items-center gap-2">
                        <span class="flex items-center gap-1">
                            <i data-feather="calendar" class="w-4 h-4"></i>
                            17-03-2003
                        </span>
                        <span class="flex items-center gap-1">
                            <i data-feather="eye" class="w-4 h-4"></i>
                            1000
                        </span>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-md mt-5 mb-4">Judul Artikel</h2>
                <p>
                    <b>Lorem ipsum dolor sit.</b> <br> 

                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam reiciendis et culpa doloremque voluptatibus assumenda eum nobis, deserunt eos earum quasi delectus quibusdam accusamus aperiam voluptas quis excepturi ducimus nostrum est necessitatibus explicabo aut adipisci! Voluptates accusantium unde voluptatibus repellendus, cumque similique quo alias perferendis dolorem suscipit iure optio culpa? <br> <br>

                    <b>Lorem ipsum dolor sit.</b> <br> 

                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Blanditiis labore voluptatem repellat facilis ipsum assumenda qui? Aliquid fugiat nisi incidunt praesentium mollitia eveniet doloremque deserunt optio, repudiandae ipsa blanditiis aliquam! <br> <br>
                </p>
            </div>

            <div class="flex content-center flex-wrap gap-3 mt-12">
                <a href="" class="px-3 py-2 bg-white rounded-primary text-sm font-bold font-iceberg drop-shadow-[0px_0px_4px_rgba(0,0,0,0.3)]">Coding</a>
                <a href="" class="px-3 py-2 bg-white rounded-primary text-sm font-bold font-iceberg drop-shadow-[0px_0px_4px_rgba(0,0,0,0.3)]">National</a>
                <a href="" class="px-3 py-2 bg-white rounded-primary text-sm font-bold font-iceberg drop-shadow-[0px_0px_4px_rgba(0,0,0,0.3)]">Sport</a>
                <a href="" class="px-3 py-2 bg-white rounded-primary text-sm font-bold font-iceberg drop-shadow-[0px_0px_4px_rgba(0,0,0,0.3)]">Healthy</a>
                <a href="" class="px-3 py-2 bg-white rounded-primary text-sm font-bold font-iceberg drop-shadow-[0px_0px_4px_rgba(0,0,0,0.3)]">Healthy</a>
            </div>

        </div>

        <div class="col col-12 lg:col-4">

            <ul class="flex items-center justify-center gap-4">
                <li class="p-2 rounded-full hover:bg-primary hover:text-white transition duration-200 ease-in-out">
                    <a href="" class="text-md">
                        <i data-feather="linkedin"></i>
                    </a>
                </li>
                <li class="p-2 rounded-full hover:bg-primary hover:text-white transition duration-200 ease-in-out">
                    <a href="" class="text-md">
                        <i data-feather="instagram"></i>
                    </a>
                </li>
                <li class="p-2 rounded-full hover:bg-primary hover:text-white transition duration-200 ease-in-out">
                    <a href="" class="text-md">
                        <i data-feather="twitter"></i>
                    </a>
                </li>
            </ul>

            <div class="mt-12 px-5 py-6 bg-white shadow-[0px_0px_4px_rgba(0,0,0,0.3)] rounded-lg">
                <h3 class="text-md mb-4 font-semibold">Content</h3>
                <ul class="flex flex-col gap-4">
                    <li class="p-3 rounded-primary shadow-[0px_0px_4px_#7C000B] cursor-pointer hover:bg-primary hover:text-white hover:skew-y-1 transition duration-200 ease-in-out">
                        <a href="#" class="text-base lg:text-md font-iceberg">Sub-Artikel 1</a>
                    </li>
                    <li class="p-3 rounded-primary shadow-[0px_0px_4px_#7C000B] cursor-pointer hover:bg-primary hover:text-white hover:skew-y-1 transition duration-200 ease-in-out">
                        <a href="#" class="text-base lg:text-md font-iceberg">Sub-Artikel 1</a>
                    </li>
                    <li class="p-3 rounded-primary shadow-[0px_0px_4px_#7C000B] cursor-pointer hover:bg-primary hover:text-white hover:skew-y-1 transition duration-200 ease-in-out">
                        <a href="#" class="text-base lg:text-md font-iceberg">Sub-Artikel 1</a>
                    </li>
                </ul>
            </div>

        </div>

    </div>

</section>

@endsection