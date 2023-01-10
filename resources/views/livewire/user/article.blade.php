
@section("title", "Me - Freemium App")

<section class="py-[100px]">
    <h1 class="font-iceberg text-lg text-center text-primary mb-16">ME</h1>

    <div class="container mx-auto mb-9">

        <nav class="col col-12" style="margin-inline: 0;">
            <ul class="flex justify-center lg:justify-start items-center gap-7">
                <li class="pb-2 cursor-pointer">
                    <a href="{{ route("profile.index") }}" class="text-base font-iceberg">
                        <span class="span">My</span>
                        Profile
                    </a>
                </li>
                <li class="pb-2 border-b border-primary cursor-pointer">
                    <a href="{{ route("article.index") }}" class="text-base font-iceberg">
                        <span class="span">My</span>
                        Articles
                    </a>
                </li>
            </ul>
        </nav>

    </div>

    <div x-data="user" text-black>
        <button @click="fetchListMyArticle()">Fetch Data</button>
        <template x-if="isLoading">
            <p>sedang memuat....</p>
        </template>
        <template x-if="!isLoading">
            <template x-if="listMyArticle.length !=0">
                <ul>
                    <template x-for="(item, index) in listMyArticle.data">
                        <li x-text="`${index + 1 } . ${item.title}`"></li>
                    </template>
                </ul>
            </template>
         </template>

        <button x-on:click="open = !open">Toggle</button>
        <p x-text="open? 'buka': 'tutup'"></p>


        <template x-if="listMyArticle.length == 0">
            <p>Data pengguna kosong</p>
        </template>
    </div>

    <div class="container mx-auto mt-10 w-full" x-data="user">
        <div x-init="fetchListMyArticle()"></div>
        <template x-for="(item, index) in listMyArticle.data">
        <div class="flex items-center flex-wrap lg:flex-nowrap justify-center lg:justify-between gap-6 mb-10">
            <div class="col col-8" style="margin: 0 !important;">
                <div class="flex items-center gap-3">
                    <figure>
                        <img x-bind:src="imgUrl+item.author.photo" class="w-10 h-10 bg-gray-primary rounded-full" alt="">
                    </figure>
                    <div>
                        <span class="font-bold text-base" x-text="item.author.username"></span>
                        <p class="flex flex-wrap lg:flex-nowrap items-center gap-2 text-sm mt-2">
                            <span class="flex items-center gap-1" x-text="new Date(item.created_at).toDateString()">{{ \Carbon\Carbon::parse()->translatedFormat('d F Y H:i:s') }}
                                <i data-feather="calendar" class="w-4 h-4"></i>

                            </span>
                            <span class="flex items-center gap-1">
                                <i data-feather="eye" class="w-4 h-4"></i>
                                1000
                            </span>
                        </p>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-6 mb-4">
                    <span class="text-md font-bold" x-text="item.title"></span>
                    <i class="bg-primary px-4 py-2 rounded-primary text-white font-bold" x-text="item.type"></i>
                </div>
                <p class="text-sm text-gray-secondary" x-text="item.description">

                </p>
            </div>
            <figure class="col col-3 hidden lg:flex items-center justify-center" style="margin: 0 !important;">
                <img x-bind:src="imgUrl+item.thumbnail" class="w-[150px] h-[150px] bg-gray-primary rounded-lg" alt="">
            </figure>
            <div class="col col-3 lg:col-1 flex flex-row md:flex-col items-center lg:items-start gap-4">
                <a href="#" class="w-max p-2 rounded-full outline outline-1 outline-primary hover:bg-primary hover:text-white hover:outline-none transition duration-200 ease-in-out">
                    <i data-feather="edit"></i>
                </a>
                <button href="#" x-on:click="deleteArticle(item.id)" class="w-max p-2 rounded-full outline outline-1 outline-primary hover:bg-primary hover:text-white hover:outline-none transition duration-200 ease-in-out">
                    <i data-feather="trash-2"></i>
                </button>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
            <script>
                feather.replace()
            </script>
        </div>

        </template>

    </div>

</section>
