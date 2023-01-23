
<style>
    #topButton.active {
        bottom: 56px;
        transition: .6s ease-in-out;
    }
</style>

<button id="btn-back-to-top" type="button"
    class="fixed bottom-[56px] right-14 p-3 dark:bg-slate-secondary bg-primary text-white hover:text-white dark:hover:text-opacity-80 rounded-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] transition duration-200 ease-in-out"
    title="Instructions">
    <i data-feather="arrow-up" class="animate-bounce bottom-[3px]"></i>
</button>

<script>
    // Get the button
    let mybutton = document.getElementById('btn-back-to-top');
    
    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function () {
    scrollFunction();
    };
    
    function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = 'block';
    } else {
    mybutton.style.display = 'none';
    }
    }
    // When the user clicks on the button, scroll to the top of the document
    mybutton.addEventListener('click', backToTop);
    
    function backToTop() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
    }
</script>
