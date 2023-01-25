@extends('homepage')

{{-- @section('title', 'Details Article - Freemium App') --}}

{{-- Title Section --}}
<div x-data="user" x-init="checkSession()">
    <template x-if="isLogedIn">
        <script>
            document.title = 'Details Article - Freemium App';
        </script>
    </template>
</div>

@section('content')

    <style>
        code,p,strong,em {
            display: inline;
        }
        blockquote, dl, dd, h1, h2, h3, h4, h5, h6, hr, figure, p, pre {
            margin: unset;
        }
        #description h1 {
            font-size: 2em;
            font-weight: bold;
        }

        #description h2 {
            font-size: 1.5em;
            font-weight: bold;
        }

        #description h3 {
            font-size: 1.17em;
            font-weight: bold;
        }

        #description h4 {
            font-size: 1em;
            font-weight: bold;
        }

        #description h5 {
            font-size: 0.83em;
            font-weight: bold;
        }

        #description h6 {
            font-size: 0.67em;
            font-weight: bold;
        }

    </style>

    <section class="pt-[140px] pb-[100px] dark:text-white" x-data="user" >
        <div x-init="checkSession()"></div>
        <div x-data="articles">
            <span x-init="getDetailArticle(window.location.href.split('/').pop())"></span>

            {{-- <div class="container mx-auto">
                <figure class="mb-7">
                    <img x-bind:src="content ? imgUrl + content?.thumbnail : imgUrl + detailArticle?.thumbnail" src=""
                        class="w-full h-[400px] bg-gray-secondary rounded-primary" alt="">
                </figure>

            </div> --}}
            <template x-if="!isLoadingArticle">
                <div class="container mx-auto flex flex-wrap lg:flex-nowrap gap-6 md:gap-4">

                    <div class="relative col md:mx-0 col-12 lg:col-8 order-1 lg:order-1">

                        <div class="px-4 py-5 rounded-primary bg-white dark:bg-slate-secondary shadow-[0px_0px_4px_rgba(0,0,0,0.25)]">

                            <h2 class="text-md text-[#3A3440] dark:text-white font-bold border border-gray-third rounded-primary dark:border-gray-secondary mb-5 p-2" x-text="content ? content?.title : detailArticle?.title">Judul Artikel
                            </h2>

                            <div class="flex items-start flex-wrap gap-4 md:gap-0 justify-between">
                                <div class="flex gap-3">
                                    <figure>
                                        <div>
                                            <img x-bind:src="
                                                detailArticle?.author?.photo != null && detailArticle?.author?.photo != ''
                                                ? imgUrl + detailArticle?.author?.photo
                                                : imgUrl + 'img/user1.png'"
                                            src=""
                                            class="w-[50px] h-[50px] bg-gray-secondary rounded-full border-none" alt="">
                                        </div>
                                    </figure>
                                    <div class="">
                                        <b class="text-base font-semibold" x-text="detailArticle?.author?.username">Nama Author</b>
                                        <span class="block text-gray-primary dark:text-gray-third" x-text="detailArticle?.author?.email"></span>
                                    </div>
                                </div>
                                <div x-show="!isLoading" class="flex items-center gap-3 translate-y-1" x-data="helpers">
                                    <span class="flex items-center gap-1">
                                        <i data-feather="calendar" class="w-4 h-4"></i>
                                        <p x-text="convertDate(content ? content?.created_at : detailArticle?.created_at)">
                                        </p>
                                    </span>
                                    <span class="flex items-center gap-1 translate-y-[1px]">
                                        <template x-if="detailArticle.total_views_sum > 0">
                                            <span>
                                                <i data-feather="eye" class="-mt-[2px] w-4 h-4"></i>
                                                <script>
                                                    feather.replace()
                                                </script>
                                            </span>
                                        </template>
                                        <p>
                                            <span x-show="detailArticle?.total_views_sum == null ? detailArticle.total_views_sum = 0 : ''"></span>
                                            <span x-text="content ? content?.total_views : detailArticle?.total_views_sum">
                                            </span>
                                            Views
                                        </p>
                                    </span>
                                </div>
                            </div>

                            <div class="mt-4">
                                <figure class="mt-4" x-bind:class="
                                content?.thumbnail == '' || 
                                detailArticle?.thumbnail == '' ? 'hidden' : ''">
                                    <img x-bind:src="content ? imgUrl + content?.thumbnail : imgUrl + detailArticle?.thumbnail" src=""
                                        class="w-full h-[500px] bg-gray-secondary rounded-primary" alt="">
                                </figure>
                                <div id="description" x-show="!isLoading" class="mt-6 font-quickSand text-[#3A3440] dark:text-white font-semibold" x-html="content ? content?.description : detailArticle?.description">
                                </div>
                            </div>

                            <div class="flex items-center w-full"
                                x-bind:class="detailArticle?.tags.length > 0 ? 'justify-between mt-12' : 'justify-end mt-6'">
                                <div class="flex content-center flex-wrap gap-3" x-bind:class="detailArticle?.tags.length > 0 ? '' : 'hidden'">
                                    <template x-for="(item, index) in detailArticle?.tags">
                                        <a class="px-3 py-2 bg-primary text-white dark:bg-slate-third pointer-events-none rounded-primary text-sm font-bold font-iceberg drop-shadow-[0px_0px_4px_rgba(0,0,0,0.3)]"
                                            x-text="item.category.name"></a>
                                    </template>

                                </div>
                                <template x-if="detailArticle?.subarticles.length > 0">
                                    <div class="flex items-center gap-4">
                                        <div class="flex items-center gap-2">
                                            <span x-text="content ? detailArticle?.subarticles?.findIndex(x => x.id == content?.id) + 1 + ' of ' + detailArticle?.subarticles?.length + ' sub-article': ''"></span>
                                            <button x-show="content && content?.id != detailArticle?.subarticles?.[0]?.id"
                                                x-on:click="
                                                    id = content.id;
                                                    id = detailArticle?.subarticles?.findIndex(x => x.id == id);
                                                    if(id != 0){
                                                        id = detailArticle?.subarticles?.[id - 1]?.id;
                                                        getSubArticle(id);
                                                    }
                                                    back = true;

                                                " title="PREV"
                                                class="p-2 rounded-full border border-primary hover:bg-primary hover:text-white text-black dark:text-white dark:hover:opacity-80 dark:border-none dark:bg-slate-third dark:hover:text-opacity-80 transition duration-200 ease-linear">
                                                <i data-feather="arrow-left" class="w-4 h-4"></i>
                                            </button>
                                            <button x-show="content && content?.id != detailArticle?.subarticles?.[detailArticle?.subarticles?.length - 1]?.id"
                                                x-on:click="
                                                    id = content.id;
                                                    id = detailArticle?.subarticles?.findIndex(x => x.id == id);
                                                    id = detailArticle?.subarticles?.[id + 1]?.id;

                                                    getSubArticle(id);
                                                    back = true;
                                                " title="NEXT"
                                                class="p-2 rounded-full border border-primary hover:bg-primary hover:text-white text-black dark:text-white dark:hover:opacity-80 dark:border-none dark:bg-slate-third dark:hover:text-opacity-80 transition duration-200 ease-linear">
                                                <i data-feather="arrow-right" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                    </div>

                    <div class="col md:mx-0 col-12 lg:col-4 -order-1 lg:order-2">

                        <div
                            class="lg:sticky lg:top-24 px-5 py-6 bg-white dark:bg-slate-secondary shadow-[0px_0px_4px_rgba(0,0,0,0.3)] rounded-lg" x-data="helpers">

                            <ul class="relative left-1/2 -translate-x-1/2 flex items-center justify-center gap-4 w-max p-2 rounded-lg"
                            x-bind:class="
                                 detailArticle?.author?.link_facebook == null || detailArticle?.author?.link_facebook == '' &&
                                 detailArticle?.author?.link_instagram == null || detailArticle?.author?.link_instagram == '' &&
                                 detailArticle?.author?.link_twitter == null || detailArticle?.author?.link_twitter == '' && 
                                 detailArticle?.author?.link_linkedin == null || detailArticle?.author?.link_linkedin == '' ? 'hidden' : ''
                            ">

                                <template
                                    x-if="detailArticle?.author?.link_facebook != null && detailArticle?.author?.link_facebook != ''">
                                    <li
                                        class="mb-6 p-2 rounded-full hover:bg-primary dark:hover:bg-slate-third hover:text-white transition duration-200 ease-in-out">
                                        <a x-bind:href="detailArticle?.author?.link_facebook" class="text-md" target="_blank">
                                            <i data-feather="facebook"></i>
                                        </a>
                                        <!-- Feather Icons Scripts -->
                                        <script>
                                            feather.replace()
                                        </script>
                                    </li>
                                </template>

                                <template
                                    x-if="detailArticle?.author?.link_linkedin != null && detailArticle?.author?.link_linkedin != ''">
                                    <li
                                        class="mb-6 p-2 rounded-full hover:bg-primary dark:hover:bg-slate-third hover:text-white transition duration-200 ease-in-out">
                                        <a x-bind:href="detailArticle?.author?.link_linkedin" class="text-md" target="_blank">
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
                                    x-if="detailArticle?.author?.link_instagram != null && detailArticle?.author?.link_instagram != ''">
                                    <li
                                        class="mb-6 p-2 rounded-full hover:bg-primary dark:hover:bg-slate-third hover:text-white transition duration-200 ease-in-out">
                                        <a x-bind:href="detailArticle?.author?.link_instagram" class="text-md" target="_blank">
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
                                    x-if="detailArticle?.author?.link_twitter != null && detailArticle?.author?.link_twitter != ''">
                                    <li
                                        class="mb-6 p-2 rounded-full hover:bg-primary dark:hover:bg-slate-third hover:text-white transition duration-200 ease-in-out">
                                        <a x-bind:href="detailArticle?.author?.link_twitter" class="text-md" target="_blank">
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

                            <h3 class="text-md font-semibold">Content</h3>

                            <div x-init="fetchMe()"></div>

                            <template x-if="detailArticle?.subarticles.length > 0">
                                <div x-data="{
                                    type: null,
                                }">

                                    <div class="flex items-center w-full gap-2 mb-3" x-bind:class="detailArticle?.type == 'free' || detailArticle?.subarticles?.length >= 3 && data_user.subscribe_status != 1 ? 'mt-5' : ''">
                                        <template x-if="detailArticle?.type == 'free' || detailArticle?.subarticles?.length >= 3 && data_user.subscribe_status != 1">
                                            <button type="button" x-bind:class="detailArticle?.subarticles.filter(item => item.type == 'free').length > 0 && detailArticle?.subarticles.filter(item => item.type == 'paid').length == 0 ? 'active' : ''" class="p-2 flex-1 rounded-pill font-semibold font-iceberg border border-primary hover:bg-primary hover:text-white dark:text-white dark:border-white dark:hover:bg-slate-third dark:hover:opacity-80 transition duration-200 ease-in-out" @click="
                                                type = type == 'paid' ? '' : 'paid';
                                                type == '' ? $refs.freeSub.classList.remove('active') : $refs.freeSub.classList.add('active');
                                                $refs.paidSub.classList.remove('active');
                                                " x-ref="freeSub">
                                                    <span>Free</span>
                                            </button>
                                        </template>
                                        <template x-if="detailArticle?.type == 'paid' && detailArticle?.subarticles?.length != 0 && data_user.subscribe_status != 1">
                                            <button type="button" x-bind:class="detailArticle?.subarticles.filter(item => item.type == 'paid').length > 0 && detailArticle?.subarticles.filter(item => item.type == 'free').length == 0 ? 'active' : ''" class="p-2 flex-1 rounded-pill font-semibold font-iceberg border border-primary hover:bg-primary hover:text-white dark:text-white dark:border-white dark:hover:bg-slate-third dark:hover:opacity-80 transition duration-200 ease-in-out" @click="
                                            type = type == 'free' ? '' : 'free';
                                            type == '' ? $refs.paidSub.classList.remove('active') : $refs.paidSub.classList.add('active');
                                            $refs.freeSub.classList.remove('active')
                                            " x-ref="paidSub">
                                                <span>Paid</span>
                                            </button>
                                        </template>
                                    </div>
                                    
                                    <div id="wrapperSub" class="block max-h-[408px] overflow-y-auto has-scrollbar">
                                        <ul class="flex flex-col gap-4 pr-4" x-transition x-bind:class="detailArticle?.subarticles.length > 0 ? 'mt-2' : ''">
                                            <template x-for="(item, index) in detailArticle?.subarticles">
                                                <li x-show="item.type != type" @click="
                                                    getSubArticle(item.id);
                                                    back = true;
                                                    if(showFlash){flash();}"
                                                    :class="{
                                                        'border-primary text-black': item.type == 'paid',
                                                        'bg-white border-slate-primary text-slate-primary': content?.id == item.id
                                                    }"
                                                    class="p-3 rounded-primary cursor-pointer border hover:bg-primary dark:hover:bg-slate-third dark:border dark:border-white dark:hover::border-none dark:shadow-none dark:text-slate-fourth hover:text-white dark:hover:text-white hover:translate-x-2 transition duration-200 ease-in-out flex justify-between items-center">
                                                    <a class="text-base lg:text-md font-iceberg">
                                                        <span x-text="substring(item?.title)"></span>
                                                        {{-- <b x-show="data_user?.subscribe_status != 1 && item.type == 'paid'" x-text="'(' + item.type.toUpperCase() + ')'"></b> --}}
                                                    </a>
                                                    <template x-if="content?.id == item.id">
                                                        <p class="flex items-center gap-1">
                                                            <span class="w-4 h-4 rounded-full bg-slate-primary dark:bg-slate-primary"></span>
                                                            <b>Active</b>
                                                        </p>
                                                    </template>
                                                    <template x-if="item.type == 'paid' && data_user?.subscribe_status != 1">
                                                        <div>
                                                            <i data-feather="lock"
                                                                class="hover:text-white min-w-[24px] min-h-[24px] max-w-[24px] max-h-[24px]"></i>
                                                                <script>
                                                                    feather.replace()
                                                                </script>
                                                        </div>
                                                    </template>
                                                    <script>
                                                        feather.replace()
                                                    </script>
                                                </li>
                                            </template>

                                            <p x-ref="statusUser" x-show="!fetchStatus" id="alert" class="w-full p-3 mb-3 rounded-primary border border-primary dark:border-white dark:bg-slate-primary">
                                                You have to
                                                <a href="{{ route("transaction.create") }}" class="span hover:text-opacity-80 dark:hover:text-opacity-80 dark:text-white font-bold transition duration-200 ease-in-out">Subscribe</a>
                                                to Access this
                                            </p>
        
                                            <template x-if="back">
                                                <li
                                                    {{-- @click="content = null; back = false;" --}}
                                                    @click="window.location.reload();"
                                                    class="p-3 rounded-primary shadow-[0px_0px_4px_#7C000B] dark:shadow-lg cursor-pointer bg-primary dark:bg-slate-third text-white hover:translate-x-1 transition duration-200 ease-in-out text-center">
                                                    <button class="text-base lg:text-md font-iceberg hover:text-opacity-80">Back to Article</button>
                                                </li>
                                            </template>
                                        </ul>
                                    </div>

                                </div>
                            </template>


                            <template x-if="detailArticle?.subarticles.length == 0">
                                <ul class="flex flex-col gap-4 mt-2">
                                    <li class="text-base">
                                        <span class="span dark:text-slate-fourth">No</span> Sub Article
                                    </li>
                                </ul>
                            </template>


                        </div>

                    </div>

                </div>
            </template>
            <template x-if="isLoadingArticle">
                <div class="flex justify-center px-32 py-4">
                    <x-loading-page />
                </div>
            </template>
        </div>

        <div class="">
            <x-top-button />
        </div>

    </section>

    <script>

        

    </script>

@endsection
