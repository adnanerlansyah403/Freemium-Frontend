
<div class="alert alert-{{ $type }}" role="alert">
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
    <span class="cursor-pointer">
        <svg class="w-5 h-5 inline mr-3" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12L19 6.41Z" fill="currentColor"/>
        </svg>      
    </span>
</div>