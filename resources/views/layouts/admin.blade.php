<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') · BR Hyundai</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .required-marker { color: #dc2626; margin-left: .2rem; }
    </style>
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
<div id="mobile-backdrop" class="fixed inset-0 z-20 hidden bg-slate-950/50 lg:hidden" onclick="toggleSidebar()"></div>
<aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-30 flex w-72 -translate-x-full flex-col bg-slate-950 text-white transition-transform lg:translate-x-0">
    <div class="flex items-center gap-3 border-b border-white/10 px-6 py-6">
        <img src="{{ asset('storage/logo.png') }}" alt="BR Hyundai logo" class="h-10 w-10 rounded-xl bg-white p-1 object-contain">
        <div><p class="font-black tracking-wide">BR HYUNDAI</p><p class="text-xs text-slate-400">Admin workspace</p></div>
    </div>
    <nav class="flex-1 space-y-2 px-4 py-6">
        @foreach ([['admin.dashboard','Dashboard','grid'],['admin.cars.index','Cars','car'],['admin.offers.index','Offers','tag'],['admin.videos.index','Videos','play'],['admin.leads.index','Leads','users']] as $nav)
            <a href="{{ route($nav[0]) }}" class="{{ request()->routeIs($nav[0].'*') ? 'bg-cyan-500 text-white shadow-lg shadow-cyan-500/20' : 'text-slate-300 hover:bg-white/10 hover:text-white' }} flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition">
                <svg aria-hidden="true" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    @if ($nav[2] === 'grid')
                        <path d="M4 4h6v6H4zM14 4h6v6h-6zM4 14h6v6H4zM14 14h6v6h-6z"/>
                    @elseif ($nav[2] === 'car')
                        <path d="m5 11 1.5-4h11L19 11m-14 0h14v6H5zm3 3h.01M16 14h.01M7 11h10"/>
                    @elseif ($nav[2] === 'tag')
                        <path d="m20 13-7 7-9-9V4h7l9 9Z"/><path d="M7.5 7.5h.01"/>
                    @elseif ($nav[2] === 'play')
                        <rect x="3" y="5" width="18" height="14" rx="2"/><path d="m10 9 5 3-5 3V9Z"/>
                    @else
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                    @endif
                </svg>
                {{ $nav[1] }}
            </a>
        @endforeach
    </nav>
    <div class="border-t border-white/10 p-4">
        <form method="POST" action="{{ route('admin.logout') }}">@csrf<button aria-label="Sign out" class="flex w-full items-center gap-3 rounded-xl px-4 py-3 text-left text-sm font-semibold text-slate-300 hover:bg-red-500/20 hover:text-red-200"><svg aria-hidden="true" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 17l5-5-5-5M15 12H3"/><path d="M21 19V5a2 2 0 0 0-2-2h-6"/></svg><span>Sign out</span></button></form>
    </div>
</aside>
<div class="lg:pl-72">
    <header class="sticky top-0 z-10 flex h-20 items-center justify-between border-b border-slate-200 bg-white/90 px-4 shadow-sm backdrop-blur sm:px-8">
        <div class="flex items-center gap-3"><button class="rounded-lg p-2 text-slate-600 hover:bg-slate-100 lg:hidden" onclick="toggleSidebar()" aria-label="Open navigation"><svg aria-hidden="true" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg></button><div><p class="text-xs font-bold uppercase tracking-wider text-cyan-600">Management portal</p><h1 class="text-lg font-black text-slate-900">@yield('page_heading', 'Overview')</h1></div></div>
        <div class="hidden items-center gap-3 sm:flex"><span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700">● System online</span><span class="grid h-9 w-9 place-items-center rounded-full bg-cyan-100 font-bold text-cyan-700">A</span></div>
    </header>
    <main class="mx-auto max-w-7xl px-4 py-6 sm:px-8 sm:py-8">
        @if (session('success'))<div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-semibold text-emerald-800"><span class="text-lg">✓</span>{{ session('success') }}</div>@endif
        @if (session('error'))<div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm font-semibold text-red-800">{{ session('error') }}</div>@endif
        @if ($errors->any())<div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800"><p class="font-bold">Please fix the following:</p><ul class="mt-2 list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        @yield('content')
    </main>
</div>
<script>function toggleSidebar(){document.getElementById('admin-sidebar').classList.toggle('-translate-x-full');document.getElementById('mobile-backdrop').classList.toggle('hidden');}</script>
</body>
</html>
