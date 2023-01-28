<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield("title", "Freemium App")</title>

        {{-- Custome CSS Link --}}

        {{-- <link rel="stylesheet" href="{{ asset("assets/css/style.css") }}"> --}}

        <!-- Ionicons -->

        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

        {{-- Bootstrap Icons --}}
        
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

        {{-- ChartJS --}}

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        {{-- AOS Animation CSS --}}
        
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

        {{-- AlpineJS Link --}}

        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="{{ asset('assets/js/auth.js') }}"></script>
        <script src="{{ asset('assets/js/user.js') }}"></script>

        {{-- Highlight Code CSS --}}
        
        {{-- <link rel="stylesheet" href="{{ asset("assets/libs/highlight/styles/atom-one-dark.min.css") }}"> --}}
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/styles/default.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/highlight.min.js"></script> --}}

        {{-- Prism Code CSS --}}
        
        <link rel="stylesheet" href="{{ asset("assets/css/prism/prism.css") }}">

        {{-- Bootstrap Icons --}}
        
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

        {{-- SweetAlert --}}
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        {{-- Custom Style --}}

        <style>
            .tox-notifications-container {
                display: none;
            }
            
            .tox-statusbar__branding {
                display: none;
            }

            .tox-tinymce {
                /* height: 500px !important; */
            }

        </style>

        <!-- Vite Link CSS -->

        @vite('resources/css/app.css')

        @livewireStyles

    </head>
    <body class="antialiased overflow-x-hidden has-scrollbar bg-white dark:bg-slate-primary">
        
        {{-- <x-loading-page /> --}}


        <!-- HEADER -->

        @include("layouts.partials.header")

        <main>
            <article>


                @yield('content')


            </article>
        </main>

        <!-- FOOTER -->

        <div x-data="user">
            <div x-data="articles">
                <template x-if="!isLoading">
                    @include("layouts.partials.footer")
                </template>
            </div>
        </div>

        <!-- Feather Icons Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
        <script>
            feather.replace()
        </script>

        {{-- Ionicon Scripts --}}

        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

        {{-- AOS Animation Scripts --}}
        
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        
        <script>
            AOS.init();
            window.onload = function(){
                localStorage.removeItem("showFlash");
                localStorage.removeItem("message");
            }
        </script>

        {{-- TinyMCE Scripts --}}

        <script src="https://cdn.tiny.cloud/1/u2nxm9ys2v0iwr5re916e7g6e8yjcnyzb81g34b18pmx0kk2/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

        {{-- TinyMCE Tools --}}

        <script type="text/javascript">
            addTinyMCE();

            function addTinyMCE(){
                // Initialize
                tinymce.init({
                    selector: '#content',
                    plugins: 'anchor autolink code codesample formatselect charmap preview fullscreen emoticons image link lists media searchreplace table wordcount',
                    height: '842px',
                    force_br_newlines : true,
                    force_p_newlines : false,
                    forced_root_block : false,
                    cleanup : true,
                });
                tinymce.init({
                    selector: '#sub_content',
                    plugins: 'anchor autolink code codesample formatselect charmap preview fullscreen emoticons image link lists media searchreplace table wordcount',
                    height: '842px',
                    force_br_newlines : true,
                    force_p_newlines : false,
                    forced_root_block : false,
                    cleanup : true
                });
            }

        </script>
        
        <script defer>


            window.addEventListener("DOMContentLoaded", function() {
                
                if (localStorage.theme === 'light') {
                    document.documentElement.classList.add('light')
                    document.documentElement.classList.remove('dark')
                    localStorage.theme = 'light'
                    document.getElementById("buttonMode").setAttribute("title", "Dark Mode")
                    document.getElementById("iconMode").setAttribute("src", "http://localhost:8000/" + "assets/images/icons/moon.svg")
                } else if(localStorage.theme === 'dark') {
                    document.documentElement.classList.add('dark')
                    document.documentElement.classList.remove('light')
                    localStorage.theme = 'dark'
                    document.getElementById("buttonMode").setAttribute("title", "Light Mode")
                    document.getElementById("iconMode").setAttribute("src", "http://localhost:8000/" + "assets/images/icons/sun.svg")
                }

            });
            
            // console.error = function() {}
            // console.warn = function() {}

            
        </script>


        @livewireScripts

        <script src="{{ asset("assets/js/prism.js") }}"></script>

    </body>
</html>
