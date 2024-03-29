<style>

    /* #menuSidebarAdmin {
        display: none;
    }

    #menuSidebarAdmin.active {
        display: block;
    } */

    .active {
        background: #7C000C;
        color: white;
    }
    
</style>

<div>
    <button 
    @click="
        document.getElementById('menuSidebarAdmin').classList.toggle('hidden')
    "
    class="lg:hidden mb-2 p-2 text-md text-gray-secondary rounded-full shadow-[0px_0px_4px_rgba(0,0,0,0.25)]"
    >
        <i data-feather="menu"></i>
    </button>
    <ul id="menuSidebarAdmin" class="hidden lg:block w-full">
        <li class="group flex items-center justify-center gap-1 py-3 mb-3 cursor-pointer rounded-primary text-primary dark:text-white text-center border border-primary dark:border-white text-base dark:bg-slate-primary hover:bg-primary dark:hover:bg-slate-secondary hover:text-white dark:hover:text-white lg:hover:translate-x-2 transition duration-200 ease-in-out {{Request::segment(2) == 'dashboard' ? 'active dark:bg-slate-secondary' : ''}}">
            <a href="{{ route("admin.dashboard.index") }}">Dashboard</a>
            <i data-feather="arrow-right" class="relative hidden opacity-0 -left-1 group-hover:opacity-80 group-hover:block group-hover:left-0 transition duration-200 ease-out"></i>
        </li>
        <li class="group flex items-center justify-center gap-1 py-3 mb-3 cursor-pointer rounded-primary text-primary dark:text-white text-center border border-primary dark:border-white text-base dark:bg-slate-primary hover:bg-primary dark:hover:bg-slate-secondary hover:text-white dark:hover:text-white lg:hover:translate-x-2 transition duration-200 ease-in-out {{Request::segment(2) == 'categories' ? 'active dark:bg-slate-secondary' : ''}}">
            <a href="{{ route('admin.categories.index') }}">Categories</a>
            <i data-feather="arrow-right" class="relative hidden opacity-0 -left-1 group-hover:opacity-80 group-hover:block group-hover:left-0 transition duration-200 ease-out"></i>
        </li>
        <li class="group flex items-center justify-center gap-1 py-3 mb-3 cursor-pointer rounded-primary text-primary dark:text-white text-center border border-primary dark:border-white text-base dark:bg-slate-primary hover:bg-primary dark:hover:bg-slate-secondary hover:text-white dark:hover:text-white lg:hover:translate-x-2 transition duration-200 ease-in-out {{Request::segment(2) == 'plans' ? 'active dark:bg-slate-secondary' : ''}}">
            <a href="{{ route('admin.plans.index') }}">Plans</a>
            <i data-feather="arrow-right" class="relative hidden opacity-0 -left-1 group-hover:opacity-80 group-hover:block group-hover:left-0 transition duration-200 ease-out"></i>
        </li>
        <li class="group flex items-center justify-center gap-1 py-3 mb-3 cursor-pointer rounded-primary text-primary dark:text-white text-center border border-primary dark:border-white text-base dark:bg-slate-primary hover:bg-primary dark:hover:bg-slate-secondary hover:text-white dark:hover:text-white lg:hover:translate-x-2 transition duration-200 ease-in-out {{Request::segment(2) == 'users' ? 'active dark:bg-slate-secondary' : ''}}">
            <a href="{{ route('admin.users.index') }}">Users</a>
            <i data-feather="arrow-right" class="relative hidden opacity-0 -left-1 group-hover:opacity-80 group-hover:block group-hover:left-0 transition duration-200 ease-out"></i>
        </li>
        <li class="group flex items-center justify-center gap-1 py-3 cursor-pointer rounded-primary text-primary dark:text-white text-center border border-primary dark:border-white text-base dark:bg-slate-primary hover:bg-primary dark:hover:bg-slate-secondary hover:text-white dark:hover:text-white lg:hover:translate-x-2 transition duration-200 ease-in-out
        {{Request::segment(2) == 'orders' ? 'active dark:bg-slate-secondary' : ''}}
        ">
            <a href="{{ route("admin.orders.index") }}">Order History</a>
            <i data-feather="arrow-right" class="relative hidden opacity-0 -left-1 group-hover:opacity-80 group-hover:block group-hover:left-0 transition duration-200 ease-out"></i>
        </li>
    </ul>
</div>