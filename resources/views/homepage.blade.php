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

        {{-- Highlight Code CSS --}}
        
        {{-- <link rel="stylesheet" href="{{ asset("assets/libs/highlight/styles/atom-one-dark.min.css") }}"> --}}
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/styles/default.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/highlight.min.js"></script> --}}

        {{-- Prism Code CSS --}}
        
        <link rel="stylesheet" href="{{ asset("assets/css/prism/prism.css") }}">

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
            
            /* pre {
            margin: 0;
            padding: 16px;
            background-color: #2e2f30;
            border-radius: 3px;
            } */

        </style>

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

        {{-- Ckeditor5 Scripts --}}

        <script src="https://cdn.ckeditor.com/ckeditor5/22.0.0/classic/ckeditor.js"></script>

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
            
            // console.error = function() {}
            // console.warn = function() {}

            
        </script>


        @livewireScripts

        <script src="{{ asset("assets/js/prism.js") }}"></script>

    </body>
</html>
