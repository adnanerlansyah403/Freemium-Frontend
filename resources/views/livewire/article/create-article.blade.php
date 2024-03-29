@extends("homepage")

{{-- @section("title", "Create Article - Freemium App") --}}

@section("content")

<section class="pt-[140px] pb-[100px]" x-data="user" x-init="checkSession()" >
    <div x-init="fetchMe()"></div>
    <div x-init="checkRoleUser()"></div>
    <template x-if="isLogedIn && data_user.role == 2">
        <script>
            document.title = 'Create Article - Freemium App';
        </script>
    </template>

    <div style="display: none;" x-ref="wrapperCreateArticle"
    x-init="setTimeout(function() {
        $refs.wrapperCreateArticle.style.display = 'block';
    }, 400)">

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
                /* height: 500px; */
            }

            input[type="radio"] {
                margin-left: 1px;
                margin-top: 1px;
            }

            .tox .tox-editor-header {
                z-index: 0;
            }

        </style>
        <div class="container mx-auto flex items-center dark:text-white" x-data="articles">
            <div class="col col-12">
                <template x-if="!isLoading">
                    <div class="flex flex-wrap lg:flex-nowrap">
                        <div class="mb-5 col-12 lg:col-6">
                            <label for="text" class="text-md">Title</label>
                            <input id="title"  type="text" placeholder="Your text..."
                                class="px-3 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] dark:shadow-none border border-none dark:border-white rounded-primary bg-white dark:bg-slate-secondary mt-4">
                            <div id="err_title"></div>
                        </div>

                        <div class="mb-5 col-12 lg:col lg:col-6" x-data="articles">
                            <div x-init="getCategories()"></div>
                            <label for="text" class="text-md">Category</label>
                            <select multiple name="category_id[]" id="category_id" class="categories has-scrollbar px-3 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] dark:shadow-none dark:border dark:border-white rounded-primary bg-white  dark:bg-slate-secondary mt-4" >
                                <option value=""> Choosen category... </option>
                                <template x-for="category in categoriesArticle">
                                    <option x-bind:value="category.id" x-text="category.name">HTML</option>
                                </template>
                            </select>
                            <template x-if="category_err.category">
                                <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                    <span class="span-danger" x-text="category_err.category[0]">Validasi Error</span>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>

                <div class="mb-6">
                    <label for="text" class="text-md">Thumbnail</label>
                    <input accept="image/*" id="thumbnail" type="file" name="thumbnail" placeholder="Your thumbnail..."
                        hidden
                        x-ref="file"
                        @change="
                            if ($refs.file) {
                                $refs.iconimage.style.display = 'none';
                                var reader = new FileReader();
                                reader.readAsDataURL($refs.file.files[0]);
                                reader.onload = function (e) {
                                    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
                                    if(!allowedExtensions.exec($refs.file.files[0].name)){
                                        $refs.iconimageerror.style.display = 'block';
                                        $refs.image.src = '';
                                        $refs.image.alt = '';
                                        $refs.filename.classList.remove('active');
                                        $refs.filename.innerText = '';
                                        $refs.removefile.classList.remove('active')
                                    }else{
                                        $refs.image.src = e.target.result;
                                        $refs.image.alt = $refs.file.name;
                                        $refs.filename.classList.add('active');
                                        $refs.filename.innerText = $refs.file.files[0].name;
                                        $refs.removefile.classList.add('active')
                                    }
                                }
                            }
                        ">
                    <span
                        class="relative cursor-pointer flex items-center justify-center h-[300px] md:h-[400px] lg:h-[500px] px-2 py-4 w-full rounded-primary bg-white border border-primary dark:bg-slate-secondary dark:border-white mt-4 overflow-y-hidden"
                        @click="
                            $refs.file.click();
                        "
                    >
                        <img src=""
                        x-ref="image" class="absolute w-full h-full object-cover rounded-lg" alt="" onerror="this.style.opacity = 0" onload="this.style.opacity = 1">
                        <div class="text-center"
                        x-ref="iconimage">
                            <i
                            data-feather="image"
                            class="w-[100px] h-[100px] lg:h-[100px] mx-auto text-primary dark:text-white"
                            >
                            </i>
                            <span class="block mt-4">
                                <b class="span dark:text-white">Click to Upload</b> <br> <p class="text-sm font-semibold">(SVG, PNG, JPG, JPEG)</p>
                            </span>
                        </div>
                        <div class="text-center"
                        x-ref="iconimageerror" style="display: none;">
                            <i
                            data-feather="alert-circle"
                            class="w-[100px] h-[100px] lg:h-[100px] mx-auto text-primary dark:text-white"
                            >
                            </i>
                            <span class="block mt-4">
                                <b class="span dark:text-white">Oops!</b> You cannot input anything other than images. <br>
                                <b>Please Click Again</b>
                            </span>
                        </div>
                        <p
                            class="filename absolute w-full -bottom-full py-2 bg-primary text-white text-center font-semibold rounded-lg transition duration-200 ease-in-out"
                            x-ref="filename"
                        >
                        </p>
                    </span>
                    <div id="err_thumb">

                    </div>
                </div>

                <div class="mb-5 col-12">
                    <div class="flex justify-between items-center mb-2">
                        <label for="text" class="text-md">Content</label><br>
                        <p><strong>Shift + Enter</strong> to Pressing enter once</p>
                    </div>

                    <textarea id="content" placeholder="Your content..."
                    class="px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] dark:shadow-none dark:border dark:border-white rounded-primary bg-white dark:bg-slate-secondary">
                    </textarea>
                    <div id="err_description"></div>
                </div>

                {{-- when it be clicked it will add some element accordion in wrap sub article --}}
                <div class="flex items-center justify-between mt-16 mb-10">
                    <button type="button" class="group flex items-center gap-2" @click="createSubArticle($refs), $refs.hiddensave.remove(), buttonshow = true " >
                        <i data-feather="plus-circle" class="w-10 h-10 text-primary dark:text-slate-third group-hover:rotate-90 transition duration-200 ease-in-out"></i>
                        <span class="text-base">Add a sub article</span>
                    </button>
                    <div x-ref="hiddensave">

                        <template x-if="isLoadingArticle">
                            <span class="span text-md dark:text-slate-third">wait...</span>
                        </template>
                        <template x-if="!isLoadingArticle">
                            <button @click="createArticle()" class="px-4 py-2 bg-primary dark:bg-slate-secondary rounded-lg text-white hover:text-opacity-80 transition duration ease-in-out shadow-[0px_4px_4px_rgba(0,0,0,0.25)]">
                                Save
                            </button>
                        </template>
                    </div>
                </div>

                <template x-if="status_err.min_free">
                    <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                        <span class="span-danger" x-text="status_err.min_free[0]">Validasi Error</span>
                    </div>
                </template>

                <div class="w-full my-1">

                    <p class="font-semibold text-sm lg:text-base mb-2 bg-primary dark:bg-slate-secondary bg-opacity-20 p-3 rounded-lg">
                        *If you make three paid sub contents, then you must have to create 3 free content first.
                    </p>

                    {{-- wrap for accordion sub article --}} 
                    {{-- it will render sub article form --}}
                    <ul class="flex flex-col" id="listsubarticle" x-ref="listsubarticle">


                    </ul>
                </div>

                <div x-data="articles">
                        {{-- <div x-show="status_sub_err">
                            <div x-html="sub_article_err"></div>
                        </div> --}}
                        <div x-show="buttonshow" class="flex justify-end mt-5">

                            <template x-if="isLoadingArticle">
                                <span class="span text-md dark:text-slate-third">wait...</span>
                            </template>
                            <template x-if="!isLoadingArticle">
                                <button @click="createArticle()" class="px-4 py-2 bg-primary dark:bg-slate-secondary rounded-lg text-white hover:text-opacity-80 transition duration ease-in-out shadow-[0px_4px_4px_rgba(0,0,0,0.25)]">
                                    Save
                                </button>
                            </template>
                        </div>
                </div>

            </div>
        </div>

        {{-- INSTRUCTIONS --}}

        <x-modal-instruction>
            <ul>
                <li class="mb-4">
                    <b class="text-primary dark:text-white border border-primary dark:border-white py-1 px-2">Validation</b>
                </li>
                <li class="flex items-start gap-2">
                    <b class="text-primary dark:text-white">1.</b>
                    <span>The title must longer than 10 character</span>
                </li>
                <li class="flex items-start gap-2">
                    <b class="text-primary dark:text-white">2.</b>
                    <span>The article must have at least 1 category</span>
                </li>
                <li class="flex items-start gap-2">
                    <b class="text-primary dark:text-white">3.</b>
                    <span>The article must have a thumbnail</span>
                </li>
                <li class="flex items-start gap-2">
                    <b class="text-primary dark:text-white">4.</b>
                    <span>The thumbnail must be an image with size less than 1 MB</span>
                </li>
                <li class="flex items-start gap-2">
                    <b class="text-primary dark:text-white">5.</b>
                    <span>If there are more than 3 sub-articles. At least 3 of them must be free</span>
                </li>
            </ul>
            <ul class="mt-4">
                <li class="mb-4">
                    <b class="text-primary dark:text-white border border-primary dark:border-white py-1 px-2">Write a Content</b>
                </li>
                <li class="flex items-start gap-2">
                    <b class="text-primary dark:text-white">1.</b>
                    <span>The content length must be more than 100 character</span>
                </li>
                <li class="flex items-start gap-2">
                    <b class="text-primary dark:text-white">2.</b>
                    <span>All media in the content article should be sourced online</span>
                </li>
                <li class="flex items-start gap-2">
                    <b class="text-primary dark:text-white">3.</b>
                    <span>Shift + Enter to Pressing enter once</span>
                </li>
            </ul>
        </x-modal-instruction>

        <x-top-button />

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
                    let tab = document.getElementById(`tab${this.idx}`);
                    if(tab.classList.contains('max-h-[1305px]')) {
                        tab.classList.remove("max-h-[1305px]");
                        tab.classList.add("max-h-0");
                    }else{
                        this.$store.accordion.tab = this.$store.accordion.tab === this.idx ? 0 : this.idx;
                    }
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
    </div>

    <template x-if="isLoading">
        <div class="flex items-start justify-center px-32 py-4">
            <x-loading-page />
        </div>
    </template>

</section>



@endsection
