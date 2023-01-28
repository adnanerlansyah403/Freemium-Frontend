
<style>
    #topButton {
        bottom: -56px;
        opacity: 0;
        transition: .2s ease-in-out;
    }
    
    #topButton.active {
        opacity: 1;
        bottom: 56px;
        transition: .2s ease-in-out;
    }
</style>

<button id="topButton" type="button"
    class="fixed right-14 p-3 dark:bg-slate-secondary bg-primary text-white hover:text-white dark:hover:text-opacity-80 rounded-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)] z-[102]"
    title="Instructions">
    <i data-feather="arrow-up"></i>
</button>

<script>
    // Get the button
    let mybutton = document.getElementById('topButton');
    
    window.onload = function() {
        scrollFunction();
    }

    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function () {
        scrollFunction();
    };
    
    function scrollFunction() {
    if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
    mybutton.classList.add('active');
    } else {
    mybutton.classList.remove('active');
    }
    }
    // When the user clicks on the button, scroll to the top of the document
    mybutton.addEventListener('click', backToTop);
    
    function backToTop() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
    }
</script>
