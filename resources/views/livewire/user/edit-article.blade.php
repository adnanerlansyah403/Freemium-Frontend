{{-- Title Section --}}
<div x-data="user" x-init="checkSession()">
    <template x-if="isLogedIn">
        <script>
            document.title = 'Edit Article - Freemium App';
        </script>
    </template>
</div>

<div x-data="user" class="py-[100px]" x-show="isLoading">
    {{-- <div class="border border-blue-300 shadow rounded-md p-4 max-w-sm w-full mx-auto">
        <div class="animate-pulse flex space-x-4">
          <div class="rounded-full bg-slate-700 h-10 w-10"></div>
          <div class="flex-1 space-y-6 py-1">
            <div class="h-2 bg-slate-700 rounded"></div>
            <div class="space-y-3">
              <div class="grid grid-cols-3 gap-4">
                <div class="h-2 bg-slate-700 rounded col-span-2"></div>
                <div class="h-2 bg-slate-700 rounded col-span-1"></div>
              </div>
              <div class="h-2 bg-slate-700 rounded"></div>
            </div>
          </div>
        </div>
      </div> --}}
</div>

<section class="py-[100px]" x-data="user" x-init="checkSession()" style="display: none;">
    <style>
        .filename.active {
            bottom: 0;
            transition: .2s ease-in-out;
        }

        .filenamesubarticle.active {
            bottom: 0;
            transition: .2s ease-in-out;
        }

        .filesize.active {
            right: 12px;
            transition: .2s ease-in-out;
        }

        .has-scrollbar::-webkit-scrollbar {
            background-color: transparent !important;
            width: 6px !important;
        }

        .has-scrollbar::-webkit-scrollbar-thumb {
            background-color: #7C000B;
            border-radius: 50px;
            width: 6px !important;
        }

        .has-scrollbar::-webkit-scrollbar-button {
            width: calc(25% - 40px);
        }

        .has-scrollbar::-moz-scrollbar {
            background-color: #7C000B !important;
            height: 6px !important;
        }

        .has-scrollbar::-moz-scrollbar-track {
            outline: 2px solid #8B8585;
            border-radius: 50px;
        }

        .has-scrollbar::-moz-scrollbar-button {
            width: calc(25% - 40px);
        }
    </style>

    <div x-init="
        if(isLogedIn == true) {
            fetchEditArticle(window.location.href.split('/').pop())
            setTimeout(() => {
                return document.querySelector('section').style.display = 'block';
            }, 1000);
        }
    ">

        <div class="container mx-auto flex items-center">

            <form action="" class="col col-12">

                <div class="flex flex-wrap lg:flex-nowrap">
                    <div class="mb-5 col-12 lg:col-6">
                        <label for="text" class="text-md">Title</label>
                        <input x-model="EditArticle.data.title" type="text" placeholder="Your text..."
                            class="px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white mt-4">
                    </div>

                    <div class="mb-5 col-12 lg:col lg:col-6">
                        <label for="text" class="text-md">Category</label>
                        <select x-model="EditArticle.data.tags[0].category_id" name="category_id" id=""
                            class="px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white mt-4">
                            <option value="">--Choosen Category--</option>
                            <template x-for="(c, index) in EditArticle.category">
                                <option x-bind:value="c.id" x-text="c.name">test</option>
                            </template>
                        </select>
                    </div>
                </div>

                <div class="mb-5">
                    <label for="text" class="text-md">Thumbnail</label>
                    <input type="file" name="thumbnail" placeholder="Your thumbnail..." hidden x-ref="file" @change="
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
                        ">
                        <img x-bind:src="'http://localhost:8001/' + EditArticle.data.thumbnail" src="" x-ref="image" class="absolute w-full h-full object-cover rounded-lg" alt="">
                        <i data-feather="image" class="w-[100px] h-[100px] lg:h-[100px] text-gray-secondary"
                            x-ref="iconimage">
                        </i>
                        <p class="filename absolute w-full -bottom-full py-2 bg-primary text-white text-center font-semibold rounded-lg transition duration-200 ease-in-out"
                            x-ref="filename">
                        </p>
                    </span>
                </div>

                <div class="mb-5 col-12">
                    <label for="text" class="text-md">Content</label><br>
                    <textarea 
                    x-text="EditArticle.data.description" id="content" placeholder="Your content..."
                        class="px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white">
                        <div x-text="EditArticle.data.description"></div>
                    </textarea>
                    <span x-init="setTiny('content', EditArticle.data.description);"></span>
                </div>

                <div class="flex items-center justify-center my-10">
                    <button type="submit"
                        class="px-4 py-2 bg-primary rounded-lg text-white hover:text-opacity-80 transition duration ease-in-out shadow-[0px_4px_4px_rgba(0,0,0,0.25)]">
                        Save
                    </button>
                </div>

            </form>

        </div>

        <div class="container mx-auto mt-4" x-data="{
            editSub: 0,
        }">


            <form class="w-full my-1 px-5 lg:px-0">

                <ul class="flex flex-col mb-10">

                    <li class="bg-white my-2 shadow-lg" x-data="accordion(1)">
                        <h2 @click="handleClick()"
                            class="flex flex-row justify-between items-center font-semibold p-3 border border-gray-secondary rounded-lg cursor-pointer">
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
                            <div class="py-10 px-1 flex max-h-[500px] overflow-y-scroll flex-wrap gap-4 has-scrollbar">
                                <template x-for="(s, index) in EditArticle.data.subarticles">
                                    <span type="button"
                                        class="h-max flex items-center justify-between col-12 lg:col-6 py-2 px-4 bg-white hover:bg-primary hover:text-white shadow-[0px_0px_4px_rgba(0,0,0,0.3)] font-iceberg text-base text-left rounded-lg transition duration-200 ease-in-out">
                                        <b x-text="s.title">Sub-EditArticle 1</b>
                                        <div class="flex items-center gap-1">
                                            <button type="button" @click="editSub = index;" class="flex items-center justify-center p-1 rounded-full shadow-[0px_0px_4px_rgba(0,0,0,0.3)]"
                                                title="Edit EditArticle">
                                                <i data-feather="edit" class="text-sm">
                                                </i>
                                            </button>
                                            <button type="button" href="#" class="flex items-center justify-center p-1 rounded-full shadow-[0px_0px_4px_rgba(0,0,0,0.3)]"
                                                title="Delete Sub EditArticle">
                                                <i data-feather="trash-2" class="text-sm">
                                                </i>
                                            </button>
                                        </div>
                                    </span>
                                </template>
                                <span type="button"
                                    class="h-max flex items-center justify-between col-12 lg:col-6 py-2 px-4 bg-white hover:bg-primary hover:text-white shadow-[0px_0px_4px_rgba(0,0,0,0.3)] font-iceberg text-base text-left rounded-lg transition duration-200 ease-in-out">
                                    <b>Sub-EditArticle 1</b>
                                    <div class="flex items-center gap-1">
                                        <button type="button" class="flex items-center justify-center p-1 rounded-full shadow-[0px_0px_4px_rgba(0,0,0,0.3)]"
                                            title="Edit Article">
                                            <i data-feather="edit" class="text-sm">
                                            </i>
                                        </a>
                                        <a class="flex items-center justify-center p-1 rounded-full shadow-[0px_0px_4px_rgba(0,0,0,0.3)]"
                                            title="Delete Sub Article">
                                            <i data-feather="trash-2" class="text-sm">
                                            </i>
                                        </a>
                                    </div>
                                </span>
                            </div>

                        </div>
                    </li>

                </ul>
                <div class="flex flex-wrap lg:flex-nowrap">
                    <div class="mb-5 col-12 lg:col-6">
                        <label for="text" class="text-md">Title</label>
                        <input x-model="EditArticle.data.subarticles[editSub].title" type="text" placeholder="Your text..."
                            class="px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white mt-4">
                    </div>

                    {{-- <div class="mb-5 col-12 lg:col lg:col-6">
                        <label for="text" class="text-md">Category</label>
                        <select x-model="EditArticle.data.tags[0].category_id" name="category_id" id=""
                            class="px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white mt-4">
                            <option value="">--Choosen Category--</option>
                            <template x-for="(c, index) in EditArticle.category">
                                <option x-bind:value="c.id" x-text="c.name">test</option>
                            </template>
                        </select>
                    </div> --}}
                </div>

                <div class="mb-5">
                    <label for="text" class="text-md">Thumbnail</label>
                    <input type="file" name="thumbnail_subarticle" placeholder="Your thumbnail..." hidden
                        x-ref="filesubarticle" @change="
                            if ($refs.filesubarticle) {
                                $refs.iconimagesubarticle.style.display = 'none';
                                var reader = new FileReader();
                                reader.readAsDataURL($refs.filesubarticle.files[0]);
                                reader.onload = function (e) {
                                    $refs.subimage.src = e.target.result;
                                    $refs.subimage.alt = $refs.filesubarticle.name;
                                    $refs.filenamesubarticle.classList.add('active');
                                    $refs.filenamesubarticle.innerText = $refs.filesubarticle.files[0].name;
                                }
                            }
                        ">
                    <span
                        class="relative cursor-pointer flex items-center justify-center h-[200px] lg:h-[500px] px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white mt-4 overflow-y-hidden"
                        @click="
                            $refs.filesubarticle.click();
                        ">
                        <img x-bind:src="'http://localhost:8001/' + EditArticle.data.subarticles[editSub].thumbnail" src="" x-ref="subimage" class="absolute w-full h-full object-cover rounded-lg" alt="">
                        <i data-feather="image" class="w-[100px] h-[100px] lg:h-[100px] text-gray-secondary"
                            x-ref="iconimagesubarticle">
                        </i>
                        <p class="filenamesubarticle absolute w-full -bottom-full py-2 bg-primary text-white text-center font-semibold rounded-lg transition duration-200 ease-in-out"
                            x-ref="filenamesubarticle">
                        </p>
                    </span>
                </div>
                
                <div class="mb-5 col-12">
                    <label for="text" class="text-md">Content</label><br>
                    <textarea x-text="EditArticle.data.subarticles[editSub].title" id="sub_content" placeholder="Your content..."
                        class="px-2 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white">
                    </textarea>
                </div>

                <div class="flex items-center justify-center my-10">
                    <button type="submit"
                        class="px-4 py-2 bg-primary rounded-lg text-white hover:text-opacity-80 transition duration ease-in-out shadow-[0px_4px_4px_rgba(0,0,0,0.25)]">
                        Save
                    </button>
                </div>

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
    })
    </script>
</section>

