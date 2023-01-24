
<style>

    #alert {
        opacity: 0;
        top: -5%;
        transition: .2s ease-in-out;
    }

    #alert.active {
        opacity: 1;
        top: 10%;
        transition: .2s ease-in-out;
    }

</style>


<div id="alert" class="fixed flex gap-4 left-1/2 -translate-x-1/2 p-4 rounded-lg max-w-[400px] dark:alert-dark w-full z-[101]" x-data="{ showFlash: true }" :class="{
    'active' : localStorage.getItem('showFlash') || showFlash, 
    '' : localStorage.getItem('showFlash') || !showFlash,
    'alert-success' : localStorage.getItem('typeStatus'),
    'alert-danger' : localStorage.getItem('typeStatus')
    }" 
    x-init="setTimeout(() => {
                localStorage.removeItem('showFlash');
                localStorage.removeItem('message');
              }, 4000);"
    >
    <svg class="w-8 h-8 inline" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
    <div>
        <span class="font-medium">
            Information
        </span> <br>
        <p x-text="message ? message : localStorage.getItem('message')">Some messages of alert</p>
    </div>
</div>