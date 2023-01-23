
<style>

    #alert {
        opacity: 0;
        top: -5%;
        transition: .2s ease-in-out !important;
    }

    #alert.active {
        opacity: 1;
        top: 10%;
        transition: .2s ease-in-out !important;
    }

</style>

{{-- <div class="alert alert-{{ $type }} hidden" role="alert" x-data="{ showFlash: true }" :class="{'block' : showFlash, 'hidden' : !showFlash}" x-init="setTimeout(() => showFlash = false, 3000)">
    <svg class="w-8 h-8 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
    <div>
        <span class="font-medium">
            @switch($type)
                @case('success')
                    Success alert!
                    @break
                @case('danger')
                    Danger alert!
                    @break
                @case('warning')
                    Danger alert!
                    @break
                @default
                    Info alert!                    
            @endswitch    
        </span> <br>
        <p>{{ $message }}</p>
    </div>
    <button >
        <span class="cursor-pointer">
            <svg class="w-5 h-5 inline mr-3" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12L19 6.41Z" fill="currentColor"/>
            </svg>      
        </span>
    </button>
</div> --}}

{{-- <div class="" x-data="{ showFlash: true, message:message }" :class="{'block' : showFlash, 'hidden' : !showFlash}" x-init="setTimeout(() => showFlash = false, 3000)">
    <div class="text-center lg:w-full w-[320px] md:w-full bg-[#04A96D] rounded-[10px] mb-2 lg:mb-[29px] md:mb-[29px] bg-opacity-20 lg:h-[50px] md:h-[50px] mt-5 lg:mt-0 h-[70px] font-normal text-sm px-[27px] py-[13px]">
        <span class="font-bold text-[#04A96D] leading-[27px]" x-text="message">
            Success
        </span> 
    </div>
</div> --}}


<div id="alert" class="fixed flex gap-4 left-1/2 -translate-x-1/2 p-4 rounded-lg max-w-[350px] dark:alert-dark w-full z-[101]" role="alert" x-data="{ showFlash: true }" :class="{
    'active' : showFlash, 
    '' : !showFlash || showFlash == false,
    'alert-success' : localStorage.getItem('typeStatus') == 'true',
    'alert-danger' : localStorage.getItem('typeStatus') == 'false'
    }" 
    {{-- x-init="setTimeout(() => {
        showFlash = false;
        document.getElementById('alert').classList.remove('active');
    }, 4000);" --}}
    >
    <svg class="w-8 h-8 inline" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
    <div>
        <span class="font-medium">
            Information
        </span> <br>
        <p x-text="message">Some messages of alert</p>
    </div>
</div>