@extends("homepage")

@section("title", "Details Article - Freemium App")

{{-- Title Section --}}
{{-- <div x-data="user" x-init="checkSession()">
    <template x-if="isLogedIn">
        <script>
            document.title = 'Details Article - Freemium App';
        </script>
    </template>
</div> --}}


@section("content")

<section class="py-[100px]">
    <div class="container mx-auto">

        <figure class="mb-7">
            <img src="" class="w-full h-[250px] bg-gray-secondary" alt="">
        </figure>

    </div>

    <div class="container mx-auto flex flex-wrap lg:flex-nowrap gap-6 md:gap-0" x-data="articles">

        <span 
            x-init="getDetailArticle(window.location.href.split('/').pop())">
        </span>
        <span x-text="console.log(detailArticle.author.link_linkedin)"></span>

        <div class="col md:mx-0 col-12 lg:col-8">
            <div class="flex flex-wrap gap-4 md:gap-0 justify-between">
                <div class="flex gap-3">
                    <figure class="">
                        <img src="" class="w-[60px] h-[60px] bg-gray-secondary rounded-full border-none" alt="">
                    </figure>
                    <div class="">
                        <b class="text-md" x-text="detailArticle.author.username">Nama Author</b>
                        <div class="flex items-center gap-2" x-data="helpers">
                            <span class="flex items-center gap-1">
                                <i data-feather="calendar" class="w-4 h-4"></i>
                                <p x-text="convertDate(detailArticle.created_at)"></p>
                            </span>
                            <span class="flex items-center gap-1">
                                <i data-feather="eye" class="w-4 h-4"></i>
                                <p>
                                    <span x-text="detailArticle.total_views_sum > 0 ? detailArticle.total_views_sum : 'No'"></span>
                                    View
                                </p>
                            </span>
                        </div>
                    </div>
                </div>
                <span class="h-max px-3 py-2 rounded-primary bg-primary text-white text-[14px] mr-4">
                    Category
                </span>
            </div>

            <div>
                <h2 class="text-md mt-5 mb-4" x-text="detailArticle.title">Judul Artikel</h2>
                <p x-text="detailArticle.description">
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

        <div class="col md:mx-0 col-12 lg:col-4">

            <ul class="flex items-center justify-center gap-4">

                <template x-if="detailArticle.author.link_facebook != null || detailArticle.author.link_facebook != ''">
                    <li class="p-2 rounded-full hover:bg-primary hover:text-white transition duration-200 ease-in-out">
                        <a x-bind:href="detailArticle.author.link_facebook" class="text-md">
                            <i data-feather="facebook"></i>
                        </a>
                        <!-- Feather Icons Scripts -->
                        <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
                        <script>
                            feather.replace()
                        </script>                
                    </li>
                </template>
                
                <template x-if="detailArticle.author.link_linkedin != null || detailArticle.author.link_linkedin != ''">
                    <li class="p-2 rounded-full hover:bg-primary hover:text-white transition duration-200 ease-in-out">
                        <a x-bind:href="detailArticle.author.link_linkedin" class="text-md">
                            <i data-feather="linkedin"></i>
                        </a>
                        <!-- Feather Icons Scripts -->
                        <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
                        <script>
                            feather.replace()
                        </script>                
                    </li>
                </template>

                <template x-if="detailArticle.author.link_instagram != null || detailArticle.author.link_instagram != ''">
                    <li class="p-2 rounded-full hover:bg-primary hover:text-white transition duration-200 ease-in-out">
                        <a x-bind:href="detailArticle.author.link_instagram" class="text-md">
                            <i data-feather="instagram"></i>
                        </a>
                        <!-- Feather Icons Scripts -->
                        <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
                        <script>
                            feather.replace()
                        </script>                
                    </li>
                </template>

                <template x-if="detailArticle.author.link_twitter != null || detailArticle.author.link_twitter != ''">
                    <li class="p-2 rounded-full hover:bg-primary hover:text-white transition duration-200 ease-in-out">
                        <a x-bind:href="detailArticle.author.link_twitter" class="text-md">
                            <i data-feather="twitter"></i>
                        </a>
                        <!-- Feather Icons Scripts -->
                        <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
                        <script>
                            feather.replace()
                        </script>                
                    </li>
                </template>

            </ul>

            <div class="mt-6 px-5 py-6 bg-white shadow-[0px_0px_4px_rgba(0,0,0,0.3)] rounded-lg">
                <h3 class="text-md mb-4 font-semibold">Content</h3>
                <ul class="flex flex-col gap-4">
                    <template x-for="(item, index) in detailArticle.subarticles">
                        <li class="p-3 rounded-primary shadow-[0px_0px_4px_#7C000B] cursor-pointer hover:bg-primary hover:text-white hover:skew-y-1 transition duration-200 ease-in-out">
                            <a href="#" class="text-base lg:text-md font-iceberg" x-text="item.title">Sub-Artikel 1</a>
                        </li>
                    </template>
                </ul>
            </div>

        </div>

    </div>

</section>

@endsection