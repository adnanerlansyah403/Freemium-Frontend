<div class="container mx-auto mb-9">

    <nav class="col col-12 dark:text-white" style="margin-inline: 0;">
        <ul class="flex justify-center lg:justify-start items-center gap-7">
            <li class="pb-2 {{ $currentRoute == 'profile.index' ? 'border-b border-primary dark:border-white' : '' }} cursor-pointer">
                <a href="{{ route("profile.index") }}" class="text-base font-iceberg">
                    <span class="span dark:text-slate-third">My</span>
                    Profile
                </a>
            </li>
            <template x-if="data_user.role == 2">
                <li class="pb-2 {{ $currentRoute == 'article.index' ? 'border-b border-primary dark:border-white' : '' }} cursor-pointer">
                    <a href="{{ route("article.index") }}" class="text-base font-iceberg">
                        <span class="span dark:text-slate-third">My</span>
                        Articles
                    </a>
                </li>
            </template>
            <template x-if="data_user.role == 2">
                <li class="pb-2 {{ $currentRoute == 'transaction.history' ? 'border-b border-primary dark:border-white' : '' }} cursor-pointer">
                    <a href="{{ route("transaction.history") }}" class="text-base font-iceberg">
                        <span class="span dark:text-slate-third">Transaction</span>
                        History
                    </a>
                </li>
            </template>
            <template x-if="data_user.role == 1">
                <li class="pb-2 
                {{ $currentRoute == 'admin.dashboard.index' ||
                Request::segment(2) == 'categories' ||
                Request::segment(2) == 'plans' ||
                Request::segment(2) == 'users' ||
                Request::segment(2) == 'orders'||
                Request::segment(2) == 'myarticle'
                ? 'border-b border-primary dark:border-white' 
                : '' }} cursor-pointer">
                    <a href="{{ route("admin.dashboard.index") }}" class="text-base font-iceberg">
                        <span class="span dark:text-slate-third">Admin</span>
                        Dashboard
                    </a>
                </li>
            </template>
        </ul>
    </nav>

</div>