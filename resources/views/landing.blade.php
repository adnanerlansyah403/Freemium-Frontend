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
                
            </article>
        </main>

        <!-- FOOTER -->

        @include("layouts.partials.footer")

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