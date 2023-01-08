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

        {{-- AlpineJS Link --}}

        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

        {{-- TinyMCE Scripts --}}

        <script src="https://cdn.tiny.cloud/1/u2nxm9ys2v0iwr5re916e7g6e8yjcnyzb81g34b18pmx0kk2/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

        {{-- Custom Style --}}
                
        <style>
            .tox-statusbar__branding {
                display: none;
            }

            .tox-tinymce {
                height: 500px !important;
            }
        
        </style>

    </head>
    <body class="antialiased" x-data="">
    

        <!-- HEADER -->

        @include("layouts.partials.header")

        <main>
            <article>


                @yield('content')


            </article>
        </main>

        <!-- FOOTER -->
        
        @include("layouts.partials.footer")

        <!-- Feather Icons Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
        <script>
        feather.replace()
        </script>

        {{-- TinyMCE Tools --}}
        
        <script type="text/javascript">
            tinymce.init({
            selector: 'textarea',
            plugins: 'anchor autolink code codesample formatselect charmap preview fullscreen emoticons image link lists media searchreplace table wordcount',
            });
        </script>

    </body>
</html>
