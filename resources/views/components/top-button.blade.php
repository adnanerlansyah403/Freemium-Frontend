
<style>
    #topButton.active {
        bottom: 56px;
        transition: .6s ease-in-out;
    }
</style>

<a id="topButton" href="{{ $url }}" class="fixed -bottom-full right-14 p-3 bg-white dark:bg-slate-secondary hover:bg-primary dark:text-white hover:text-white dark:hover:text-opacity-80 rounded-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] transition duration-200 ease-in-out">
    <i data-feather="arrow-up" class="animate-bounce" style="position: relative; bottom: -3px;"></i> 
</a>

<script>
    
    const topButton = document.getElementById('topButton');
    window.addEventListener('load', function () {
        if(window.scrollY > 200) {
            topButton.classList.add('active');
        } else {
            topButton.classList.remove('active');
        }
    });
    window.addEventListener("scroll", function () {
        if(window.scrollY > 200) {
            topButton.classList.add("active");
        } else {
            topButton.classList.remove("active");
        }
    })

</script>