<!doctype html>
<html lang="en">
<head><meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $setting->meta_title ?: 'BR Hyundai | Find Your Hyundai' }}</title>
  <meta name="description" content="{{ $setting->meta_description ?: 'Find your Hyundai at BR Hyundai and get your best available offer.' }}" />
  @if(!empty($setting->meta_keywords))
  <meta name="keywords" content="{{ $setting->meta_keywords }}" />
  @endif
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: { hyundai: '#002c5f', electric: '#00aad2', ink: '#07111f' },
          fontFamily: { sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'] },
          boxShadow: { glow: '0 0 0 5px rgba(0, 170, 210, .14)' }
        }
      }
    };
  </script>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <style>
    .hp-field { position: absolute; left: -10000px; width: 1px; height: 1px; overflow: hidden; }
    html { scroll-behavior: smooth; }
    body { overflow-x: hidden; }
    .hero-video { animation: slowZoom 16s ease-in-out infinite alternate; }
    @keyframes slowZoom { from { transform: scale(1.02); } to { transform: scale(1.09); } }
    .fade-up { animation: fadeUp .7s both; }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: translateY(0); } }
    .modal-backdrop { transition: opacity .25s ease; }
    .modal-card { transition: transform .3s ease, opacity .25s ease; }
    .modal-hidden { pointer-events: none; opacity: 0; }
    .modal-hidden .modal-card { transform: translateY(24px) scale(.98); opacity: 0; }
    .modal-visible .modal-card { transform: translateY(0) scale(1); opacity: 1; }
    .contact-rail { right: 1rem; top: 50%; transform: translateY(-50%); }
    .contact-rail a { transition: transform .2s ease, box-shadow .2s ease; }
    .contact-rail a:hover, .contact-rail a:focus-visible { transform: scale(1.06); }
    @media (max-width: 767px) {
      .contact-rail { right: .75rem; top: auto; bottom: 5.5rem; transform: none; }
      .contact-rail a { width: 2.75rem; height: 2.75rem; }
      .contact-rail .contact-label { display: none; }
    }
    @media (prefers-reduced-motion: reduce) {
      *, *::before, *::after { animation-duration: .01ms !important; transition-duration: .01ms !important; scroll-behavior: auto !important; }
    }
  </style>
</head>
<body class="bg-slate-50 font-sans text-ink antialiased">
  <header class="fixed inset-x-0 top-0 z-40 border-b border-white/10 bg-ink/90 text-white backdrop-blur-lg">
    <div class="mx-auto flex h-[72px] max-w-7xl items-center justify-between px-5 lg:px-8">
      <a href="#" class="flex items-center gap-3" aria-label="BR Hyundai home">
        <img src="{{ asset('storage/logo.png') }}" alt="BR Hyundai logo" width="200px" class="">
      </a>
      <nav class="hidden items-center gap-8 text-sm font-medium text-white/75 lg:flex">
        <a class="transition hover:text-white" href="#models">Hyundai Models</a>
        <a class="transition hover:text-white" href="#offers">Offers</a>
        <a class="transition hover:text-white" href="#videos">Videos</a>
        <a class="transition hover:text-white" href="#why-us">Why BR Hyundai</a>
        <a class="transition hover:text-white" href="#test-drive">Test Drive</a>
      </nav>
      <div class="flex items-center gap-3">
        <button data-open-form type="button"
        class="hidden items-center justify-center rounded-full bg-[#002C5F] px-5 py-2.5 text-sm font-extrabold uppercase tracking-wide text-white shadow-lg shadow-[#002C5F]/30 transition hover:-translate-y-0.5 hover:bg-[#00AAD2] focus:outline-none focus-visible:ring-4 focus-visible:ring-[#00AAD2]/50 md:inline-flex">
          GET BEST OFFER
        </button>
        <button id="menu-button" type="button" class="grid h-10 w-10 place-items-center rounded-xl border border-white/20 bg-white/5 transition hover:bg-white/10 lg:hidden" aria-label="Toggle navigation menu" aria-expanded="false">
          <svg id="menu-icon-open" aria-hidden="true" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
          <svg id="menu-icon-close" aria-hidden="true" class="hidden h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>
      </div>
    </div>
    <nav id="mobile-menu" class="hidden max-h-[85vh] overflow-y-auto border-t border-white/10 bg-ink/95 px-5 py-6 shadow-2xl backdrop-blur-xl lg:hidden">
      <div class="flex flex-col gap-3 text-base font-semibold text-white/90">
        <a class="mobile-nav-link flex items-center justify-between rounded-xl px-3 py-2 transition hover:bg-white/10 hover:text-white" href="#models">
          <span>Hyundai Models</span>
          <span class="text-xs text-electric">→</span>
        </a>
        <a class="mobile-nav-link flex items-center justify-between rounded-xl px-3 py-2 transition hover:bg-white/10 hover:text-white" href="#offers">
          <span>Current Offers</span>
          <span class="text-xs text-electric">→</span>
        </a>
        <a class="mobile-nav-link flex items-center justify-between rounded-xl px-3 py-2 transition hover:bg-white/10 hover:text-white" href="#videos">
          <span>Showroom Videos</span>
          <span class="text-xs text-electric">→</span>
        </a>
        <a class="mobile-nav-link flex items-center justify-between rounded-xl px-3 py-2 transition hover:bg-white/10 hover:text-white" href="#why-us">
          <span>Why BR Hyundai</span>
          <span class="text-xs text-electric">→</span>
        </a>
        <a class="mobile-nav-link flex items-center justify-between rounded-xl px-3 py-2 transition hover:bg-white/10 hover:text-white" href="#test-drive">
          <span>Book Test Drive</span>
          <span class="text-xs text-electric">→</span>
        </a>
      </div>

      <div class="mt-6 flex flex-col gap-3 border-t border-white/10 pt-5">
        <button data-open-form type="button" class="flex w-full items-center justify-center rounded-xl bg-electric py-3.5 text-xs font-black uppercase tracking-wider text-ink shadow-lg shadow-electric/20 transition hover:bg-white">
          GET BEST OFFER ↗
        </button>
        <div class="grid grid-cols-2 gap-3 text-xs font-bold">
          <a href="tel:{{ $setting->clean_phone }}" class="flex items-center justify-center gap-2 rounded-xl border border-white/20 bg-white/5 py-3 text-white transition hover:bg-white/15">
            <svg aria-hidden="true" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.8 19.8 0 0 1 3.1 5.18 2 2 0 0 1 5.1 3h3a2 2 0 0 1 2 1.72c.12.9.33 1.78.62 2.63a2 2 0 0 1-.45 2.11L9 10.73a16 16 0 0 0 4.27 4.27l1.27-1.27a2 2 0 0 1 2.11-.45c.85.29 1.73.5 2.63.62A2 2 0 0 1 22 16.92Z"/></svg>
            CALL US
          </a>
          <a href="https://wa.me/{{ $setting->clean_whatsapp }}" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center gap-2 rounded-xl bg-[#25D366] py-3 text-white transition hover:opacity-95">
            <svg aria-hidden="true" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M20.5 3.5A11.8 11.8 0 0 0 12.08 0C5.56 0 .26 5.3.26 11.82c0 2.08.54 4.1 1.57 5.88L.15 24l6.45-1.69a11.8 11.8 0 0 0 5.47 1.35h.01c6.52 0 11.82-5.3 11.82-11.82 0-3.16-1.23-6.13-3.4-8.34ZM12.08 21.6h-.01a9.8 9.8 0 0 1-5-1.37l-.36-.21-3.83 1 1.02-3.73-.24-.38a9.8 9.8 0 1 1 8.42 4.69Zm5.38-7.35c-.29-.14-1.71-.84-1.98-.94-.27-.1-.47-.14-.67.14-.2.29-.76.94-.93 1.13-.17.19-.34.22-.63.07-1.71-.85-2.83-1.52-3.96-3.45-.3-.52.3-.48.86-1.6.1-.2.05-.37-.03-.51-.07-.14-.67-1.61-.92-2.2-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.29-1.03 1.01-1.03 2.47s1.06 2.87 1.2 3.07c.14.2 2.08 3.18 5.04 4.46 1.87.81 2.6.88 3.54.74.57-.09 1.71-.7 1.95-1.38.24-.68.24-1.26.17-1.38-.07-.12-.27-.2-.56-.34Z"/></svg>
            WHATSAPP
          </a>
        </div>
      </div>
    </nav>
  </header>

  <main> 
    <section id="hero-slider-section" class="relative isolate w-full overflow-hidden bg-ink text-white pt-[72px]">
      @if(isset($sliders) && $sliders->count() > 0)
        <div id="hero-carousel" class="relative w-full overflow-hidden" data-slider-count="{{ $sliders->count() }}">
          <div id="slider-track" class="relative flex w-full transition-transform duration-700 ease-out">
            @foreach($sliders as $index => $slider)
              <div class="slider-slide relative w-full shrink-0 flex-none" data-slide-index="{{ $index }}">
                @if($slider->link)
                  <a href="{{ $slider->link }}" class="block w-full focus:outline-none">
                @endif
                <picture class="block w-full">
                  @if($slider->mobile_image)
                    <source media="(max-width: 767px)" srcset="{{ asset($slider->mobile_image_url) }}">
                  @endif
                  <img
                    src="{{ asset($slider->image_url) }}"
                    alt="{{ $slider->title ?: 'BR Hyundai Banner' }}"
                    class="block h-auto w-full object-contain"
                    @if($loop->first) fetchpriority="high" @else loading="lazy" @endif
                    decoding="async"
                  >
                </picture>
                @if($slider->link)
                  </a>
                @endif
              </div>
            @endforeach
          </div>

          @if($sliders->count() > 1)
            <button id="slider-prev" type="button" aria-label="Previous banner" class="absolute left-3 top-1/2 -translate-y-1/2 z-20 grid h-10 w-10 sm:h-12 sm:w-12 place-items-center rounded-full bg-ink/60 text-white backdrop-blur-md transition hover:bg-electric hover:text-ink shadow-lg opacity-80 hover:opacity-100">
              <svg aria-hidden="true" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button id="slider-next" type="button" aria-label="Next banner" class="absolute right-3 top-1/2 -translate-y-1/2 z-20 grid h-10 w-10 sm:h-12 sm:w-12 place-items-center rounded-full bg-ink/60 text-white backdrop-blur-md transition hover:bg-electric hover:text-ink shadow-lg opacity-80 hover:opacity-100">
              <svg aria-hidden="true" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 5l7 7-7 7"/></svg>
            </button>

            <div id="slider-dots" class="absolute bottom-4 inset-x-0 z-20 flex justify-center items-center gap-2">
              @foreach($sliders as $index => $slider)
                <button type="button" data-index="{{ $index }}" aria-label="Go to banner {{ $index + 1 }}" class="slider-dot h-2.5 rounded-full transition-all duration-300 {{ $loop->first ? 'w-8 bg-electric' : 'w-2.5 bg-white/50 hover:bg-white' }}"></button>
              @endforeach
            </div>
          @endif
        </div>
      @else
        <picture class="block w-full">
          <source media="(max-width: 767px)" srcset="https://hyperlocal-cms-content.onlinesales.ai/Mobile_banner_BAYON_1440x1883_ed2c9d8847.jpg">
          <img src="https://www.hyundai.com/content/dam/hyundai/in/en/data/find-a-car/bayon/highlights/bc4i-book-innerkv-pc.jpg" alt="Hyundai Bayon" class="block h-auto w-full object-contain" fetchpriority="high" decoding="async">
        </picture>
      @endif
    </section>

    <section id="models" class="mx-auto max-w-7xl px-5 py-20 lg:px-8 lg:py-28">
      <div class="flex flex-wrap items-end justify-between gap-5">
        <div><p class="text-xs font-extrabold uppercase tracking-[.25em] text-electric">BEEAAR Hyundai Cars</p><h2 class="mt-3 text-4xl font-extrabold tracking-tight sm:text-5xl">Find your Hyundai</h2><p class="mt-3 max-w-xl text-slate-500">Explore Hyundai SUVs, hatchbacks, sedans and electric cars available through BR Hyundai.</p></div>
        <!--<div class="flex gap-2"><button id="prev-model" class="grid h-11 w-11 place-items-center rounded-full border border-slate-200 text-lg transition hover:border-hyundai hover:bg-hyundai hover:text-white" aria-label="Previous model">←</button><button id="next-model" class="grid h-11 w-11 place-items-center rounded-full border border-slate-200 text-lg transition hover:border-hyundai hover:bg-hyundai hover:text-white" aria-label="Next model">→</button></div>-->
      </div>
      <div class="mt-8 flex flex-wrap gap-2 text-xs font-bold" role="tablist" aria-label="Filter Hyundai cars">
        <button type="button" data-filter="all" class="model-filter rounded-full bg-hyundai px-4 py-2 text-white transition hover:-translate-y-0.5" role="tab" aria-selected="true">All cars</button><button type="button" data-filter="suv" class="model-filter rounded-full bg-slate-100 px-4 py-2 text-slate-500 transition hover:-translate-y-0.5 hover:bg-slate-200" role="tab" aria-selected="false">SUVs</button><button type="button" data-filter="hatchback" class="model-filter rounded-full bg-slate-100 px-4 py-2 text-slate-500 transition hover:-translate-y-0.5 hover:bg-slate-200" role="tab" aria-selected="false">Hatchbacks</button><button type="button" data-filter="sedan" class="model-filter rounded-full bg-slate-100 px-4 py-2 text-slate-500 transition hover:-translate-y-0.5 hover:bg-slate-200" role="tab" aria-selected="false">Sedans</button><button type="button" data-filter="electric" class="model-filter rounded-full bg-slate-100 px-4 py-2 text-slate-500 transition hover:-translate-y-0.5 hover:bg-slate-200" role="tab" aria-selected="false">Electric</button>
      </div>
      <div id="model-track" class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($cars as $car)
        <article class="model-card overflow-hidden rounded-3xl border border-slate-200 bg-white" data-category="{{ \Illuminate\Support\Str::lower($car->category ?? '') }}">
          <div class="h-52 overflow-hidden bg-slate-100">@if($car->image_url)<img loading="lazy" class="h-full w-full object-cover transition duration-500 hover:scale-105" src="{{ $car->image_url }}" alt="{{ $car->name }}" />@else<div class="grid h-full place-items-center text-5xl font-black text-slate-300">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($car->name, 0, 1)) }}</div>@endif</div>
          <div class="flex min-h-[220px] flex-col p-6"><div class="flex items-center justify-between gap-3"><h3 class="text-2xl font-extrabold">{{ $car->name }}</h3>@if($car->category)<span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-500">{{ $car->category }}</span>@endif</div>
            @if($car->description)<p class="mt-3 text-sm leading-6 text-slate-500">{{ $car->description }}</p>@endif
            <div class="mt-4 flex items-center justify-between border-t border-slate-100 pt-4 text-xs"><span><strong class="block text-slate-800">{{ $car->engine_details ?: 'Hyundai performance' }}</strong><span class="text-slate-400">Engine details</span></span><span class="text-right"><strong class="block text-hyundai">{{ $car->ex_showroom_price ?: $car->price ?: 'Contact us' }}</strong><span class="text-slate-400">Ex-showroom</span></span></div>
            <button data-model="{{ $car->name }}" data-open-form class="mt-auto pt-5 text-left text-sm font-extrabold text-hyundai transition hover:text-electric">GET {{ \Illuminate\Support\Str::upper($car->name) }} OFFER ↗</button>
          </div>
        </article>
        @empty
        <p class="col-span-full rounded-2xl border border-dashed border-slate-300 p-10 text-center text-slate-500">Our latest Hyundai models will appear here shortly.</p>
        @endforelse
      </div>
    </section>

    <section id="offers" class="bg-white px-5 py-20 lg:px-8 lg:py-28">
      <div class="mx-auto max-w-7xl">
        <div class="flex flex-wrap items-end justify-between gap-5">
          <div><p class="text-xs font-extrabold uppercase tracking-[.25em] text-electric">BR Hyundai benefits</p><h2 class="mt-3 text-4xl font-extrabold tracking-tight sm:text-5xl">Offers made for your drive</h2><p class="mt-3 max-w-xl text-slate-500">Discover current benefits and speak to our team for the best available Hyundai offer.</p></div>
          <button data-open-form data-enquiry="Offer enquiry" class="rounded-full border border-hyundai px-5 py-3 text-xs font-extrabold text-hyundai transition hover:bg-hyundai hover:text-white">GET OFFER ASSISTANCE ↗</button>
        </div>
        <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
          @forelse($offers as $offer)
          <article class="group flex flex-col overflow-hidden rounded-3xl border border-slate-200 bg-slate-50 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
            <div class="relative overflow-hidden bg-gradient-to-br from-hyundai to-slate-800">
              @if($offer->image_url)<img loading="lazy" class="h-full w-full object-fit-contain transition duration-500 group-hover:scale-105" src="{{ $offer->image_url }}" alt="{{ $offer->title }}" />@endif
              @if($offer->badge)<span class="absolute left-4 top-4 rounded-full bg-electric px-3 py-1 text-[11px] font-extrabold uppercase tracking-wide text-ink">{{ $offer->badge }}</span>@endif
              @if(!$offer->image_url)<span class="absolute inset-0 grid place-items-center px-8 text-center text-2xl font-black text-white/90">{{ $offer->title }}</span>@endif
            </div>
            <div class="flex flex-1 flex-col p-6">
              <div class="space-y-2 text-xs text-slate-500">
                <p><span class="font-bold text-hyundai">Benefits:</span> {{ $offer->description ?: 'Talk to BR Hyundai for personalised benefits, finance assistance and exchange support.' }}</p>
                <p><span class="font-bold text-hyundai">Validity:</span> {{ $offer->starts_at || $offer->ends_at ? (($offer->starts_at ? $offer->starts_at->format('d M Y') : 'Now') . ' – ' . ($offer->ends_at ? $offer->ends_at->format('d M Y') : 'Until further notice')) : 'Contact us for current validity' }}</p>
              </div>
              <button data-open-form data-enquiry="Offer enquiry" data-offer-id="{{ $offer->id }}" data-offer-title="{{ $offer->title }}" class="mt-5 text-left text-sm font-extrabold text-hyundai transition hover:text-electric">CLAIM THIS OFFER ↗</button>
            </div>
          </article>
          @empty
          <div class="col-span-full rounded-3xl border border-dashed border-slate-300 p-10 text-center"><h3 class="text-xl font-extrabold">Personalised offers are available</h3><p class="mt-2 text-sm text-slate-500">Contact our team for the latest Hyundai benefits and dealer assistance.</p><button data-open-form data-enquiry="Offer enquiry" class="mt-5 rounded-full bg-hyundai px-6 py-3 text-sm font-extrabold text-white">GET BEST OFFER</button></div>
          @endforelse
        </div>
      </div>
    </section>

    <section id="videos" class="bg-slate-50 px-5 py-20 lg:px-8 lg:py-28">
      <div class="mx-auto max-w-7xl">
        <div class="text-center">
          <p class="text-xs font-extrabold uppercase tracking-[.25em] text-electric">See it in motion</p>
          <h2 class="mt-3 text-4xl font-extrabold tracking-tight sm:text-5xl">BR Hyundai Videos</h2>
          <p class="mx-auto mt-3 max-w-xl text-slate-500">Explore Hyundai design, technology and performance before you take the wheel.</p>
        </div>
        <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
          @forelse($videos as $video)
          <article class="overflow-hidden rounded-3xl bg-white shadow-lg shadow-slate-200/70">
            <div class="relative {{ $video->is_shorts ? 'aspect-[9/16]' : 'aspect-video' }} overflow-hidden bg-slate-900">
              @if($video->embed_url)<iframe class="absolute inset-0 h-full w-full" src="{{ $video->embed_url }}" title="{{ $video->title }}" loading="lazy" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>@endif
            </div>
            <div class="p-5">
              <h3 class="text-lg font-extrabold">{{ $video->title }}</h3>
              <a href="{{ $video->watch_url }}" target="_blank" rel="noopener noreferrer" class="mt-4 inline-block text-sm font-extrabold text-hyundai transition hover:text-electric">WATCH VIDEO ↗</a>
            </div>
          </article>
          @empty
          <p class="col-span-full rounded-2xl border border-dashed border-slate-300 p-10 text-center text-slate-500">Our latest videos will appear here shortly.</p>
          @endforelse
        </div>
        <div class="mt-6 text-center">
          <a href="https://www.youtube.com/results?search_query=Hyundai+India+official" target="_blank" rel="noopener noreferrer" class="text-sm font-bold text-hyundai transition hover:text-electric">Watch more on YouTube ↗</a>
        </div>
      </div>
    </section>

    <section id="why-us" class="mx-auto max-w-7xl px-5 py-20 lg:px-8 lg:py-28"><div class="text-center"><p class="text-xs font-extrabold uppercase tracking-[.25em] text-electric">The BEEAAR Hyundai promise</p><h2 class="mt-3 text-4xl font-extrabold tracking-tight sm:text-5xl">Why choose BR Hyundai?</h2></div><div class="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-4"><div class="rounded-2xl bg-white p-6 shadow-sm"><span class="text-2xl">✦</span><h3 class="mt-7 font-extrabold">Authorized dealership</h3><p class="mt-2 text-sm leading-6 text-slate-500">A trusted Hyundai sales experience.</p></div><div class="rounded-2xl bg-white p-6 shadow-sm"><span class="text-2xl">◈</span><h3 class="mt-7 font-extrabold">Expert sales team</h3><p class="mt-2 text-sm leading-6 text-slate-500">Advice that fits your lifestyle.</p></div><div class="rounded-2xl bg-white p-6 shadow-sm"><span class="text-2xl">↗</span><h3 class="mt-7 font-extrabold">Finance assistance</h3><p class="mt-2 text-sm leading-6 text-slate-500">Simple plans, clear guidance.</p></div><div class="rounded-2xl bg-white p-6 shadow-sm"><span class="text-2xl">♡</span><h3 class="mt-7 font-extrabold">Dedicated support</h3><p class="mt-2 text-sm leading-6 text-slate-500">Here before and after your drive.</p></div></div></section>

    <section id="test-drive" class="relative overflow-hidden bg-hyundai px-5 py-20 text-white lg:px-8 lg:py-24"><div class="absolute -right-24 -top-24 h-80 w-80 rounded-full bg-electric/20 blur-3xl"></div><div class="relative mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-8"><div><p class="text-xs font-extrabold uppercase tracking-[.25em] text-electric">Feel the difference</p><h2 class="mt-3 text-4xl font-extrabold tracking-tight sm:text-5xl">Experience your BR Hyundai.</h2><p class="mt-4 max-w-xl text-white/70">Book a test drive and experience your preferred Hyundai model on your terms.</p></div><button data-open-form data-enquiry="Test Drive Enquiry" class="rounded-full bg-white px-7 py-4 text-sm font-extrabold text-hyundai transition hover:-translate-y-1 hover:bg-electric">BOOK A TEST DRIVE →</button></div></section>

    <section class="relative isolate overflow-hidden px-5 py-24 text-white lg:px-8"><img class="absolute inset-0 -z-20 h-full w-full object-cover" loading="lazy" src="https://www.hyundai.com/content/dam/hyundai/in/en/data/find-a-car/bayon/highlights/bc4i-6innerkvpc.jpg" alt="" /><div class="absolute inset-0 -z-10 bg-ink/75"></div><div class="relative mx-auto max-w-7xl"><p class="text-xs font-extrabold uppercase tracking-[.25em] text-electric">Your next chapter starts here</p><h2 class="mt-4 max-w-2xl text-5xl font-extrabold tracking-tight sm:text-6xl">Ready to drive your Hyundai?</h2><p class="mt-5 max-w-lg text-white/70">Choose your model and get the latest available offer from BR Hyundai.</p><button data-open-form class="mt-8 rounded-full bg-electric px-7 py-4 text-sm font-extrabold text-ink transition hover:bg-white">GET MY BEST OFFER →</button></div></section>
  </main>

  <footer class="bg-ink px-5 py-10 text-white lg:px-8"><div class="mx-auto flex max-w-7xl flex-wrap justify-between gap-8"><div><div class="flex items-center gap-3"><img src="{{ asset('storage/logo.png') }}" width="200px" alt="BR Hyundai logo" class=""></div><p class="mt-4 max-w-xs text-sm leading-6 text-white/45">{{ $setting->address ?: 'Your trusted Hyundai partner for a confident drive in Lucknow.' }}</p></div><div class="text-sm text-white/60"><p class="font-bold text-white">Quick links</p><div class="mt-4 flex flex-col gap-2"><a href="#models" class="hover:text-electric">Models</a><a href="#offers" class="hover:text-electric">Offers</a><a href="#videos" class="hover:text-electric">Videos</a><a href="#test-drive" class="hover:text-electric">Test Drive</a></div></div><div class="text-sm text-white/60"><p class="font-bold text-white">Contact</p><p class="mt-4"><a href="tel:{{ $setting->clean_phone }}" class="text-white hover:text-electric font-semibold">{{ $setting->phone ?: '+91 9724 777 048' }}</a></p><p class="mt-2">{{ $setting->working_hours ?: 'Mon – Sun · 9am – 7pm' }}</p>@if($setting->email)<p class="mt-1"><a href="mailto:{{ $setting->email }}" class="hover:text-electric">{{ $setting->email }}</a></p>@endif</div></div><div class="mx-auto mt-10 max-w-7xl border-t border-white/10 pt-5 text-xs text-white/35">© {{ date('Y') }} BR Hyundai. All rights reserved.</div></footer>

 <aside class="contact-rail fixed bottom-6 right-6 z-30 hidden flex-col gap-3 md:flex" aria-label="Contact BR Hyundai">

  <a href="https://wa.me/{{ $setting->clean_whatsapp }}" target="_blank" rel="noopener noreferrer"
     aria-label="Chat with BR Hyundai on WhatsApp"
     class="flex h-14 w-14 items-center justify-center rounded-full bg-[#25D366] text-white shadow-xl shadow-green-900/20 transition hover:scale-105 focus:outline-none focus-visible:ring-4 focus-visible:ring-green-300">
    <svg aria-hidden="true" class="h-8 w-8 shrink-0" viewBox="0 0 24 24" fill="currentColor">
      <path d="M20.5 3.5A11.8 11.8 0 0 0 12.08 0C5.56 0 .26 5.3.26 11.82c0 2.08.54 4.1 1.57 5.88L.15 24l6.45-1.69a11.8 11.8 0 0 0 5.47 1.35h.01c6.52 0 11.82-5.3 11.82-11.82 0-3.16-1.23-6.13-3.4-8.34ZM12.08 21.6h-.01a9.8 9.8 0 0 1-5-1.37l-.36-.21-3.83 1 1.02-3.73-.24-.38a9.8 9.8 0 1 1 8.42 4.69Zm5.38-7.35c-.29-.14-1.71-.84-1.98-.94-.27-.1-.47-.14-.67.14-.2.29-.76.94-.93 1.13-.17.19-.34.22-.63.07-1.71-.85-2.83-1.52-3.96-3.45-.3-.52.3-.48.86-1.6.1-.2.05-.37-.03-.51-.07-.14-.67-1.61-.92-2.2-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.29-1.03 1.01-1.03 2.47s1.06 2.87 1.2 3.07c.14.2 2.08 3.18 5.04 4.46 1.87.81 2.6.88 3.54.74.57-.09 1.71-.7 1.95-1.38.24-.68.24-1.26.17-1.38-.07-.12-.27-.2-.56-.34Z"/>
    </svg>
    <span class="contact-label sr-only">WhatsApp</span>
  </a>

  <a href="tel:{{ $setting->clean_phone }}"
     aria-label="Call BR Hyundai at {{ $setting->phone }}"
     class="flex h-14 w-14 items-center justify-center rounded-full bg-hyundai text-white shadow-xl shadow-slate-900/20 transition hover:scale-105 focus:outline-none focus-visible:ring-4 focus-visible:ring-electric/60">
    <svg aria-hidden="true" class="h-7 w-7 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
      <path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.8 19.8 0 0 1 3.1 5.18 2 2 0 0 1 5.1 3h3a2 2 0 0 1 2 1.72c.12.9.33 1.78.62 2.63a2 2 0 0 1-.45 2.11L9 10.73a16 16 0 0 0 4.27 4.27l1.27-1.27a2 2 0 0 1 2.11-.45c.85.29 1.73.5 2.63.62A2 2 0 0 1 22 16.92Z"/>
    </svg>
    <span class="contact-label sr-only">Call us</span>
  </a>

 </aside>
  
  <div id="mobile-cta" class="fixed inset-x-0 bottom-0 z-30 flex items-center justify-around border-t border-slate-200 bg-white/95 px-3 py-2 shadow-2xl backdrop-blur md:hidden" style="padding-bottom: calc(0.5rem + env(safe-area-inset-bottom, 0px));">

  <a href="tel:{{ $setting->clean_phone }}" aria-label="Call BR Hyundai at {{ $setting->phone }}"
     class="flex min-w-[64px] flex-col items-center justify-center gap-1 text-[10px] font-bold leading-none text-slate-500">
    <svg aria-hidden="true" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
      <path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.8 19.8 0 0 1 3.1 5.18 2 2 0 0 1 5.1 3h3a2 2 0 0 1 2 1.72c.12.9.33 1.78.62 2.63a2 2 0 0 1-.45 2.11L9 10.73a16 16 0 0 0 4.27 4.27l1.27-1.27a2 2 0 0 1 2.11-.45c.85.29 1.73.5 2.63.62A2 2 0 0 1 22 16.92Z"/>
    </svg>
    <span>CALL</span>
  </a>

  <a href="https://wa.me/{{ $setting->clean_whatsapp }}" aria-label="Chat with BR Hyundai on WhatsApp" target="_blank" rel="noopener noreferrer"
     class="flex min-w-[64px] flex-col items-center justify-center gap-1 text-[10px] font-bold leading-none text-slate-500">
    <svg aria-hidden="true" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="currentColor">
      <path d="M20.5 3.5A11.8 11.8 0 0 0 12.08 0C5.56 0 .26 5.3.26 11.82c0 2.08.54 4.1 1.57 5.88L.15 24l6.45-1.69a11.8 11.8 0 0 0 5.47 1.35h.01c6.52 0 11.82-5.3 11.82-11.82 0-3.16-1.23-6.13-3.4-8.34ZM12.08 21.6h-.01a9.8 9.8 0 0 1-5-1.37l-.36-.21-3.83 1 1.02-3.73-.24-.38a9.8 9.8 0 1 1 8.42 4.69Zm5.38-7.35c-.29-.14-1.71-.84-1.98-.94-.27-.1-.47-.14-.67.14-.2.29-.76.94-.93 1.13-.17.19-.34.22-.63.07-1.71-.85-2.83-1.52-3.96-3.45-.3-.52.3-.48.86-1.6.1-.2.05-.37-.03-.51-.07-.14-.67-1.61-.92-2.2-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.29-1.03 1.01-1.03 2.47s1.06 2.87 1.2 3.07c.14.2 2.08 3.18 5.04 4.46 1.87.81 2.6.88 3.54.74.57-.09 1.71-.7 1.95-1.38.24-.68.24-1.26.17-1.38-.07-.12-.27-.2-.56-.34Z"/>
    </svg>
    <span>WHATSAPP</span>
  </a>

  <button data-open-form type="button"
          class="flex h-11 items-center justify-center rounded-full bg-electric px-7 text-xs font-extrabold leading-none text-ink shadow-lg shadow-electric/20 transition hover:bg-white">
    GET OFFER
  </button>

</div>

  <div id="form-modal" class="modal-hidden fixed inset-0 z-50 grid place-items-end bg-ink/70 p-0 backdrop-blur-sm sm:place-items-center sm:p-5" role="dialog" aria-modal="true" aria-labelledby="modal-title">
    <div class="modal-card max-h-[95vh] w-full overflow-y-auto rounded-t-3xl bg-white p-6 text-ink shadow-2xl sm:max-w-md sm:rounded-3xl sm:p-8">
      <div class="flex items-start justify-between"><div><p class="text-xs font-extrabold uppercase tracking-[.2em] text-electric">BR Hyundai</p><h2 id="modal-title" class="mt-2 text-2xl font-extrabold">Get your best offer</h2></div><button id="close-modal" class="grid h-9 w-9 place-items-center rounded-full bg-slate-100 text-xl text-slate-500" aria-label="Close form">×</button></div>
      <form id="modal-form" class="mt-6 space-y-3"><div class="hp-field" aria-hidden="true"><label>Website<input name="website" tabindex="-1" autocomplete="off" /></label></div><input type="hidden" name="form_started_at" value="" /><input type="hidden" name="selected_offer_id" value="" /><label id="modal-model-field" class="block text-xs font-bold text-slate-600">CHOOSE MODEL<select name="model" required class="mt-1.5 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm outline-none focus:border-electric focus:ring-4 focus:ring-electric/10"><option value="">Select Hyundai model</option>@forelse($cars as $car)<option value="{{ $car->name }}">{{ $car->name }}</option>@empty<option value="Any Hyundai model">Any Hyundai model</option>@endforelse</select></label><label id="modal-offer-field" class="hidden block text-xs font-bold text-slate-600">SELECT OFFER<select name="offer_choice" class="mt-1.5 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm outline-none focus:border-electric focus:ring-4 focus:ring-electric/10"><option value="">Select an active offer</option>@foreach($offers as $offer)<option value="{{ $offer->id }}">{{ $offer->title }}</option>@endforeach</select></label><p id="selected-offer" class="hidden rounded-xl bg-cyan-50 px-4 py-3 text-sm font-bold text-hyundai"></p><label class="block text-xs font-bold text-slate-600">FULL NAME<input name="name" required placeholder="Enter your name" class="mt-1.5 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm outline-none focus:border-electric focus:ring-4 focus:ring-electric/10" /></label><label class="block text-xs font-bold text-slate-600">CITY<input name="city" required placeholder="Your city" class="mt-1.5 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm outline-none focus:border-electric focus:ring-4 focus:ring-electric/10" /></label><label class="block text-xs font-bold text-slate-600">MOBILE NUMBER<input name="mobile" required type="tel" pattern="[0-9]{10}" placeholder="10-digit number" class="mt-1.5 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm outline-none focus:border-electric focus:ring-4 focus:ring-electric/10" /></label><button class="w-full rounded-xl bg-hyundai py-4 text-sm font-extrabold text-white transition hover:bg-electric hover:text-ink">GET MY BEST OFFER</button><p class="text-center text-[11px] text-slate-400">🔒 Your information is safe with us.</p></form>
      <div id="success-state" class="hidden py-8 text-center"><div class="mx-auto grid h-16 w-16 place-items-center rounded-full bg-emerald-100 text-3xl text-emerald-600">✓</div><h3 class="mt-5 text-2xl font-extrabold">Thank you!</h3><p class="mt-2 text-sm leading-6 text-slate-500">Your Hyundai enquiry has been received. Our team will contact you shortly.</p><button id="success-close" class="mt-6 rounded-full bg-hyundai px-6 py-3 text-sm font-bold text-white">EXPLORE MODELS</button></div>
    </div>
  </div>
  <script>
    const modal = document.getElementById('form-modal');
    const modalForm = document.getElementById('modal-form');
    const success = document.getElementById('success-state');
    document.querySelectorAll('form').forEach((form) => {
      const startedAt = form.elements.form_started_at;
      if (startedAt) startedAt.value = String(Date.now());
    });
    const openModal = (model, offerId, offerTitle) => {
      modalForm.classList.remove('hidden'); success.classList.add('hidden');
      modal.classList.remove('modal-hidden'); modal.classList.add('modal-visible'); document.body.classList.add('overflow-hidden');
      const modelField = document.getElementById('modal-model-field');
      const offerField = document.getElementById('modal-offer-field');
      const selectedOffer = document.getElementById('selected-offer');
      modalForm.elements.model.value = model || '';
      modalForm.elements.selected_offer_id.value = offerId || '';
      modalForm.elements.offer_choice.value = offerId || '';
      if (offerId) {
        modelField.classList.add('hidden'); modalForm.elements.model.required = false;
        offerField.classList.add('hidden'); modalForm.elements.offer_choice.required = false;
        selectedOffer.textContent = `Selected offer: ${offerTitle || 'Current offer'}`;
        selectedOffer.classList.remove('hidden');
      } else if (modalForm.dataset.enquiry === 'Offer enquiry') {
        modelField.classList.add('hidden'); modalForm.elements.model.required = false;
        offerField.classList.remove('hidden'); modalForm.elements.offer_choice.required = true;
        selectedOffer.classList.add('hidden');
      } else {
        modelField.classList.remove('hidden'); modalForm.elements.model.required = true;
        offerField.classList.add('hidden'); modalForm.elements.offer_choice.required = false;
        selectedOffer.classList.add('hidden');
      }
      setTimeout(() => modalForm.elements.name.focus(), 100);
    };
    const closeModal = () => { modal.classList.add('modal-hidden'); modal.classList.remove('modal-visible'); document.body.classList.remove('overflow-hidden'); };
    document.querySelectorAll('[data-open-form]').forEach((button) => button.addEventListener('click', () => {
      modalForm.dataset.enquiry = button.dataset.enquiry || 'Best Offer';
      openModal(button.dataset.model, button.dataset.offerId, button.dataset.offerTitle);
    }));
    modalForm.elements.offer_choice.addEventListener('change', (event) => {
      modalForm.elements.selected_offer_id.value = event.target.value;
    });
    document.getElementById('close-modal').addEventListener('click', closeModal);
    document.getElementById('success-close').addEventListener('click', () => { closeModal(); document.getElementById('models').scrollIntoView(); });
    modal.addEventListener('click', (event) => { if (event.target === modal) closeModal(); });
    document.addEventListener('keydown', (event) => { if (event.key === 'Escape') closeModal(); });
    const submitLead = async (form, onSuccess) => {
      const submitButton = form.querySelector('button[type="submit"], button');
      const originalText = submitButton.textContent;
      submitButton.disabled = true;
      submitButton.textContent = 'SAVING...';
      try {
        const payload = new FormData(form);
        payload.set('enquiry_type', form.dataset.enquiry || 'Best Offer');
        const response = await fetch('{{ route('leads.store') }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' }, body: payload });
        const result = await response.json();
        if (!response.ok || !result.success) throw new Error(result.message || 'Unable to save your enquiry.');
        onSuccess();
      } catch (error) {
        const message = error instanceof Error ? error.message : 'Unable to save your enquiry. Please try again.';
        let status = form.querySelector('[data-form-status]');
        if (!status) {
          status = document.createElement('p');
          status.dataset.formStatus = 'true';
          status.className = 'text-center text-xs font-semibold text-red-600';
          form.append(status);
        }
        status.textContent = message;
      } finally {
        submitButton.disabled = false;
        submitButton.textContent = originalText;
      }
    };
    modalForm.addEventListener('submit', (event) => {
      event.preventDefault();
      submitLead(modalForm, () => { modalForm.classList.add('hidden'); success.classList.remove('hidden'); });
    });
    document.querySelectorAll('[data-lead-form]').forEach((form) => form.addEventListener('submit', (event) => {
      event.preventDefault();
      submitLead(form, () => { openModal(form.elements.model.value); modalForm.classList.add('hidden'); success.classList.remove('hidden'); });
    }));
    const modelFilters = document.querySelectorAll('.model-filter');
    const modelCards = document.querySelectorAll('#model-track .model-card');
    modelCards.forEach((card) => {
      const category = card.querySelector('span')?.textContent.toLowerCase() || '';
      const model = card.querySelector('h3')?.textContent.toLowerCase() || '';
      card.dataset.category = category.includes('electric') ? 'electric' : category.includes('hatchback') || model.includes('i20') || model.includes('grand i10') ? 'hatchback' : category.includes('sedan') || model === 'aura' || model === 'verna' ? 'sedan' : 'suv';
    });
    modelFilters.forEach((filter) => filter.addEventListener('click', () => {
      const selected = filter.dataset.filter;
      modelFilters.forEach((item) => {
        const active = item === filter;
        item.classList.toggle('bg-hyundai', active);
        item.classList.toggle('text-white', active);
        item.classList.toggle('bg-slate-100', !active);
        item.classList.toggle('text-slate-500', !active);
        item.setAttribute('aria-selected', String(active));
      });
      modelCards.forEach((card) => { card.classList.toggle('hidden', selected !== 'all' && card.dataset.category !== selected); });
    }));
    const track = document.getElementById('model-track');
    document.getElementById('prev-model')?.addEventListener('click', () => track && track.scrollBy({ left: -track.clientWidth * .8, behavior: 'smooth' }));
    document.getElementById('next-model')?.addEventListener('click', () => track && track.scrollBy({ left: track.clientWidth * .8, behavior: 'smooth' }));

    // Hero Slider Carousel
    const heroCarousel = document.getElementById('hero-carousel');
    if (heroCarousel) {
      const sliderTrack = document.getElementById('slider-track');
      const slides = heroCarousel.querySelectorAll('.slider-slide');
      const dots = heroCarousel.querySelectorAll('.slider-dot');
      const prevBtn = document.getElementById('slider-prev');
      const nextBtn = document.getElementById('slider-next');
      const count = slides.length;
      let currentIndex = 0;
      let autoTimer = null;

      const goToSlide = (index) => {
        if (count <= 1 || !sliderTrack) return;
        currentIndex = (index + count) % count;
        sliderTrack.style.transform = `translateX(-${currentIndex * 100}%)`;
        dots.forEach((dot, i) => {
          if (i === currentIndex) {
            dot.classList.remove('w-2.5', 'bg-white/50');
            dot.classList.add('w-8', 'bg-electric');
          } else {
            dot.classList.remove('w-8', 'bg-electric');
            dot.classList.add('w-2.5', 'bg-white/50');
          }
        });
      };

      const startAuto = () => {
        if (count <= 1) return;
        stopAuto();
        autoTimer = setInterval(() => goToSlide(currentIndex + 1), 5000);
      };

      const stopAuto = () => {
        if (autoTimer) {
          clearInterval(autoTimer);
          autoTimer = null;
        }
      };

      if (prevBtn) prevBtn.addEventListener('click', () => { goToSlide(currentIndex - 1); startAuto(); });
      if (nextBtn) nextBtn.addEventListener('click', () => { goToSlide(currentIndex + 1); startAuto(); });

      dots.forEach((dot) => {
        dot.addEventListener('click', () => {
          goToSlide(Number(dot.dataset.index));
          startAuto();
        });
      });

      heroCarousel.addEventListener('mouseenter', stopAuto);
      heroCarousel.addEventListener('mouseleave', startAuto);
      heroCarousel.addEventListener('touchstart', stopAuto, { passive: true });
      heroCarousel.addEventListener('touchend', startAuto, { passive: true });

      let touchStartX = 0;
      heroCarousel.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
      }, { passive: true });
      heroCarousel.addEventListener('touchend', (e) => {
        const diff = touchStartX - e.changedTouches[0].screenX;
        if (Math.abs(diff) > 40) {
          if (diff > 0) goToSlide(currentIndex + 1);
          else goToSlide(currentIndex - 1);
          startAuto();
        }
      }, { passive: true });

      startAuto();
    }

    const menuButton = document.getElementById('menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const iconOpen = document.getElementById('menu-icon-open');
    const iconClose = document.getElementById('menu-icon-close');

    const toggleMobileMenu = (forceClose = false) => {
      if (!mobileMenu || !menuButton) return;
      const willBeOpen = forceClose ? false : mobileMenu.classList.contains('hidden');
      if (willBeOpen) {
        mobileMenu.classList.remove('hidden');
        menuButton.setAttribute('aria-expanded', 'true');
        iconOpen?.classList.add('hidden');
        iconClose?.classList.remove('hidden');
      } else {
        mobileMenu.classList.add('hidden');
        menuButton.setAttribute('aria-expanded', 'false');
        iconOpen?.classList.remove('hidden');
        iconClose?.classList.add('hidden');
      }
    };

    menuButton?.addEventListener('click', (e) => {
      e.stopPropagation();
      toggleMobileMenu();
    });

    mobileMenu?.querySelectorAll('a, button').forEach((item) => {
      item.addEventListener('click', () => {
        toggleMobileMenu(true);
      });
    });

    document.addEventListener('click', (e) => {
      if (mobileMenu && !mobileMenu.classList.contains('hidden') && !mobileMenu.contains(e.target) && !menuButton.contains(e.target)) {
        toggleMobileMenu(true);
      }
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') toggleMobileMenu(true);
    });
  </script>
</body>
</html>
