@extends("homepage")

{{-- @section("title", "Create Article - Freemium App") --}}

<div x-data="user" x-init="checkSession()">
    <template x-if="isLogedIn && data_user.role == 2">
        <script>
            document.title = 'Create Article - Freemium App';
        </script>
    </template>
</div>

@section("content")
<section class="pt-[140px] pb-[100px]" x-data="user" x-init="checkSession()" style="display: none;">
    <div x-data="admin">
        <div x-init="checkIsAdmin()"></div>
    </div>

    <div
    x-init="
        if(isLogedIn == true) {
            setTimeout(function() {
                return document.querySelector('section').style.display = 'block';
            }, 1000)
        }
    ">

        <style>

            .filename.active {
                bottom: 0;
                transition: .2s ease-in-out;
            }

            .filesize.active {
                right: 12px;
                transition: .2s ease-in-out;
            }

            .removefile.active {
                right: 12px;
                transition: .2s ease-in-out;
            }

            .ck-content {
                height: 500px;
            }

        </style>

        <div class="container mx-auto flex items-center">

            <div class="col col-12" x-data="article">

                <div class="flex flex-wrap lg:flex-nowrap">
                    <div class="mb-5 col-12 lg:col-6">
                        <label for="text" class="text-md">Title</label>
                        <input id="title"  type="text" placeholder="Your text..."
                            class="px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white mt-4">
                    </div>

                    <div class="mb-5 col-12 lg:col lg:col-6" x-data="articles">
                        <div x-init="fetchCategory()"></div>
                        <label for="text" class="text-md">Category</label>
                        <select name="category_id" id="" class="categories px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white mt-4" >
                            <option value=""> Choosen category... </option>
                            <template x-for="category in categories.data">
                                <option x-bind:value="category.id" x-text="category.name">HTML</option>
                            </template>
                        </select>
                    </div>
                </div>

                <div class="mb-5">
                    <label for="text" class="text-md">Thumbnail</label>
                    <input id="thumbnail" type="file" name="thumbnail" placeholder="Your thumbnail..."
                        hidden
                        x-ref="file"
                        @change="
                            if ($refs.file) {
                                $refs.iconimage.style.display = 'none';
                                var reader = new FileReader();
                                reader.readAsDataURL($refs.file.files[0]);
                                reader.onload = function (e) {
                                    $refs.image.src = e.target.result;
                                    $refs.image.alt = $refs.file.name;
                                    $refs.filename.classList.add('active');
                                    $refs.filename.innerText = $refs.file.files[0].name;
                                    $refs.removefile.classList.add('active')
                                }
                            }
                        ">
                    <span
                        class="relative cursor-pointer flex items-center justify-center h-[200px] lg:h-[500px] px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white mt-4 overflow-y-hidden"
                        @click="
                            $refs.file.click();
                        "
                    >
                        <img src=""
                        x-ref="image" class="absolute w-full h-full object-cover rounded-lg" alt="">
                        <i
                            data-feather="image"
                            class="w-[100px] h-[100px] lg:h-[100px] text-gray-secondary"
                            x-ref="iconimage"
                        >
                        </i>
                        {{-- <span class="removefile absolute w-max top-3 -right-full p-2 bg-primary text-white text-center font-semibold rounded-lg hover:text-opacity-80 transition duration-200 ease-in-out" x-ref="removefile"
                        @click="">
                        </span> --}}
                        <p
                            class="filename absolute w-full -bottom-full py-2 bg-primary text-white text-center font-semibold rounded-lg transition duration-200 ease-in-out"
                            x-ref="filename"
                        >
                        </p>
                    </span>
                </div>

                <div class="mb-5 col-12">
                    <label for="text" class="text-md">Content</label><br>
                    <textarea id="content" placeholder="Your content..."
                    class="px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white">
                    </textarea>
                </div>

                <div class="group flex items-center justify-between mt-16 mb-10" x-data="articles">
                    <button type="button" class="flex items-center gap-2" @click="createSubArticle($refs)">
                        <i data-feather="plus-circle" class="w-10 h-10 text-primary"></i>
                        <span class="text-base group-hover:rotate-90 transition duration-200 ease-in-out">Add a sub article</span>
                    </button>
                    <button @click="createArticle()" class="px-4 py-2 bg-primary rounded-lg text-white hover:text-opacity-80 transition duration ease-in-out shadow-[0px_4px_4px_rgba(0,0,0,0.25)]">
                        Save
                    </button>
                </div>

                <div class="w-full my-1">
                    <ul class="flex flex-col" id="listsubarticle" x-ref="listsubarticle">

                        {{-- <li class="bg-white my-2 shadow-lg accordion" x-data="accordion(1)">
                            <h2
                            class="flex flex-row justify-between items-center font-semibold p-3 cursor-pointer"
                            >
                            <span>Sub Artikel 1</span>
                            <div class="flex items-center gap-2">
                                <span class="p-1 rounded-full text-gray-secondary hover:text-opacity-60 shadow-[0px_0px_4px_rgba(0,0,0,0.3)]">
                                    <i data-feather="trash-2" class="text-xs"></i>
                                </span>
                                <svg
                                :class="handleRotate()"
                                @click="handleClick()"
                                class="fill-current text-purple-700 h-6 w-6 transform transition-transform duration-500"
                                viewBox="0 0 20 20"
                                >
                                <path d="M13.962,8.885l-3.736,3.739c-0.086,0.086-0.201,0.13-0.314,0.13S9.686,12.71,9.6,12.624l-3.562-3.56C5.863,8.892,5.863,8.611,6.036,8.438c0.175-0.173,0.454-0.173,0.626,0l3.25,3.247l3.426-3.424c0.173-0.172,0.451-0.172,0.624,0C14.137,8.434,14.137,8.712,13.962,8.885 M18.406,10c0,4.644-3.763,8.406-8.406,8.406S1.594,14.644,1.594,10S5.356,1.594,10,1.594S18.406,5.356,18.406,10 M17.521,10c0-4.148-3.373-7.521-7.521-7.521c-4.148,0-7.521,3.374-7.521,7.521c0,4.147,3.374,7.521,7.521,7.521C14.148,17.521,17.521,14.147,17.521,10"></path>
                                </svg>
                            </div>
                            </h2>
                            <div
                            x-ref="tab"
                            :style="handleToggle()"
                            class="px-4 overflow-hidden max-h-0 duration-500 transition-all"
                            >
                                <div class="flex flex-wrap lg:flex-nowrap">
                                    <div class="mb-5 col-12 lg:col-6">
                                        <label for="text" class="text-md">Title</label>
                                        <input type="text" placeholder="Your text..."
                                            class="px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white mt-4">
                                    </div>

                                    <div class="mb-5 col-12 lg:col lg:col-6">
                                        <label for="text" class="text-md">Category</label>
                                        <select name="category_id" id="" class="px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white mt-4">
                                            <option value=""> Choosen category... </option>
                                            <option value="">HTML</option>
                                            <option value="">CSS</option>
                                            <option value="">Javascript</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-5">
                                    <label for="text" class="text-md">Thumbnail</label>
                                    <input type="file" name="thumbnail" placeholder="Your thumbnail..."
                                        hidden
                                        x-ref="file"
                                        @change="
                                            if ($refs.file) {
                                                $refs.iconimage.style.display = 'none';
                                                var reader = new FileReader();
                                                reader.readAsDataURL($refs.file.files[0]);
                                                reader.onload = function (e) {
                                                    $refs.image.src = e.target.result;
                                                    $refs.image.alt = $refs.file.name;
                                                    $refs.filename.classList.add('active');
                                                    $refs.filename.innerText = $refs.file.files[0].name;
                                                }
                                            }
                                        ">
                                    <span
                                        class="relative cursor-pointer flex items-center justify-center h-[200px] lg:h-[500px] px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white mt-4 overflow-y-hidden"
                                        @click="
                                            $refs.file.click();
                                            console.log($refs.file)
                                        "
                                    >
                                        <img src=""
                                        x-ref="image" class="absolute w-full h-full object-cover rounded-lg" alt="">
                                        <i
                                            data-feather="image"
                                            class="w-[100px] h-[100px] lg:h-[100px] text-gray-secondary"
                                            x-ref="iconimage"
                                        >
                                        </i>
                                        <p
                                            class="filename absolute w-full -bottom-full py-2 bg-primary text-white text-center font-semibold rounded-lg transition duration-200 ease-in-out"
                                            x-ref="filename"
                                        >
                                        </p>
                                    </span>
                                </div>

                                <div class="mb-5 col-12">
                                    <label for="text" class="text-md">Content</label><br>
                                    <textarea id="content" placeholder="Your content..."
                                    class="px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white">
                                    </textarea>
                                </div>

                            </div>
                        </li> --}}

                    </ul>
                </div>

            </div>

        </div>

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

            Alpine.data('article', () => ({
                index: 1,
                apiUrl: "http://127.0.0.1:8001/api/",
                createSubArticle(refs) {

                    refs.listsubarticle.insertAdjacentHTML('beforeend' ,`
                        <li class="bg-white rounded-lg my-2 shadow-lg accordion" id="${`accordion`+ this.index}" x-data="accordion(${this.index})">
                            <h2
                            class="flex flex-row justify-between items-center font-semibold p-3 cursor-pointer"
                            >
                            <span>Sub Artikel ${this.index}</span>
                            <div class="flex items-center gap-2">
                                <span class="p-1 rounded-full text-gray-secondary hover:text-opacity-60 shadow-[0px_0px_4px_rgba(0,0,0,0.3)]" @click="deleteSubArticle(${this.index})">
                                    <img src="{{ asset('assets/images/icons/trash-2.svg') }}" />
                                </span>
                                <svg
                                :class="handleRotate()"
                                @click="handleClick()"
                                class="fill-current text-purple-700 h-6 w-6 transform transition-transform duration-500"
                                viewBox="0 0 20 20"
                                >
                                <path d="M13.962,8.885l-3.736,3.739c-0.086,0.086-0.201,0.13-0.314,0.13S9.686,12.71,9.6,12.624l-3.562-3.56C5.863,8.892,5.863,8.611,6.036,8.438c0.175-0.173,0.454-0.173,0.626,0l3.25,3.247l3.426-3.424c0.173-0.172,0.451-0.172,0.624,0C14.137,8.434,14.137,8.712,13.962,8.885 M18.406,10c0,4.644-3.763,8.406-8.406,8.406S1.594,14.644,1.594,10S5.356,1.594,10,1.594S18.406,5.356,18.406,10 M17.521,10c0-4.148-3.373-7.521-7.521-7.521c-4.148,0-7.521,3.374-7.521,7.521c0,4.147,3.374,7.521,7.521,7.521C14.148,17.521,17.521,14.147,17.521,10"></path>
                                </svg>
                            </div>
                            </h2>
                            <div
                            x-ref="tab"
                            :style="handleToggle()"
                            class="px-4 overflow-y-scroll overflow-x-hidden max-h-0 duration-500 transition-all"
                            >
                                <div class="flex flex-wrap lg:flex-nowrap">
                                    <div class="mb-5 col-12 lg:col-12">
                                        <label for="text" class="text-md">Title</label>
                                        <input type="text" placeholder="Your text..."
                                            class="title_sub px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white mt-4">
                                    </div>

                                </div>

                                <div class="mb-5">
                                    <label for="text" class="text-md">Thumbnail</label>
                                    <input class="thumbnail_sub" type="file" name="thumbnail" placeholder="Your thumbnail..."
                                        hidden
                                        x-ref="file${this.index}"
                                        @change="
                                            if ($refs.file) {
                                                $refs.iconimage${this.index}.style.display = 'none';
                                                var reader = new FileReader();
                                                reader.readAsDataURL($refs.file${this.index}.files[0]);
                                                reader.onload = function (e) {
                                                    $refs.image${this.index}.src = e.target.result;
                                                    $refs.image${this.index}.alt = $refs.file${this.index}.name;
                                                    $refs.filename${this.index}.classList.add('active');
                                                    $refs.filename${this.index}.innerText = $refs.file${this.index}.files[0].name;
                                                }
                                            }
                                        ">
                                    <span
                                        class="relative cursor-pointer flex items-center justify-center h-[200px] lg:h-[500px] px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white mt-4 overflow-y-hidden"
                                        @click="
                                            $refs.file${this.index}.click();
                                        "
                                    >
                                        <img src=""
                                        x-ref="image${this.index}" class="absolute w-full h-full object-cover rounded-lg" alt="">
                                        <img
                                            src="{{ asset('assets/images/icons/image.svg') }}"
                                            class="w-[100px] h-[100px] lg:h-[100px] text-gray-secondary"
                                            x-ref="iconimage${this.index}"
                                        />
                                        <p
                                            class="filename absolute w-full -bottom-full py-2 bg-primary text-white text-center font-semibold rounded-lg transition duration-200 ease-in-out"
                                            x-ref="filename${this.index}"
                                        >
                                        </p>
                                    </span>
                                </div>

                                <div class="mb-5 col-12" id="content${this.index}" class="content${this.index}">
                                    <label for="text" class="text-md">Content</label><br>
                                    <textarea id="editor${this.index}" placeholder="Your content..."
                                    class="description_sub px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white">
                                    </textarea>
                                </div>

                                <div class="mb-5 col-12">
                                    <span class="text-md">Choose Your Plan</span>
                                    <div class="flex items-center gap-2 mt-2">
                                        <label for="free" class="flex items-center gap-1">
                                            <input class="type" type="radio" name="status${this.index}" value="free" id="free" checked>
                                            <span class="text-base">Free</span>
                                        </label>
                                        <label for="paid" class="flex items-center gap-1">
                                            <input class="type" type="radio" name="status${this.index}" value="paid" id="paid">
                                            <span class="text-base">Member-Only</span>
                                        </label>
                                    </div>
                                    <p class="mt-4">*Get Royalty for Author</p>
                                </div>

                            </div>
                        </li>
                    `);

                    ClassicEditor
                    .create( document.querySelector( `#editor${this.index}` ) )
                    .then( editor => {
                        editor.config.toolbar = [{ name: 'tools', items: ['Maximize', 'ShowBlocks', '-', 'About'] }]
                    } )
                    .catch( error => {
                        console.error( error );
                    } );

                    this.index++;


                },
                deleteSubArticle(id)
                {
                    let parentElement = document.getElementById('listsubarticle');
                    parentElement.querySelector(`#accordion${id}`).remove();
                }
            }))

        })
        </script>

    </div>

</section>



@endsection
