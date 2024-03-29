{{-- @section("title", "Edit Article - Freemium App") --}}

<section class="pt-[140px] pb-[100px]" x-data="user">
    <div x-init="checkSession()"></div>
    <div x-init="checkRoleUser()"></div>
    <div x-init="fetchMe()"></div>

    <div x-init="flash()"></div>
    <div x-show="showFlash">
        <x-alert />
    </div>

    <div x-init="fetchEditArticle(window.location.href.split('/').pop())"></div>
    <span x-init="localStorage.removeItem('changed_sub')"></span>

    <template x-if="isLogedIn && data_user.role == 2 && data_user.id == EditArticle?.user_id">
        <script>
            document.title = 'Edit Article - Freemium App';
        </script>
    </template>
    
    <style>

        .mult-select-tag {
            margin-top: 14.5px;
        }
        
        .mult-select-tag .body {
            padding: 10px;
            min-height: unset;
        }

        .mult-select-tag .btn-container {
            border: none;
        }

        .mult-select-tag .item-container {
            padding: 6px;
            border: none;
            background: #7C000B;
            color: #fff;
            font-weight: 600;
        }

        .mult-select-tag .item-container .item-label {
            color: #fff;
            font-weight: 600;
            padding-inline: 6px;
        }

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

        .removefile.active {
            right: 12px;
            transition: .2s ease-in-out;
        }

        .tox .tox-editor-header {
            z-index: 0;
        }

    </style>

    <div
    x-init="
        if(isLogedIn == true && data_user.role == 2 && data_user.id == EditArticle?.user_id) {
        }
        setTimeout(function() {
            $refs.wrapperEditArticle.style.display = 'block';
        }, 400)
    "style="display: none;" x-ref="wrapperEditArticle">

        <div x-data="helpers" class="container mx-auto flex items-center dark:text-white">

            <form class="col lg:mx-0 col-12">
                <p class="flex items-center gap-2 mb-4" x-show="!isLoading">
                    <b>Created At : </b>
                    <span x-text="convertDate(EditArticle?.created_at)" class="px-2 py-1 rounded-lg bg-primary text-white dark:bg-slate-third" style="display: none;" x-init="
                        setTimeout(function() {
                            $refs.dateArticle.style.display = 'block';
                        }, 400)
                    " x-ref="dateArticle"></span>
                </p>

                <div class="flex flex-wrap lg:flex-nowrap">
                    <div class="mb-5 col-12 lg:col-6">
                        <div class="flex justify-between">
                            <label for="title" class="text-md">Title</label>
                        </div>
                        <input x-model="EditArticle.title" onchange="isDirty()" type="text" placeholder="Your text..." name="title" id="title"
                            class="px-3 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white dark:bg-slate-secondary dark:border dark:border-white mt-4">

                        <template x-if="status_err?.[0]?.title">
                            <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                <span class="span-danger" x-text="status_err?.[0]?.title[0]">Validation Error</span>
                            </div>
                        </template>
                    </div>

                    <div class="mb-5 col-12 lg:col lg:col-6">
                        <div class="flex justify-between">
                            <label for="category_id" class="text-md">Category</label>
                        </div>
                        <select multiple onchange="isDirty()" name="category_id[]" id="category_id"
                            class="px-3 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white dark:bg-slate-secondary dark:border dark:border-white has-scrollbar2 mt-4">
                            <option value=""> Choosen category... </option>
                            <template x-for="(c, index) in categories">
                                <option :value="c.id" :selected="EditArticle?.tags?.some(element => element.category_id == c.id)" x-text="c.name">test</option>
                            </template>
                        </select>

                        <template x-if="status_err?.[0]?.category_id">
                            <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                <span class="span-danger" x-text="status_err?.[0]?.category_id[0]">Validation Error</span>
                            </div>
                        </template>

                        <template x-if="status_err?.[0] ? status_err?.[0]['category_id.0'] : ''">
                            <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                <span class="span-danger">Please select at least 1 category</span>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="mb-5">
                    <label for="thumbnail" class="text-md">Thumbnail</label>
                    <input x-on:change="EditArticle.thumbnail = Object.values($event.target.files)" onchange="isDirty()" type="file" accept="image/*" name="thumbnail" id="thumbnail" placeholder="Your thumbnail..." hidden
                        x-ref="file" @change="
                            if ($refs.file) {
                                $refs.iconimage.style.display = 'none';
                                var reader = new FileReader();
                                reader.readAsDataURL($refs.file.files[0]);
                                reader.onload = function (e) {
                                    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
                                    if(!allowedExtensions.exec($refs.file.files[0].name)) {
                                        $refs.iconimageerror.style.display = 'block';
                                        $refs.image.src = '';
                                        $refs.image.alt = '';
                                        $refs.filename.innerText = '';
                                        $refs.filename.classList.remove('active');
                                    } else {
                                        EditArticle.thumbnail_1 = e.target.result;
                                        EditArticle.thumbnail_1_alt = $refs.file.files[0].name;
                                        $refs.filename.classList.add('active');
                                        $refs.filename.innerText = $refs.file.files[0].name;
                                    }
                                }
                            }
                        ">
                    <span
                        class="relative cursor-pointer flex items-center justify-center h-[300px] md:h-[400px] lg:h-[500px] px-3 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white dark:bg-slate-secondary dark:border dark:border-white mt-4 overflow-y-hidden"
                        @click="
                            $refs.file.click();
                        ">
                        <img x-ref="image" x-bind:src="!EditArticle?.thumbnail_1 ? imgUrl + EditArticle?.thumbnail : EditArticle?.thumbnail_1" class="absolute w-full h-full rounded-lg object-fill" x-bind:alt="EditArticle?.thumbnail_1_alt"  onerror="this.style.opacity = 0" onload="this.style.opacity = 1">
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
                        <p x-show="EditArticle?.thumbnail_1_alt" x-text="EditArticle?.thumbnail_1_alt" x-ref="filename" class="filename absolute w-full -bottom-1/2 py-2 bg-primary text-white text-center font-semibold rounded-lg transition duration-200 ease-in-out active"></p>
                    </span>

                    <template x-if="status_err?.[0]?.thumbnail">
                        <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <span class="span-danger" x-text="status_err?.[0]?.thumbnail[0]">Validation Error</span>
                        </div>
                    </template>
                </div>

                <div class="mb-5 col-12">
                    <div class="flex justify-between items-center mb-5">
                        <label for="content" class="text-md">Content</label><br>
                        <p><strong>Shift + Enter</strong> to Pressing enter once</p>
                    </div>
                    <textarea
                    x-text="EditArticle?.description" name="description" id="content" placeholder="Your content..."
                        class="px-3 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white">
                    </textarea>
                    <template x-if="setTiny?.('content', EditArticle?.description);"></template>

                    <template x-if="status_err?.[0]?.description">
                        <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <span class="span-danger" x-text="status_err?.[0]?.description[0]">Validation Error</span>

                    </template>
                </div>

                <div class="flex items-center justify-center mt-6 mb-10">
                    <button @click.prevent="updateArticle()" onclick="formSubmitting = true; save()"
                        class="px-4 py-2 bg-primary dark:bg-slate-secondary rounded-lg text-white hover:text-opacity-80 transition duration ease-in-out shadow-[0px_4px_4px_rgba(0,0,0,0.25)]">
                        Save
                    </button>
                </div>

            </form>

        </div>

        <div class="relative container mx-auto mt-4" x-data="{
            editSub: 0,
            changed_sub: new Map()
        }">

            <div class="w-full my-1 px-5 lg:px-0 dark:text-white">

                <p class="font-semibold text-sm lg:text-base mb-2 bg-primary dark:bg-white dark:text-slate-secondary bg-opacity-20 p-3 rounded-lg">
                    *If you make three paid sub contents, then you must have to create 3 free content first.
                </p>

                <ul class="flex flex-col mb-10">

                    <li class="bg-white dark:bg-slate-secondary dark:text-white my-2 shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-lg" x-data="accordion(1)">
                        <h2 @click="handleClick()"
                            class="flex flex-row justify-between items-center font-semibold p-3 cursor-pointer">
                            <span>Sub Article List</span>
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
                        {{-- edit subarticle accordion --}}
                        <div x-ref="tab" :style="handleToggle()"
                            class="px-4 overflow-hidden max-h-0 duration-500 transition-all">
                            <div class="px-1 h-[500px]">
                                <div class="flex flex-wrap gap-4 max-h-[500px] pb-4 overflow-y-auto">
                                    <template x-for="(s, index) in EditArticle?.subarticles">
                                        <span type="button" x-show="s"
                                            x-bind:class="[
                                                changed_sub.get(index) ? 'bg-primary' : ''
                                            ]"
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
                                                <button type="button" @click="
                                                    if(confirm('Delete this sub-article?')){
                                                        deleteSub(s?.id);
                                                        EditArticle.subarticles.splice(editSub, 1);
                                                        editSub--;
                                                    }"
                                                class="flex items-center justify-center p-1 rounded-full shadow-[0px_0px_4px_rgba(0,0,0,0.3)]"
                                                    title="Delete Sub Article">
                                                    <i data-feather="trash-2" class="text-sm"></i>
                                                </button>
                                                <script>
                                                    feather?.replace()
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
                                            feather?.replace()
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

                <div x-show="EditArticle?.subarticles?.length">
                    <div class="flex flex-wrap lg:flex-nowrap" x-data="helpers">
                        <div class="mb-5 col-12">
                            <div class="flex justify-between">
                                <label for="sub_title" class="text-md">Title</label>

                                <template x-if="EditArticle?.subarticles?.[editSub]?.created_at">
                                    <p class="flex items-center gap-2 mb-4">
                                        <b>Created At : </b>
                                        <span x-show="EditArticle?.subarticles?.[editSub]?.created_at" x-text="convertDate(EditArticle?.subarticles?.[editSub]?.created_at)" class="px-2 py-1 rounded-lg bg-primary text-white dark:bg-slate-third" style="display: none;" x-init="
                                        setTimeout(function() {
                                            $refs.dateSubArticle.style.display = 'block';
                                        }, 500)
                                    " x-ref="dateSubArticle"></span>
                                    </p>
                                </template>

                            </div>
                            <input 
                                x-bind:value="EditArticle?.subarticles?.[editSub]?.title" 
                                x-on:change="
                                    EditArticle.subarticles[editSub].title = $event.target.value; 
                                    changed_sub.set(editSub, true);
                                    localStorage.setItem('changed_sub', changed_sub.size);
                                "
                                type="text" placeholder="Your text..." name="sub_title" id="sub_title"
                                class="px-3 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white dark:bg-slate-secondary mt-4">
                            <template x-if="status_err?.[1]?.title">
                                <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                    <span class="span-danger" x-text="status_err?.[1]?.title[0]">Validation Error</span>
                                </div>
                            </template>
                        </div>

                    </div>

                    <div class="mb-5">
                        <label for="sub_thumbnail" class="text-md">Thumbnail</label>
                        <input x-on:change="
                            EditArticle.subarticles[editSub].thumbnail = Object.values($event.target.files)
                            changed_sub.set(editSub, true);
                            localStorage.setItem('changed_sub', changed_sub.size);
                        " type="file" accept="image/*" name="thumbnail_subarticle" placeholder="Your thumbnail..." hidden name="sub_thumbnail" id="sub_thumbnail"
                            x-ref="filesubarticle" @change="
                                if ($refs.filesubarticle) {
                                    $refs.iconimagesubarticle.style.display = 'none';
                                    var reader = new FileReader();
                                    reader.readAsDataURL($refs.filesubarticle.files[0]);
                                    reader.onload = function (e) {
                                        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
                                        if(!allowedExtensions.exec($refs.filesubarticle.files[0].name)) {
                                            $refs.iconimagesubarticleerror.style.display = 'block';
                                            $refs.imagesubarticle.src = '';
                                            $refs.imagesubarticle.alt = '';
                                            $refs.filenamesubarticle.innerText = '';
                                            $refs.filenamesubarticle.classList.remove('active');
                                        } else {
                                            EditArticle.subarticles[editSub].thumbnail_1 = e.target.result;
                                            EditArticle.subarticles[editSub].thumbnail_1_alt = $refs.filesubarticle.files[0].name;
                                            $refs.filenamesubarticle.classList.add('active');
                                            $refs.filenamesubarticle.innerText = $refs.file.files[0].name;
                                        }
                                    }
                                }
                            ">
                        <span
                            class="relative cursor-pointer flex items-center justify-center h-[300px] md:h-[400px] lg:h-[500px] px-3 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white dark:bg-slate-secondary mt-4 overflow-y-hidden"
                            @click="
                                $refs.filesubarticle.click();
                            ">
                            <img x-ref="imagesubarticle" x-bind:src="!EditArticle?.subarticles?.[editSub]?.thumbnail_1 ? imgUrl + EditArticle?.subarticles?.[editSub]?.thumbnail : EditArticle?.subarticles?.[editSub]?.thumbnail_1" class="absolute w-full h-full rounded-lg  object-fill" x-bind:alt="EditArticle?.subarticles?.[editSub]?.thumbnail_1_alt" onerror="this.style.opacity = 0" onload="this.style.opacity = 1" accept="image/*">
                            <div class="text-center"
                            x-ref="iconimagesubarticle">
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
                            x-ref="iconimagesubarticleerror" style="display: none;">
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
                            <p x-show="EditArticle?.subarticles?.[editSub]?.thumbnail_1_alt" x-text="EditArticle?.subarticles?.[editSub]?.thumbnail_1_alt" x-ref="filenamesubarticle" class="filenamesubarticle absolute w-full -bottom-1/2 py-2 bg-primary text-white text-center font-semibold rounded-lg transition duration-200 ease-in-out active"></p>
                        </span>

                        <template x-if="status_err?.[1]?.thumbnail">
                            <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                <span class="span-danger" x-text="status_err?.[1]?.thumbnail[0]">Validation Error</span>
                            </div>
                        </template>
                    </div>

                    <div class="mb-5 col-12">
                        <div class="flex justify-between items-center mb-5">
                            <label for="sub_content" class="text-md">Content</label><br>
                            <p><strong>Shift + Enter</strong> to Pressing enter once</p>
                        </div>
                        <textarea x-text="EditArticle?.subarticles?.[editSub]?.description" name="sub_description" id="sub_content" placeholder="Your content..."
                            class="px-3 py-4 w-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] rounded-primary bg-white">
                        </textarea>
                        <template x-if="setTiny?.('sub_content', EditArticle?.subarticles?.[editSub]?.description);"></template>


                        <template x-if="status_err?.[1]?.description">
                            <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                <span class="span-danger" x-text="status_err?.[1]?.description[0]">Validation Error</span>
                            </div>
                        </template>
                    </div>

                    <div class="mb-5 col-12">
                        <span class="text-md">Choose Your Plan</span>
                        <div class="flex items-center gap-2 mt-2">
                            <label for="free" class="flex items-center gap-1">
                                <input type="radio" name="status" id="free" value="free" class="bg-gray-third checked:accent-primary dark:checked:accent-slate-third" 
                                x-bind:checked="EditArticle?.subarticles?.[editSub]?.type == 'free'" 
                                x-on:change="
                                    console.log(EditArticle.subarticles);
                                    EditArticle.subarticles[editSub].type = $event.target.value
                                    changed_sub.set(editSub, true);
                                    localStorage.setItem('changed_sub', changed_sub.size);
                                ">
                                <span class="text-base">Free</span>
                            </label>
                            <label for="paid" class="flex items-center gap-1">
                                <input type="radio" name="status" id="paid" value="paid" class="bg-gray-third checked:accent-primary dark:checked:accent-slate-third" 
                                x-bind:checked="EditArticle?.subarticles?.[editSub]?.type == 'paid'" 
                                x-on:change="
                                    console.log(EditArticle.subarticles);
                                    EditArticle.subarticles[editSub].type = $event.target.value
                                    changed_sub.set(editSub, true);
                                    localStorage.setItem('changed_sub', changed_sub.size);
                                ">
                                <span class="text-base">Member-Only</span>
                            </label>
                        </div>
                        <p class="mt-4">*Get Royalty for Author</p>

                        <template x-if="status_err?.[1]?.type">
                            <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                <span class="span-danger" x-text="status_err?.[1]?.type[0]">Validation Error</span>
                            </div>
                        </template>
                        <template x-if="status_err?.[1]?.min_free">
                            <div class="mt-3 flex text-[#b91c1c] items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                <span class="span-danger" x-text="status_err?.[1]?.min_free[0]">Validation Error</span>
                            </div>
                        </template>
                    </div>

                    <div class="flex items-center justify-center my-10">
                        <button @click.prevent="
                            updateSub(editSub)
                            changed_sub.delete(editSub);
                            localStorage.setItem('changed_sub', changed_sub.size);
                        " 
                            onclick="formSubmitting_sub = true; save()"
                            class="px-4 py-2 bg-primary dark:bg-slate-secondary rounded-lg text-white hover:text-opacity-80 transition duration ease-in-out shadow-[0px_4px_4px_rgba(0,0,0,0.25)]">
                            Save
                        </button>
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

    </div>



    <template x-if="isLoading">
        <div class="flex justify-center px-32 py-4">
            <x-loading-page />
        </div>
    </template>

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
        
        var formSubmitting = false;
        var formSubmitting_sub = false;
        var changed = false;

        // Mean that the article is edited but not updated yet
        function isDirty() { 
            changed = true;
        }

        function save(){
            // if article is updating
            if (formSubmitting) { // your condition here
                changed = false;
                formSubmitting = false;
            }
            if(formSubmitting_sub){
                formSubmitting_sub = false;
            }
            
            return undefined;
        }

        window.addEventListener("beforeunload", function (e) {
            // if article is not changed and count of changed sub is 0
            let test = localStorage.getItem('changed_sub') ? localStorage.getItem('changed_sub') : 0;
            if(!changed && parseInt(test) == 0){
                // result on not alerting user
                return undefined;
            }
            // variable for alert message
            var confirmationMessage = "You have unsaved changes. Are you sure you want to leave?";

            // e.preventDefault();
            (e || window.event).returnValue = confirmationMessage; //Gecko + IE
                    
            // returning alert for user
            return confirmationMessage; //Gecko + Webkit, Safari, Chrome etc.
        });
    </script>
    
</section>

