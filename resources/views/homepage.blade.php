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

        {{-- AlpineJS Link --}}

        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="./assets/js/auth.js"></script>
        <script src="./assets/js/user.js"></script>
        {{-- Custom Style --}}
                
        <style>
            .tox-statusbar__branding {
                display: none;
            }

            .tox-tinymce {
                height: 500px !important;
            }
        
        </style>
        
        @livewireStyles

    </head>
    <body class="antialiased" x-data="">

        {{-- <x-alert /> --}}
    

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
                });
            }
        </script>

        @livewireScripts

    </body>
</html>
