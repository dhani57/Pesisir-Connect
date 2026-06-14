<!-- Mobile sidebar backdrop -->
<div x-show="sidebarOpen" 
     x-transition:enter="transition-opacity ease-linear duration-300" 
     x-transition:enter-start="opacity-0" 
     x-transition:enter-end="opacity-100" 
     x-transition:leave="transition-opacity ease-linear duration-300" 
     x-transition:leave-start="opacity-100" 
     x-transition:leave-end="opacity-0" 
     class="fixed inset-0 z-40 bg-gray-900/80 lg:hidden" 
     @click="sidebarOpen = false" 
     aria-hidden="true" style="display: none;"></div>

<!-- Sidebar -->
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
       class="fixed inset-y-0 left-0 z-50 flex w-72 flex-col bg-[#135071] text-white transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 shadow-xl lg:shadow-none">
    
    <!-- Sidebar Header -->
    <div class="flex shrink-0 items-center px-6 py-6 border-b border-white/10">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
            <!-- Ocean Blue / Globe Icon -->
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white/10 text-white">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="flex flex-col">
                <span class="text-xl font-bold tracking-tight text-white leading-tight">PesisirConnect</span>
                <span class="text-xs font-medium text-sky-200/80">Super Admin</span>
            </div>
        </a>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto px-4 py-6 no-scrollbar">
        <ul class="space-y-2">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="group flex gap-x-3 rounded-xl p-2 text-sm font-medium leading-6 {{ request()->routeIs('admin.dashboard') ? 'bg-sky-900/50 text-white border border-sky-800/50' : 'text-sky-100 hover:bg-sky-900/50 hover:text-white transition-all duration-200' }}">
                    <svg class="h-6 w-6 shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-sky-300' : 'text-sky-400/70 group-hover:text-sky-300' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.transactions.index') }}" class="group flex gap-x-3 rounded-xl p-2 text-sm font-medium leading-6 {{ request()->routeIs('admin.transactions.*') ? 'bg-sky-900/50 text-white border border-sky-800/50' : 'text-sky-100 hover:bg-sky-900/50 hover:text-white transition-all duration-200' }}">
                    <svg class="h-6 w-6 shrink-0 {{ request()->routeIs('admin.transactions.*') ? 'text-sky-300' : 'text-sky-400/70 group-hover:text-sky-300' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Finansial Global
                </a>
            </li>
            <li>
                <a href="{{ route('admin.vendors.index') }}" class="group flex gap-x-3 rounded-xl p-2 text-sm font-medium leading-6 {{ request()->routeIs('admin.vendors.*') ? 'bg-sky-900/50 text-white border border-sky-800/50' : 'text-sky-100 hover:bg-sky-900/50 hover:text-white transition-all duration-200' }}">
                    <svg class="h-6 w-6 shrink-0 {{ request()->routeIs('admin.vendors.*') ? 'text-sky-300' : 'text-sky-400/70 group-hover:text-sky-300' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    Verifikasi Vendor
                </a>
            </li>
            <li>
                <a href="{{ route('admin.categories.index') }}" class="group flex gap-x-3 rounded-xl p-2 text-sm font-medium leading-6 {{ request()->routeIs('admin.categories.*') ? 'bg-sky-900/50 text-white border border-sky-800/50' : 'text-sky-100 hover:bg-sky-900/50 hover:text-white transition-all duration-200' }}">
                    <svg class="h-6 w-6 shrink-0 {{ request()->routeIs('admin.categories.*') ? 'text-sky-300' : 'text-sky-400/70 group-hover:text-sky-300' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                    </svg>
                    Kategori
                </a>
            </li>
            <li>
                <a href="{{ route('admin.destinations.index') }}" class="group flex gap-x-3 rounded-xl p-2 text-sm font-medium leading-6 {{ request()->routeIs('admin.destinations.*') ? 'bg-sky-900/50 text-white border border-sky-800/50' : 'text-sky-100 hover:bg-sky-900/50 hover:text-white transition-all duration-200' }}">
                    <svg class="h-6 w-6 shrink-0 {{ request()->routeIs('admin.destinations.*') ? 'text-sky-300' : 'text-sky-400/70 group-hover:text-sky-300' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                    </svg>
        </ul>
    </nav>
</aside>
