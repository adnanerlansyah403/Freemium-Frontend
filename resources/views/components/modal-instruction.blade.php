<div x-ref="modalInstruction" style="display: none;" class="absolute lg:fixed right-[70px] top-[8.3%] sm:top-[11.35%]" x-data="{
    modalActive: false,
}" x-init="
    setTimeout(function(){
        $refs.modalInstruction.style.display = 'block'
    }, 600)
">
    <button x-show="modalActive == false" x-transition @click="modalActive = true;" type="button" class="drop-shadow-2xl group shadow-[0_0_10px_4px_#7C000B] hover:bg-primary mt-6 md:mt-[60px] lg:h-16 lg:w-16 h-10 md:w-10 dark:hover:shadow-[0_0_10px_4px_#fff] p-2 flex items-center justify-center rounded-full hover:text-[#FFEA20] bg-primary dark:bg-slate-secondary text-white  transition duration-200 ease-in-out" title="Instructions">
        <ion-icon name="bulb-outline" title="Instructions" class="text-[23px]  h-20 w-20 lg:text-md transition duration-200 ease-in-out"></ion-icon>
    </button>

    <div x-show="modalActive == true" x-transition class="fixed w-full h-full top-0 left-0 right-0 bottom-0 bg-[rgba(0,0,0,50%)] grid place-items-center" style="z-index: 101;">
        <div class="bg-white dark:bg-slate-secondary rounded-lg max-w-[400px] w-full h-auto px-3 py-4 dark:text-white">
            <p class="flex items-center gap-3">
                <span>
                    <ion-icon name="alert-circle-outline" class="text-lg"></ion-icon>
                </span>
                <b class="-translate-y-[2px]">Requirements for Creating Article</b>
            </p>
            <div class="flex items-start gap-2 flex-wrap my-4">
                {{ $slot }}
            </div>
            <div class="flex items-center justify-center" @click="modalActive = false;">
                <button class="px-4 py-2 my-2 border border-primary dark:border-white hover:text-opacity-50 dark:hover:bg-slate-third dark:hover:text-white transition duration-20
                ease-in-out">
                    Close
                </button>
            </div>
        </div>
    </div>

</div>
