{{-- @section("title", "Edit Article - Freemium App") --}}

<section class="pt-[60px] pb-[100px]" x-data="user" x-init="checkSession()">
    <div x-init="fetchMe()"></div>
    <div x-data="admin">
        <div x-init="checkIsAdmin()"></div>
    </div>
    <template x-if="isLogedIn && data_user.role == 2">
        <script>
            document.title = 'Edit Article - Freemium App';
        </script>
    </template>
    <div
    x-init="
        if(isLogedIn == true) {
            fetchEditArticle(window.location.href.split('/').pop())
        }
    ">

        <template x-if="isLoading">
            <div class="flex justify-center px-32 py-4">
                <x-loading-page />
            </div>
        </template>
        <template x-if="!isLoading">
            <div x-data="helpers" class="container mx-auto flex items-center dark:text-white">
    
                <form action="" class="col col-12">
                    <p class="flex items-center gap-2 mb-4" x-show="!isLoading">
                        <b>Created At : </b>
                        <span x-text="convertDate(EditArticle?.created_at)" class="px-2 py-1 rounded-lg bg-primary text-white dark:bg-slate-third"></span>
                    </p>
    
                    <div class="flex flex-wrap lg:flex-nowrap">
                        <div class="mb-5 col-12 lg:col-6">
                            <div class="flex justify-between">
                                <label for="title" class="text-md">Title</label>
                            </div>
                            <input x-model="EditArticle.title" type="text" placeholder="Your text..." name="title" id="title"
                                class="px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white dark:bg-slate-secondary mt-4">
                                
                            <template x-if="status_err?.[0]?.title">
                                <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                    <span class="span-danger" x-text="status_err?.[0]?.title[0]">Validasi Error</span>
                                </div>
                            </template>
                        </div>
    
                        <div class="mb-5 col-12 lg:col lg:col-6">
                            <label for="category_id" class="text-md">Category</label>
                            <select x-model="EditArticle.tags[0].category_id" name="category_id" id="category_id"
                                class="px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white dark:bg-slate-secondary mt-4">
                                <option value="">--Choosen Category--</option>
                                <template x-for="(c, index) in categories">
                                    <option :value="c.id" :selected="c.id == EditArticle?.tags?.[0]?.category_id" x-text="c.name">test</option>
                                </template>
                            </select>
    
                            <template x-if="status_err?.[0]?.category_id">
                                <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                    <span class="span-danger" x-text="status_err?.[0]?.category_id[0]">Validasi Error</span>
                                </div>
                            </template>
                        </div>
                    </div>
    
                    <div class="mb-5">
                        <label for="thumbnail" class="text-md">Thumbnail</label>
                        <input x-on:change="EditArticle.thumbnail = Object.values($event.target.files)" type="file" name="thumbnail" id="thumbnail" placeholder="Your thumbnail..." hidden
                            x-ref="file" @change="
                                if ($refs.file) {
                                    $refs.iconimage.style.display = 'none';
                                    var reader = new FileReader();
                                    reader.readAsDataURL($refs.file.files[0]);
                                    reader.onload = function (e) {
                                        EditArticle.thumbnail_1 = e.target.result;
                                        EditArticle.thumbnail_1_alt = $refs.file.files[0].name;
                                    }
                                }
                            ">
                        <span
                            class="relative cursor-pointer flex items-center justify-center h-[200px] lg:h-[500px] px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white dark:bg-slate-secondary mt-4 overflow-y-hidden"
                            @click="
                                $refs.file.click();
                            ">
                            <img x-bind:src="!EditArticle?.thumbnail_1 ? 'http://localhost:8001/' + EditArticle?.thumbnail : EditArticle?.thumbnail_1" class="absolute w-full h-full rounded-lg" x-bind:alt="EditArticle?.thumbnail_1_alt"  onerror="this.style.opacity = 0" onload="this.style.opacity = 1">
                            <i data-feather="image" class="w-[100px] h-[100px] lg:h-[100px] text-gray-secondary"
                                x-ref="iconimage">
                            </i>
                            <p x-show="EditArticle?.thumbnail_1_alt" x-text="EditArticle?.thumbnail_1_alt" class="filename absolute w-full bottom-0 py-2 bg-primary text-white text-center font-semibold rounded-lg transition duration-200 ease-in-out active"></p>
                        </span>
    
                        <template x-if="status_err?.[0]?.thumbnail">
                            <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                <span class="span-danger" x-text="status_err?.[0]?.thumbnail[0]">Validasi Error</span>
                            </div>
                        </template>
                    </div>
    
                    <div class="mb-5 col-12">
                        <label for="content" class="text-md">Content</label><br>
                        <textarea 
                        x-text="EditArticle?.description" name="description" id="content" placeholder="Your content..."
                            class="px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white">
                        </textarea>
                        <template x-if="setTiny?.('content', EditArticle?.description);"></template>
    
                        <template x-if="status_err?.[0]?.description">
                            <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                <span class="span-danger" x-text="status_err?.[0]?.description[0]">Validasi Error</span>
                            </div>
                        </template>
                    </div>
    
                    <div class="flex items-center justify-center my-10">
                        <p x-show="isLoading" class="text-green-500">Loading...</p>
                        <button @click.prevent="updateArticle()"
                            class="px-4 py-2 bg-primary dark:bg-slate-secondary rounded-lg text-white hover:text-opacity-80 transition duration ease-in-out shadow-[0px_4px_4px_rgba(0,0,0,0.25)]">
                            Save
                        </button>
                    </div>
    
                </form>
    
            </div>
    
            <div class="container mx-auto mt-4" x-data="{editSub: 0,}">
    
    
                <form class="w-full my-1 px-5 lg:px-0 dark:text-white">
    
                    <p class="font-semibold text-base mb-2">
                        *If you make three paid sub contents, then you must have to create 3 free content first.
                    </p>
                    
                    <ul class="flex flex-col mb-10">
    
                        <li class="bg-white dark:bg-slate-secondary dark:text-white my-2 shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-lg" x-data="accordion(1)">
                            <h2 @click="handleClick()"
                                class="flex flex-row justify-between items-center font-semibold p-3 cursor-pointer">
                                <span>Daftar List Sub Artikel</span>
                                <div class="flex items-center gap-2">
                                    <span
                                    :class="handleRotate()"
                                    class="h-6 w-6 transform transiton-transform duration-200 ease-in-out"
                                    title="Open"
                                    >
                                        <ion-icon name="chevron-down-circle-outline" class="w-full h-full text-primary dark:text-white dark:hover:text-opacity:75"></ion-icon>
                                    </span>
                                </div>
                            </h2>
                            <div x-ref="tab" :style="handleToggle()"
                                class="px-4 overflow-hidden max-h-0 duration-500 transition-all">
                                <div class="px-1 h-[500px]">
                                    <div class="flex flex-wrap gap-4 max-h-[500px] pb-4 overflow-y-auto">
                                        {{-- <span x-text="console.log(EditArticle.subarticles)"></span> --}}
                                        <template x-for="(s, index) in EditArticle?.subarticles">
                                            <span type="button" x-show="s"
                                                class="group h-max flex items-center justify-between col-12 lg:col-6 py-2 px-4 bg-white dark:bg-slate-third hover:bg-primary hover:text-white shadow-[0px_0px_4px_rgba(0,0,0,0.3)] font-iceberg text-base text-left rounded-lg transition duration-200 ease-in-out">
                                                <div class="flex items-center gap-1">
                                                    <b x-text="Number(index + 1) + '. '" class="text-primary dark:text-white group-hover:text-white"></b>
                                                    <b x-text="s?.title ? s?.title : 'New Sub-Article'">Sub-EditArticle 1</b>
                                                </div>
                                                <div class="flex items-center gap-1">
                                                    <button type="button" @click="
                                                        EditArticle.subarticles[editSub].description = tinymce.get('sub_content').getContent();
                                                        editSub = index;
                                                    " class="flex items-center justify-center p-1 rounded-full shadow-[0px_0px_4px_rgba(0,0,0,0.3)]"
                                                        title="Edit Article">
                                                        <i data-feather="edit" class="text-sm"></i>
                                                    </button>
                                                    <button type="button" @click="confirm('Delete this sub-article?') ? deleteSub(s?.id) : ''; s = null" class="flex items-center justify-center p-1 rounded-full shadow-[0px_0px_4px_rgba(0,0,0,0.3)]"
                                                        title="Delete Sub Article">
                                                        <i data-feather="trash-2" class="text-sm"></i>
                                                    </button>
                                                    <script>
                                                        feather.replace()
                                                    </script>
                                                </div>
                                            </span>
                                        </template>
                                        <span @click="
                                            editSub = EditArticle?.subarticles?.length; 
                                            EditArticle.subarticles[editSub] = addSub()
                                        " type="button"
                                            class="group cursor-pointer h-max flex items-center justify-center gap-2 col-12 lg:col-6 py-2 px-4 bg-white dark:bg-slate-third dark:hover:text-opacity-75 hover:bg-primary hover:text-white shadow-[0px_0px_4px_rgba(0,0,0,0.3)] font-iceberg text-base text-left rounded-lg transition duration-200 ease-in-out">
                                            <i data-feather="plus-circle" class="w-6 h-6 text-primary group-hover:text-white dark:text-slate-fourth group-hover:rotate-90 transition duration-200 ease-in-out"></i>
                                            <b>Create New Sub-Article</b>
                                            {{-- <span x-text="editSub"></span> --}}
                                            <!-- Feather Icons Scripts -->
                                            <script>
                                                feather.replace()
                                            </script>
                                        </span>
                                    </div>
                                </div>
    
                            </div>
                        </li>
    
                    </ul>
    
                    <template x-if="isLoading">
                        <div class="flex justify-end py-4">
                            <x-loading />
                        </div>
                    </template>
                    
                    <div class="flex flex-wrap lg:flex-nowrap" x-data="helpers">
                        <div class="mb-5 col-12">
                            <div class="flex justify-between">
                                <label for="sub_title" class="text-md">Title</label>
                                <class="flex items-center gap-2 mb-4"ex items-center gap-2">
                                    <b>Created At : </b>
                                    <span x-show="EditArticle?.subarticles?.[editSub]?.created_at" x-text="convertDate(EditArticle?.subarticles?.[editSub]?.created_at)" class="px-2 py-1 rounded-lg bg-primary text-white dark:bg-slate-third"></span>
                                </p>
                            </div>
                            <input x-model="EditArticle.subarticles[editSub].title" type="text" placeholder="Your text..." name="sub_title" id="sub_title"
                                class="px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white dark:bg-slate-secondary mt-4">
                            <template x-if="status_err?.[1]?.title">
                                <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                    <span class="span-danger" x-text="status_err?.[1]?.title[0]">Validasi Error</span>
                                </div>
                            </template>
                        </div>
    
                    </div>
    
                    <div class="mb-5">
                        <label for="sub_thumbnail" class="text-md">Thumbnail</label>
                        <input x-on:change="EditArticle.subarticles[editSub].thumbnail = Object.values($event.target.files)" type="file" name="thumbnail_subarticle" placeholder="Your thumbnail..." hidden name="sub_thumbnail" id="sub_thumbnail"
                            x-ref="filesubarticle" @change="
                                if ($refs.filesubarticle) {
                                    $refs.iconimagesubarticle.style.display = 'none';
                                    var reader = new FileReader();
                                    reader.readAsDataURL($refs.filesubarticle.files[0]);
                                    reader.onload = function (e) {
                                        EditArticle.subarticles[editSub].thumbnail_1 = e.target.result;
                                        EditArticle.subarticles[editSub].thumbnail_1_alt = $refs.filesubarticle.files[0].name;
                                    }
                                }
                            ">
                        <span
                            class="relative cursor-pointer flex items-center justify-center h-[200px] lg:h-[500px] px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white dark:bg-slate-secondary mt-4 overflow-y-hidden"
                            @click="
                                $refs.filesubarticle.click();
                            ">
                            <img x-bind:src="!EditArticle?.subarticles?.[editSub]?.thumbnail_1 ? 'http://localhost:8001/' + EditArticle?.subarticles?.[editSub]?.thumbnail : EditArticle?.subarticles?.[editSub]?.thumbnail_1" class="absolute w-full h-full rounded-lg" x-bind:alt="EditArticle?.subarticles?.[editSub]?.thumbnail_1_alt" onerror="this.style.opacity = 0" onload="this.style.opacity = 1">
                            <i data-feather="image" class="w-[100px] h-[100px] lg:h-[100px] text-gray-secondary"
                                x-ref="iconimagesubarticle">
                            </i>
                            <p x-show="EditArticle?.subarticles?.[editSub]?.thumbnail_1_alt" x-text="EditArticle?.subarticles?.[editSub]?.thumbnail_1_alt" class="filenamesubarticle absolute w-full bottom-0 py-2 bg-primary text-white text-center font-semibold rounded-lg transition duration-200 ease-in-out active"></p>
                        </span>
    
                        <template x-if="status_err?.[1]?.thumbnail">
                            <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                <span class="span-danger" x-text="status_err?.[1]?.thumbnail[0]">Validasi Error</span>
                            </div>
                        </template>
                    </div>
                    
                    <div class="mb-5 col-12">
                        <label for="sub_content" class="text-md">Content</label><br>
                        <textarea x-text="EditArticle?.subarticles?.[editSub]?.description" name="sub_description" id="sub_content" placeholder="Your content..."
                            class="px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white">
                        </textarea>
                        <template x-if="setTiny?.('sub_content', EditArticle?.subarticles?.[editSub]?.description);"></template>
    
                        
                        <template x-if="status_err?.[1]?.description">
                            <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                <span class="span-danger" x-text="status_err?.[1]?.description[0]">Validasi Error</span>
                            </div>
                        </template>
                    </div>
        
                    <div class="mb-5 col-12">
                        <span class="text-md">Choose Your Plan</span>
                        <div class="flex items-center gap-2 mt-2">
                            <label for="free" class="flex items-center gap-1">
                                <input type="radio" name="status" id="free" value="free" class="bg-gray-third checked:accent-primary dark:checked:accent-slate-third" x-model="EditArticle.subarticles[editSub].type">
                                <span class="text-base">Free</span>
                            </label>
                            <label for="paid" class="flex items-center gap-1">
                                <input type="radio" name="status" id="paid" value="paid" class="bg-gray-third checked:accent-primary dark:checked:accent-slate-third" x-model="EditArticle.subarticles[editSub].type">
                                <span class="text-base">Member-Only</span>
                            </label>
                        </div>
                        <p class="mt-4">*Get Royalty for Author</p>
    
                        <template x-if="status_err?.[1]?.type">
                            <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                <span class="span-danger" x-text="status_err?.[1]?.type[0]">Validasi Error</span>
                            </div>
                        </template>
                        <template x-if="status_err?.[1]?.min_free">
                            <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                <span class="span-danger" x-text="status_err?.[1]?.min_free[0]">Validasi Error</span>
                            </div>
                        </template>
                    </div>
    
                    <div class="flex items-center justify-center my-10">
                        <p x-show="isLoading" class="text-green-500">Loading...</p>
                        <button @click.prevent="updateSub(editSub)"
                            class="px-4 py-2 bg-primary dark:bg-slate-secondary rounded-lg text-white hover:text-opacity-80 transition duration ease-in-out shadow-[0px_4px_4px_rgba(0,0,0,0.25)]">
                            Save
                        </button>
                    </div>
                    <div x-show="showFlash">
                        <x-alert />
                    </div>
                
                </form>
    
            </div>
        </template>

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
    })
    </script>
</section>

