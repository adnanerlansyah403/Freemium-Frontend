<div class="container mx-auto mb-9">

    <nav class="col col-12 dark:text-white" style="margin-inline: 0;">
        <ul class="flex justify-center lg:justify-start items-center gap-7">
            <li class="pb-2 {{ $currentRoute == 'profile.index' ? 'border-b border-primary dark:border-white' : '' }} cursor-pointer">
                <a href="{{ route("profile.index") }}" class="text-base font-iceberg">
                    <span class="span dark:text-slate-third">My</span>
                    Profile
                </a>
            </li>
            <li class="pb-2 {{ $currentRoute == 'article.index' ? 'border-b border-primary dark:border-white' : '' }} cursor-pointer">
                <a href="{{ route("article.index") }}" class="text-base font-iceberg">
                    <span class="span dark:text-slate-third">My</span>
                    Articles
                </a>
            </li>
            <template x-if="data_user.role == 1">
                <li class="pb-2 {{ $currentRoute == 'admin.dashboard.index' ? 'border-b border-primary dark:border-white' : '' }} cursor-pointer">
                    <a href="{{ route("admin.dashboard.index") }}" class="text-base font-iceberg">
                        <span class="span dark:text-slate-third">Admin</span>
                        Dashboard
                    </a>
                </li>
            </template>
        </ul>
    </nav>

</div>