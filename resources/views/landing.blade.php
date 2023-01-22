<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield("title", "Freemium App")</title>

        {{-- Custome CSS Link --}}

        <link rel="stylesheet" href="{{ asset("assets/css/style.css") }}">

        <!-- Vite Link CSS -->

        @vite('resources/css/app.css')

        <!-- Ionicons -->

        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

        {{-- Quill Theme --}}

        <link href="https://cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">

        {{-- ChartJS --}}

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        {{-- AlpineJS Link --}}

        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="{{ asset('assets/js/auth.js') }}"></script>
        <script src="{{ asset('assets/js/user.js') }}"></script>

        {{-- Custom Style --}}

        <style>
            .tox-notifications-container {
                display: none;
            }
            
            .tox-statusbar__branding {
                display: none;
            }

            .tox-tinymce {
                height: 500px !important;
            }

        </style>

        @livewireStyles

    </head>
    <body class="antialiased overflow-x-hidden bg-white dark:bg-slate-primary">
        
        {{-- <x-loading-page /> --}}


        <!-- HEADER -->

        @include("layouts.partials.header")

        {{-- Content --}}

        <main>
            <article>
                
                <section class="pt-[180px] pb-[90px]">
                    <div class="container px-3 mx-auto flex items-start flex-wrap lg:flex-nowrap gap-10">

                        <figure class="hidden col-12 lg:block lg:col-6">
                            <img src="{{ asset("assets/images/contentcreatefreemium.svg") }}" class="w-full h-full object-cover" alt="">
                        </figure>

                        <div class="relative col-12 lg:col-6 h-full">
                            <h1 class="text-[64px] font-bebasNeue -mt-5">
                                <span class="span dark:text-white">INNOVATION</span>
                                WITH YOURSELF
                            </h1>
                            <p class="font-poppins -translate-y-3">
                                <span class="font-semibold span dark:text-white">Make it real</span>
                                About what's your think
                            </p>
                            <p class="font-merrieweather mt-4">
                                If you have a story to tell, knowledge to share, or a perspective to offer 
                                — welcome home. Sign up for free so your writing can thrive in a network supported by millions of readers — 
                            </p>
                            <a href="{{ route("article.create") }}" class="translate-y-10 py-2 px-4 flex items-center gap-2 w-max rounded-pill bg-primary dark:bg-slate-secondary text-white hover:text-opacity-80 transition duration-200 ease-in-out">
                                <span>
                                    <i data-feather="edit-2" class="w-4 h-4"></i>
                                </span>
                                Start Writing
                            </a>
                        </div>

                    </div>
                </section>

                <section class="py-[90px]" id="about">

                    <div class="container mx-auto my-10">
                        <div class="col-12">
                            <p class="flex items-center justify-center gap-2 text-[32px] font-neucha">
                                <ion-icon name="document-text-outline" class="text-lg span m-0 -translate-y-1"></ion-icon>
                                <b class="tracking-widest"><span class="span">A</span>bout</b>
                            </p>
                        </div>
                    </div>

                    <div class="container px-3 mx-auto flex items-start gap-10">

                        <figure class="hidden lg:block col-12 lg:col-6 h-full">
                            <img src="{{ asset("assets/images/aboutfreemium.svg") }}" class="w-full h-full object-cover" alt="">
                        </figure>

                        <div class="relative col-12 lg:col-6 h-full">
                            <h1 class="font-comic text-[32px] text-center lg:text-left font-bold">
                                <span class="span">What's</span>
                                We Build?
                            </h1>
                            <p class="mt-6">
                                <svg style="width:50px;height:50px" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M11 18V10H9.12L11.12 6H5.38L3 10.76V18M9 16H5V11.24L6.62 8H7.88L5.88 12H9M21 18V10H19.12L21.12 6H15.38L13 10.76V18M19 16H15V11.24L16.62 8H17.88L15.88 12H19Z" />
                                </svg>
                                <span class="block font-poppins italic text-center">We provide services for content creators who have imaginative  thoughts and brilliant content / ideas that can be poured and shared with the general public so that they can benefit. at the same time granting access rights to several sub-articles created by content creators, so that they can get results from the content ideas they create.</span>
                                <svg style="width:50px;height:50px; float: right" class="-translate-y-3" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M13 6V14H14.88L12.88 18H18.62L21 13.24V6M15 8H19V12.76L17.38 16H16.12L18.12 12H15M3 6V14H4.88L2.88 18H8.62L11 13.24V6M5 8H9V12.76L7.38 16H6.12L8.12 12H5Z" />
                                </svg>
                            </p>
                        </div>

                    </div>
                </section>

                <section class="py-[90px]" id="faq">

                    <div class="container px-3 mx-auto my-10">
                        <div class="col-12 flex flex-col items-center justify-center">
                            <p class="flex items-center justify-center gap-2 text-[32px] font-neucha">
                                <ion-icon name="help-outline" class="text-lg span m-0 -translate-y-1"></ion-icon>
                                <b class="tracking-widest"><span class="span">F</span>aq</b>
                            </p>
                            <h2 class="text-gray-secondary mt-2 text-base">Any Question? </h2>
                        </div>
                    </div>
                    
                    <div class="container mx-auto">
                        <ul class="flex flex-col">
                            <li class="bg-white my-2 shadow-lg" x-data="accordion(1)">
                              <h2
                                @click="handleClick()"
                                class="flex flex-row justify-between items-center font-semibold p-3 cursor-pointer"
                              >
                                <span>When will my order arrive?</span>
                                <svg
                                  :class="handleRotate()"
                                  class="fill-current text-purple-700 h-6 w-6 transform transition-transform duration-500"
                                  viewBox="0 0 20 20"
                                >
                                  <path d="M13.962,8.885l-3.736,3.739c-0.086,0.086-0.201,0.13-0.314,0.13S9.686,12.71,9.6,12.624l-3.562-3.56C5.863,8.892,5.863,8.611,6.036,8.438c0.175-0.173,0.454-0.173,0.626,0l3.25,3.247l3.426-3.424c0.173-0.172,0.451-0.172,0.624,0C14.137,8.434,14.137,8.712,13.962,8.885 M18.406,10c0,4.644-3.763,8.406-8.406,8.406S1.594,14.644,1.594,10S5.356,1.594,10,1.594S18.406,5.356,18.406,10 M17.521,10c0-4.148-3.373-7.521-7.521-7.521c-4.148,0-7.521,3.374-7.521,7.521c0,4.147,3.374,7.521,7.521,7.521C14.148,17.521,17.521,14.147,17.521,10"></path>
                                </svg>
                              </h2>
                              <div
                                x-ref="tab"
                                :style="handleToggle()"
                                class="border-l-2 border-primary overflow-hidden max-h-0 duration-500 transition-all"
                              >
                                <p class="p-3 text-gray-900">
                                  Shipping time is set by our delivery partners, according to the delivery method chosen by you. Additional details can be found in the order confirmation
                                </p>
                              </div>
                            </li>
                            <li class="bg-white my-2 shadow-lg" x-data="accordion(2)">
                              <h2
                                @click="handleClick()"
                                class="flex flex-row justify-between items-center font-semibold p-3 cursor-pointer"
                              >
                                <span>How do I track my order?</span>
                                <svg
                                  :class="handleRotate()"
                                  class="fill-current text-purple-700 h-6 w-6 transform transition-transform duration-500"
                                  viewBox="0 0 20 20"
                                >
                                  <path d="M13.962,8.885l-3.736,3.739c-0.086,0.086-0.201,0.13-0.314,0.13S9.686,12.71,9.6,12.624l-3.562-3.56C5.863,8.892,5.863,8.611,6.036,8.438c0.175-0.173,0.454-0.173,0.626,0l3.25,3.247l3.426-3.424c0.173-0.172,0.451-0.172,0.624,0C14.137,8.434,14.137,8.712,13.962,8.885 M18.406,10c0,4.644-3.763,8.406-8.406,8.406S1.594,14.644,1.594,10S5.356,1.594,10,1.594S18.406,5.356,18.406,10 M17.521,10c0-4.148-3.373-7.521-7.521-7.521c-4.148,0-7.521,3.374-7.521,7.521c0,4.147,3.374,7.521,7.521,7.521C14.148,17.521,17.521,14.147,17.521,10"></path>
                                </svg>
                              </h2>
                              <div
                                class="border-l-2 border-primary overflow-hidden max-h-0 duration-500 transition-all"
                                x-ref="tab"
                                :style="handleToggle()"
                              >
                                <p class="p-3 text-gray-900">
                                  Once shipped, you’ll get a confirmation email that includes a tracking number and additional information regarding tracking your order.
                                </p>
                              </div>
                            </li>
                            <li class="bg-white my-2 shadow-lg" x-data="accordion(3)">
                              <h2
                                @click="handleClick()"
                                class="flex flex-row justify-between items-center font-semibold p-3 cursor-pointer"
                              >
                                <span>What’s your return policy?</span>
                                <svg
                                  :class="handleRotate()"
                                  class="fill-current text-purple-700 h-6 w-6 transform transition-transform duration-500"
                                  viewBox="0 0 20 20"
                                >
                                  <path d="M13.962,8.885l-3.736,3.739c-0.086,0.086-0.201,0.13-0.314,0.13S9.686,12.71,9.6,12.624l-3.562-3.56C5.863,8.892,5.863,8.611,6.036,8.438c0.175-0.173,0.454-0.173,0.626,0l3.25,3.247l3.426-3.424c0.173-0.172,0.451-0.172,0.624,0C14.137,8.434,14.137,8.712,13.962,8.885 M18.406,10c0,4.644-3.763,8.406-8.406,8.406S1.594,14.644,1.594,10S5.356,1.594,10,1.594S18.406,5.356,18.406,10 M17.521,10c0-4.148-3.373-7.521-7.521-7.521c-4.148,0-7.521,3.374-7.521,7.521c0,4.147,3.374,7.521,7.521,7.521C14.148,17.521,17.521,14.147,17.521,10"></path>
                                </svg>
                              </h2>
                              <div
                                class="border-l-2 border-primary overflow-hidden max-h-0 duration-500 transition-all"
                                x-ref="tab"
                                :style="handleToggle()"
                              >
                                <p class="p-3 text-gray-900">
                                  We allow the return of all items within 30 days of your original order’s date. If you’re interested in returning your items, send us an email with your order number and we’ll ship a return label.
                                </p>
                              </div>
                            </li>
                            <li class="bg-white my-2 shadow-lg" x-data="accordion(4)">
                              <h2
                                @click="handleClick()"
                                class="flex flex-row justify-between items-center font-semibold p-3 cursor-pointer"
                              >
                                <span>How do I make changes to an existing order?</span>
                                <svg
                                  :class="handleRotate()"
                                  class="fill-current text-purple-700 h-6 w-6 transform transition-transform duration-500"
                                  viewBox="0 0 20 20"
                                >
                                  <path d="M13.962,8.885l-3.736,3.739c-0.086,0.086-0.201,0.13-0.314,0.13S9.686,12.71,9.6,12.624l-3.562-3.56C5.863,8.892,5.863,8.611,6.036,8.438c0.175-0.173,0.454-0.173,0.626,0l3.25,3.247l3.426-3.424c0.173-0.172,0.451-0.172,0.624,0C14.137,8.434,14.137,8.712,13.962,8.885 M18.406,10c0,4.644-3.763,8.406-8.406,8.406S1.594,14.644,1.594,10S5.356,1.594,10,1.594S18.406,5.356,18.406,10 M17.521,10c0-4.148-3.373-7.521-7.521-7.521c-4.148,0-7.521,3.374-7.521,7.521c0,4.147,3.374,7.521,7.521,7.521C14.148,17.521,17.521,14.147,17.521,10"></path>
                                </svg>
                              </h2>
                              <div
                                class="border-l-2 border-primary overflow-hidden max-h-0 duration-500 transition-all"
                                x-ref="tab"
                                :style="handleToggle()"
                              >
                                <p class="p-3 text-gray-900">
                                  Changes to an existing order can be made as long as the order is still in “processing” status. Please contact our team via email and we’ll make sure to apply the needed changes. If your order has already been shipped, we cannot apply any changes to it. If you are unhappy with your order when it arrives, please contact us for any changes you may require.
                                </p>
                              </div>
                            </li>
                            <li class="bg-white my-2 shadow-lg" x-data="accordion(5)">
                              <h2
                                @click="handleClick()"
                                class="flex flex-row justify-between items-center font-semibold p-3 cursor-pointer"
                              >
                                <span>What shipping options do you have?</span>
                                <svg
                                  :class="handleRotate()"
                                  class="fill-current text-purple-700 h-6 w-6 transform transition-transform duration-500"
                                  viewBox="0 0 20 20"
                                >
                                  <path d="M13.962,8.885l-3.736,3.739c-0.086,0.086-0.201,0.13-0.314,0.13S9.686,12.71,9.6,12.624l-3.562-3.56C5.863,8.892,5.863,8.611,6.036,8.438c0.175-0.173,0.454-0.173,0.626,0l3.25,3.247l3.426-3.424c0.173-0.172,0.451-0.172,0.624,0C14.137,8.434,14.137,8.712,13.962,8.885 M18.406,10c0,4.644-3.763,8.406-8.406,8.406S1.594,14.644,1.594,10S5.356,1.594,10,1.594S18.406,5.356,18.406,10 M17.521,10c0-4.148-3.373-7.521-7.521-7.521c-4.148,0-7.521,3.374-7.521,7.521c0,4.147,3.374,7.521,7.521,7.521C14.148,17.521,17.521,14.147,17.521,10"></path>
                                </svg>
                              </h2>
                              <div
                                class="border-l-2 border-primary overflow-hidden max-h-0 duration-500 transition-all"
                                x-ref="tab"
                                :style="handleToggle()"
                              >
                                <p class="p-3 text-gray-900">
                                  For USA domestic orders we offer FedEx and USPS shipping.
                                </p>
                              </div>
                            </li>
                            <li class="bg-white my-2 shadow-lg" x-data="accordion(6)">
                              <h2
                                @click="handleClick()"
                                class="flex flex-row justify-between items-center font-semibold p-3 cursor-pointer"
                              >
                                <span>What payment methods do you accept?</span>
                                <svg
                                  :class="handleRotate()"
                                  class="fill-current text-purple-700 h-6 w-6 transform transition-transform duration-500"
                                  viewBox="0 0 20 20"
                                >
                                  <path d="M13.962,8.885l-3.736,3.739c-0.086,0.086-0.201,0.13-0.314,0.13S9.686,12.71,9.6,12.624l-3.562-3.56C5.863,8.892,5.863,8.611,6.036,8.438c0.175-0.173,0.454-0.173,0.626,0l3.25,3.247l3.426-3.424c0.173-0.172,0.451-0.172,0.624,0C14.137,8.434,14.137,8.712,13.962,8.885 M18.406,10c0,4.644-3.763,8.406-8.406,8.406S1.594,14.644,1.594,10S5.356,1.594,10,1.594S18.406,5.356,18.406,10 M17.521,10c0-4.148-3.373-7.521-7.521-7.521c-4.148,0-7.521,3.374-7.521,7.521c0,4.147,3.374,7.521,7.521,7.521C14.148,17.521,17.521,14.147,17.521,10"></path>
                                </svg>
                              </h2>
                              <div
                                class="border-l-2 border-primary overflow-hidden max-h-0 duration-500 transition-all"
                                x-ref="tab"
                                :style="handleToggle()"
                              >
                                <p class="p-3 text-gray-900">
                                  Any method of payments acceptable by you. For example: We accept MasterCard, Visa, American Express, PayPal, JCB Discover, Gift Cards, etc.
                                </p>
                              </div>
                            </li>
                        </ul>
                    </div>
                </section>

                {{-- <section class="py-[90px]">
                    
                    <div class="container px-3 mx-auto my-10">
                        <div class="col-12 flex flex-col items-center justify-center">
                            <p class="flex items-center justify-center gap-2 text-[32px] font-neucha">
                                <i data-feather="edit" class="span m-0 -translate-y-1"></i>
                                <b class="tracking-widest"><span class="span">P</span>lans</b>
                            </p>
                            <h2 class="text-gray-secondary mt-6 mb-4 text-md">Plans At less 100$/Year</h2>
                            <ul>
                                <li class="flex items-center gap-2">
                                    <i data-feather="check-circle" class="w-6 h-6 span"></i>
                                    <span>Unlimited Content Access</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="container px-3 mx-auto flex items-center justify-center gap-[18px] flex-wrap lg:flex-nowrap">

                        <div class="group hover:bg-primary hover:text-white hover:-translate-y-2 col-12 md:col-6 lg:col-4 px-3 py-4 rounded-lg text-center shadow-[0px_0px_4px_rgba(0,0,0,0.25)] transition duration-200 ease-in-out">
                            <span class="span font-bold text-md font-poppins group-hover:text-white">Annual Subscription</span>
                            <p class="mt-6 mb-10">
                                <span class="span font-semibold group-hover:text-white">100$</span> / 
                                Yearly
                            </p>
                            <button type="button"
                                class="group-hover:bg-white px-6 py-1 border border-primary dark:bg-slate-secondary text-slate-primary hover:text-opacity-80 rounded-pill transition duration-200 ease-in-out"
                            >
                                <span>Select</span>
                                <input type="radio" style="display: none;">
                            </button>
                        </div>
                        
                        <div class="group hover:bg-primary hover:text-white hover:-translate-y-2 col-12 md:col-6 lg:col-4 px-3 py-4 rounded-lg text-center shadow-[0px_0px_4px_rgba(0,0,0,0.25)] transition duration-200 ease-in-out">
                            <span class="span font-bold text-md font-poppins group-hover:text-white">Lifetime Subscription</span>
                            <p class="mt-6 mb-10">
                                <span class="span font-semibold group-hover:text-white">100$</span> / 
                                Yearly
                            </p>
                            <button type="button"
                                class="group-hover:bg-white px-6 py-1 border border-primary dark:bg-slate-secondary text-slate-primary hover:text-opacity-80 rounded-pill transition duration-200 ease-in-out"
                            >
                                <span>Select</span>
                                <input type="radio" style="display: none;">
                            </button>
                        </div>

                    </div>

                </section> --}}

                <section class="pt-[90px] pb-[120px]" id="contact">

                    <div class="container px-3 mx-auto my-10">
                        <div class="col-12 flex flex-col items-center justify-center">
                            <p class="flex items-center justify-center gap-2 text-[32px] font-neucha">
                                <ion-icon name="call-outline" class="text-lg span m-0 -translate-y-1"></ion-icon>
                                <b class="tracking-widest"><span class="span">C</span>ontact Us</b>
                            </p>
                            <h2 class="text-gray-secondary mt-2 mb-4 text-base">Let us know what's your problem by : </h2>
                            <a href="mailto:freemium@example.com" class="my-6 flex items-center justify-center gap-2 px-6 py-2 rounded-pill bg-primary dark:bg-slate-secondary text-white hover:text-opacity-80 transition duration-200 ease-in-out">
                                <i data-feather="mail"></i>
                                Email Us
                            </a>
                        </div>
                    </div>

                    <div class="container mx-auto">



                    </div>
                </section>

            </article>
        </main>

        <!-- FOOTER -->

        @include("layouts.partials.footer")
        
        <script>
            document.addEventListener('alpine:init', () => {
            Alpine.store('accordion', {
                tab: 0
            });
            
            Alpine.data('accordion', (idx) => ({
                init() {
                this.idx = idx;
                },
                idx: -1,
                handleClick() {
                this.$store.accordion.tab = this.$store.accordion.tab === this.idx ? 0 : this.idx;
                },
                handleRotate() {
                return this.$store.accordion.tab === this.idx ? 'rotate-180' : '';
                },
                handleToggle() {
                return this.$store.accordion.tab === this.idx ? `max-height: ${this.$refs.tab.scrollHeight}px` : '';
                }
            }));
            })
        </script>

        <!-- Feather Icons Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
        <script>
            feather.replace()
        </script>

        {{-- Ionicon Scripts --}}

        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        
        <script defer>


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

        @livewireScripts

    </body>
</html>
