{{-- @section("title", "Edit Article - Freemium App") --}}

<section class="py-[100px]" x-data="user" x-init="checkSession()" style="display: none;">
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

            setTimeout(function() {
                return document.querySelector('section').style.display = 'block';
            }, 1000)
        }
    ">

        <div class="container mx-auto flex items-center dark:text-white">

            <form action="" class="col col-12">

                <div class="flex flex-wrap lg:flex-nowrap">
                    <div class="mb-5 col-12 lg:col-6">
                        <label for="text" class="text-md">Title</label>
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
                        <label for="text" class="text-md">Category</label>
                        <select x-model="EditArticle.tags[0].category_id" name="category_id" id="category_id"
                            class="px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white dark:bg-slate-secondary mt-4">
                            <option value="">--Choosen Category--</option>
                            <template x-for="(c, index) in categories">
                                <option :value="c.id" :selected="c.id == EditArticle.tags[0].category_id" x-text="c.name">test</option>
                            </template>
                        </select>
                        <span x-show="console.log(EditArticle?.category, EditArticle.tags[0].category_id)"></span>

                        <template x-if="status_err?.[0]?.category_id">
                            <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                <span class="span-danger" x-text="status_err?.[0]?.category_id[0]">Validasi Error</span>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="mb-5">
                    <label for="text" class="text-md">Thumbnail</label>
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
                        <img x-bind:src="!EditArticle?.thumbnail_1 ? 'http://localhost:8001/' + EditArticle?.thumbnail : EditArticle?.thumbnail_1" class="absolute w-full h-full rounded-lg" x-bind:alt="EditArticle?.thumbnail_1_alt">
                        <i data-feather="image" class="w-[100px] h-[100px] lg:h-[100px] text-gray-secondary"
                            x-ref="iconimage">
                        </i>
                        <p x-show="EditArticle?.thumbnail_1_alt" x-text="EditArticle?.thumbnail_1_alt" class="filename absolute w-full -bottom-full py-2 bg-primary text-white text-center font-semibold rounded-lg transition duration-200 ease-in-out active"></p>
                    </span>

                    <template x-if="status_err?.[0]?.thumbnail">
                        <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <span class="span-danger" x-text="status_err?.[0]?.thumbnail[0]">Validasi Error</span>
                        </div>
                    </template>
                </div>

                <div class="mb-5 col-12">
                    <label for="text" class="text-md">Content</label><br>
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
                    <button @click.prevent="updateArticle()"
                        class="px-4 py-2 bg-primary dark:bg-slate-secondary rounded-lg text-white hover:text-opacity-80 transition duration ease-in-out shadow-[0px_4px_4px_rgba(0,0,0,0.25)]">
                        Save
                    </button>
                </div>

            </form>

        </div>

        <div class="container mx-auto mt-4" x-data="{
            editSub: 0,
        }">


            <form class="w-full my-1 px-5 lg:px-0 dark:text-white">

                <ul class="flex flex-col mb-10">

                    <li class="bg-white dark:bg-slate-secondary dark:text-white my-2 shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-lg" x-data="accordion(1)">
                        <h2 @click="handleClick()"
                            class="flex flex-row justify-between items-center font-semibold p-3 cursor-pointer">
                            <span>Daftar List Sub Artikel</span>
                            <div class="flex items-center gap-2">
                                <svg :class="handleRotate()"
                                    class="fill-current text-purple-700 h-6 w-6 transform transition-transform duration-500"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M13.962,8.885l-3.736,3.739c-0.086,0.086-0.201,0.13-0.314,0.13S9.686,12.71,9.6,12.624l-3.562-3.56C5.863,8.892,5.863,8.611,6.036,8.438c0.175-0.173,0.454-0.173,0.626,0l3.25,3.247l3.426-3.424c0.173-0.172,0.451-0.172,0.624,0C14.137,8.434,14.137,8.712,13.962,8.885 M18.406,10c0,4.644-3.763,8.406-8.406,8.406S1.594,14.644,1.594,10S5.356,1.594,10,1.594S18.406,5.356,18.406,10 M17.521,10c0-4.148-3.373-7.521-7.521-7.521c-4.148,0-7.521,3.374-7.521,7.521c0,4.147,3.374,7.521,7.521,7.521C14.148,17.521,17.521,14.147,17.521,10">
                                    </path>
                                </svg>
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
                                                <b x-text="s?.title ? s?.title : 'New Sub-Article'">Sub-EditArticle 1</b>
                                                <b x-text="s?.title ? '(' + Number(index + 1) + ')' : ''" class="text-primary dark:text-white group-hover:text-white"></b>
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <button type="button" @click="
                                                    console.log('test');
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
                <div class="flex flex-wrap lg:flex-nowrap">
                    <div class="mb-5 col-12">
                        <label for="text" class="text-md">Title</label>
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
                    <label for="text" class="text-md">Thumbnail</label>
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
                        <img x-bind:src="!EditArticle?.subarticles?.[editSub]?.thumbnail_1 ? 'http://localhost:8001/' + EditArticle?.subarticles?.[editSub]?.thumbnail : EditArticle?.subarticles?.[editSub]?.thumbnail_1" class="absolute w-full h-full rounded-lg" x-bind:alt="EditArticle?.subarticles?.[editSub]?.thumbnail_1_alt">
                        <i data-feather="image" class="w-[100px] h-[100px] lg:h-[100px] text-gray-secondary"
                            x-ref="iconimagesubarticle">
                        </i>
                        <p x-show="EditArticle?.subarticles?.[editSub]?.thumbnail_1_alt" x-text="EditArticle?.subarticles?.[editSub]?.thumbnail_1_alt" class="filenamesubarticle absolute w-full -bottom-full py-2 bg-primary text-white text-center font-semibold rounded-lg transition duration-200 ease-in-out active"></p>
                    </span>

                    <template x-if="status_err?.[1]?.thumbnail">
                        <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <span class="span-danger" x-text="status_err?.[1]?.thumbnail[0]">Validasi Error</span>
                        </div>
                    </template>
                </div>
                
                <div class="mb-5 col-12">
                    <label for="text" class="text-md">Content</label><br>
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

