@extends("homepage")

{{-- @section("title", "Create Article - Freemium App") --}}

@section("content")

<section class="py-[100px]" x-data="user" x-init="checkSession()" style="display: none;">
    <div x-init="fetchMe()"></div>
    <div x-data="admin">
        <div x-init="checkIsAdmin()"></div>
    </div>
    <template x-if="isLogedIn && data_user.role == 2">
        <script>
            document.title = 'Create Article - Freemium App';
        </script>
    </template>
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
            
            input[type="radio"] {
                margin-left: 1px;
                margin-top: 1px;
            }
        
        </style>
        
        <div class="container mx-auto flex items-center dark:text-white">

            <div class="col col-12" x-data="article">

                <div class="flex flex-wrap lg:flex-nowrap">
                    <div class="mb-5 col-12 lg:col-6">
                        <label for="text" class="text-md">Title</label>
                        <input id="title"  type="text" placeholder="Your text..."
                            class="px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white dark:bg-slate-secondary mt-4">
                            <template x-if="status_err.title">
                                <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                    <span class="span-danger" x-text="status_err.title[0]">Validasi Error</span>
                                </div>
                            </template>
                    </div>
        
                    <div class="mb-5 col-12 lg:col lg:col-6" x-data="articles">
                        <div x-init="getCategories()"></div>
                        <label for="text" class="text-md">Category</label>
                        <select name="category_id" id="" class="categories px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white  dark:bg-slate-secondary mt-4" >
                            <option>--Choosen Category--</option>
                            <template x-for="category in categoriesArticle">
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
                        class="relative cursor-pointer flex items-center justify-center h-[200px] lg:h-[500px] px-2 py-4 w-full rounded-primary bg-white border border-primary dark:bg-slate-secondary dark:border-white mt-4 overflow-y-hidden"
                        @click="
                            $refs.file.click();
                        "
                    >
                        <img src="" 
                        x-ref="image" class="absolute w-full h-full rounded-lg" alt="">
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
                    <template x-if="status_err.thumbnail">
                        <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <span class="span-danger" x-text="status_err.thumbnail[0]">Validasi Error</span>
                        </div>
                    </template>
                </div>

                <div class="mb-5 col-12">
                    <label for="text" class="text-md">Content</label><br>
                    <template x-if="status_err.description">
                        <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <span class="span-danger" x-text="status_err.description[0]">Validasi Error</span>
                        </div>
                    </template>
                    <textarea id="content" placeholder="Your content..."
                    class="px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white dark:bg-slate-secondary">
                    </textarea>
                </div>

                <div class="flex items-center justify-between mt-16 mb-10" x-data="articles">
                    <button type="button" class="group flex items-center gap-2" @click="createSubArticle($refs)">
                        <i data-feather="plus-circle" class="w-10 h-10 text-primary dark:text-slate-third group-hover:rotate-90 transition duration-200 ease-in-out"></i> 
                        <span class="text-base">Add a sub article</span>
                    </button>
                    <template x-if="isLoadingArticle">
                        <span class="span text-md dark:text-slate-third">wait...</span>
                    </template>
                    <template x-if="!isLoadingArticle">
                        <button @click="createArticle()" class="px-4 py-2 bg-primary dark:bg-slate-secondary rounded-lg text-white hover:text-opacity-80 transition duration ease-in-out shadow-[0px_4px_4px_rgba(0,0,0,0.25)]">
                            Save
                        </button>
                    </template>
                </div>

                <template x-if="status_err.min_free">
                    <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                        <span class="span-danger" x-text="status_err.min_free[0]">Validasi Error</span>
                    </div>
                </template>

                <div class="w-full my-1">
                    <ul class="flex flex-col" id="listsubarticle" x-ref="listsubarticle">
                        

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
                        <li class="bg-white dark:bg-slate-secondary rounded-lg my-2 shadow-[0px_0px_4px_rgba(0,0,0,0.25)] accordion" id="${`accordion`+ this.index}" x-data="accordion(${this.index})">
                            <h2
                            class="flex flex-row justify-between items-center font-semibold px-3 py-2 cursor-pointer"
                            >
                            <span>Sub Artikel ${this.index}</span>
                            <div class="flex items-center gap-2">
                                <span class="p-1 rounded-full text-gray-secondary hover:text-opacity-60" @click="deleteSubArticle(${this.index})">
                                    <ion-icon name="trash-outline" class="w-6 h-6 text-primary dark:text-white dark:hover:text-opacity:75"></ion-icon>
                                </span>
                                <span
                                :class="handleRotate()"
                                @click="handleClick()"
                                class="-mt-1 h-6 w-6 transform transiton-transform duration-200 ease-in-out"
                                >
                                    <ion-icon name="chevron-down-circle-outline" class="w-full h-full text-primary dark:text-white dark:hover:text-opacity:75"></ion-icon>
                                </span>
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
                                            class="title_sub dark:text-white px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white dark:bg-slate-primary border border-white hover:bg-white mt-4">
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
                                        class="relative cursor-pointer flex items-center justify-center h-[200px] lg:h-[500px] px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white border border-primary dark:bg-slate-primary dark:border-white mt-4 overflow-y-hidden"
                                        @click="
                                            $refs.file${this.index}.click();
                                        "
                                    >
                                        <img src="" 
                                        x-ref="image${this.index}" class="absolute w-full h-full rounded-lg" alt="">
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
                                            <input class="type checked:bg-primary dark:checked:bg-slate-third" type="radio" name="status${this.index}" value="free" id="free" checked>
                                            <span class="text-base">Free</span>
                                        </label>
                                        <label for="paid" class="flex items-center gap-1">
                                            <input class="type checked:bg-primary dark:checked:bg-slate-third" type="radio" name="status${this.index}" value="paid" id="paid">
                                            <span class="text-base">Member-Only</span>
                                        </label>
                                    </div>
                                    <p class="mt-4">*Get Royalty for Author</p>
                                </div>
        
                            </div>
                        </li>
                    `);

                    // ClassicEditor
                    // .create( document.querySelector( `#editor${this.index}` ) )
                    // .then( editor => {
                    //     editor.config.toolbar = [{ name: 'tools', items: ['Maximize', 'ShowBlocks', '-', 'About'] }]
                    // } )
                    // .catch( error => {
                    //     console.error( error );
                    // } );

                    tinymce.init({
                        selector: `#editor${this.index}`,
                        plugins: 'anchor autolink code codesample formatselect charmap preview fullscreen emoticons image link lists media searchreplace table wordcount',
                    });
                    
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