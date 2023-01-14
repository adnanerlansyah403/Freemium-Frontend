@extends('homepage')

@section('title', 'Details Article - Freemium App')

{{-- Title Section --}}
{{-- <div x-data="user" x-init="checkSession()">
    <template x-if="isLogedIn">
        <script>
            document.title = 'Details Article - Freemium App';
        </script>
    </template>
</div> --}}


@section('content')

    <section class="py-[100px] dark:text-white" x-data="user">
        <div x-data="articles" x-init="checkSession()">
            <span x-init="getDetailArticle(window.location.href.split('/').pop())"></span>
            <div class="container mx-auto">
                <figure class="mb-7">
                    <img x-bind:src="content ? imgUrl + content.thumbnail : imgUrl + detailArticle.thumbnail" src=""
                        class="w-full h-[250px] bg-gray-secondary" alt="">
                </figure>

            </div>

            <div class="container mx-auto flex flex-wrap lg:flex-nowrap gap-6 md:gap-0">

                <div class="col md:mx-0 col-12 lg:col-8">
                    <div class="flex flex-wrap gap-4 md:gap-0 justify-between">
                        <div class="flex gap-3">
                            <figure class="">
                                <img x-bind:src="imgUrl + detailArticle.author.photo" src=""
                                    class="w-[60px] h-[60px] bg-gray-secondary rounded-full border-none" alt="">
                            </figure>
                            <div class="">
                                <b class="text-md" x-text="detailArticle.author.username">Nama Author</b>
                                <div class="flex items-center gap-2" x-data="helpers">
                                    <span class="flex items-center gap-1">
                                        <i data-feather="calendar" class="w-4 h-4"></i>
                                        <p x-text="convertDate(content ? content.created_at : detailArticle.created_at)">
                                        </p>
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <i data-feather="eye" class="w-4 h-4"></i>
                                        <p>
                                            <span
                                                x-text="content ? content.total_views : detailArticle.total_views_sum"></span>
                                            View
                                        </p>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-md mt-5 mb-4" x-text="content ? content.title : detailArticle.title">Judul Artikel
                        </h2>
                        <p x-html="content ? content.description : detailArticle.description">
                        </p>
                    </div>

                    <div class="flex content-center flex-wrap gap-3 mt-12">
                        <template x-for="(item, index) in detailArticle.tags">
                            <a href=""
                                class="px-3 py-2 bg-white text-black rounded-primary text-sm font-bold font-iceberg drop-shadow-[0px_0px_4px_rgba(0,0,0,0.3)]"
                                x-text="item.category.name">Coding</a>
                        </template>

                    </div>

                    <div x-show="showFlash">
                        <x-alert />
                    </div>
                </div>

                <div class="col md:mx-0 col-12 lg:col-4">
                    {{-- <p class="text-center text-md mb-4 font-semibold">Link Social Media</p>
                <hr class="my-[5px] text-primary"> --}}
                    <ul class="flex items-center justify-center gap-4">

                        <template
                            x-if="detailArticle.author.link_facebook != null && detailArticle.author.link_facebook != ''">
                            <li
                                class="p-2 rounded-full hover:bg-primary dark:hover:bg-slate-third hover:text-white transition duration-200 ease-in-out">
                                <a x-bind:href="detailArticle.author.link_facebook" class="text-md" target="_blank">
                                    <i data-feather="facebook"></i>
                                </a>
                                <!-- Feather Icons Scripts -->
                                <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
                                <script>
                                    feather.replace()
                                </script>
                            </li>
                        </template>

                        <template
                            x-if="detailArticle.author.link_linkedin != null && detailArticle.author.link_linkedin != ''">
                            <li
                                class="p-2 rounded-full hover:bg-primary dark:hover:bg-slate-third hover:text-white transition duration-200 ease-in-out">
                                <a x-bind:href="detailArticle.author.link_linkedin" class="text-md" target="_blank">
                                    <i data-feather="linkedin"></i>
                                </a>
                                <!-- Feather Icons Scripts -->
                                <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
                                <script>
                                    feather.replace()
                                </script>
                            </li>
                        </template>

                        <template
                            x-if="detailArticle.author.link_instagram != null && detailArticle.author.link_instagram != ''">
                            <li
                                class="p-2 rounded-full hover:bg-primary dark:hover:bg-slate-third hover:text-white transition duration-200 ease-in-out">
                                <a x-bind:href="detailArticle.author.link_instagram" class="text-md" target="_blank">
                                    <i data-feather="instagram"></i>
                                </a>
                                <!-- Feather Icons Scripts -->
                                <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
                                <script>
                                    feather.replace()
                                </script>
                            </li>
                        </template>

                        <template
                            x-if="detailArticle.author.link_twitter != null && detailArticle.author.link_twitter != ''">
                            <li
                                class="p-2 rounded-full hover:bg-primary dark:hover:bg-slate-third hover:text-white transition duration-200 ease-in-out">
                                <a x-bind:href="detailArticle.author.link_twitter" class="text-md" target="_blank">
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

                    <div
                        class="mt-6 px-5 py-6 bg-white dark:bg-slate-secondary shadow-[0px_0px_4px_rgba(0,0,0,0.3)] rounded-lg">
                        <h3 class="text-md mb-4 font-semibold">Content</h3>
                        <ul class="flex flex-col gap-4">
                            {{-- <span x-text="detailArticle.subarticles.length == 0"></span> --}}
                            <template x-for="(item, index) in detailArticle.subarticles">
                                <li @click="getSubArticle(item.id); back = true; if(showFlash){flash();}"
                                    :class="{
                                        'bg-gray-secondary text-black': item.type == 'paid',
                                        'bg-primary text-white': content.id == item.id
                                    }"
                                    class="p-3 rounded-primary shadow-[0px_0px_4px_#7C000B] cursor-pointer hover:bg-primary dark:hover:bg-slate-third dark:border dark:border-white dark:hover::border-none dark:shadow-none hover:text-white hover:skew-y-1 transition duration-200 ease-in-out flex justify-between items-center">
                                    <a class="text-base lg:text-md font-iceberg"
                                        x-text="item.title + ' ' + item.type">Sub-Artikel 1</a>
                                    <i x-show="item.type == 'paid'" data-feather="lock"
                                        class="hover:text-white min-w-[24px] min-h-[24px] max-w-[24px] max-h-[24px]"></i>
                                    <script>
                                        feather.replace()
                                    </script>
                                </li>
                            </template>
                            <template x-if="back">
                                <li @click="content = null; back = false"
                                    class="p-3 rounded-primary shadow-[0px_0px_4px_#7C000B] cursor-pointer bg-primary text-white hover:skew-y-1 transition duration-200 ease-in-out text-center">
                                    <button class="text-base lg:text-md font-iceberg">Back to Article</button>
                                </li>
                            </template>
                            <template x-if="detailArticle.subarticles.length == 0">
                                <li class="text-base">
                                    <span class="span">No</span> Sub Article
                                </li>
                            </template>
                        </ul>
                    </div>

                </div>

            </div>
        </div>

    </section>

@endsection
