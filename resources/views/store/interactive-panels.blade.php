@extends('layouts.store')

@section('title', 'Yara Interactive Panels for Smart Classrooms | 55" to 100"')

@push('styles')
    <meta name="description" content="Yara Interactive Flat Panels for schools, colleges and coaching centres: teachers write, explain and share lessons on a 4K 20-point touch board. 55, 65, 75, 85 and 100 inch, on the wall or on a stand.">
@endpush

@php
    $base = fn ($file) => asset("storage/products/interactive-panels/explore/{$file}");
    $lesson = fn ($file) => asset("storage/products/interactive-panels/lessons/{$file}");
    $wa = fn ($text) => 'https://wa.me/' . config('services.chatbot.whatsapp') . '?text=' . rawurlencode($text);
    $whatsapp = $wa('Hi Yara, I am interested in Interactive Flat Panels for our classrooms. Please share details and pricing.');
    $label = fn (int $inch) => "{$inch}\"";

    // Screen corners (percent of the frame image, TL TR BR BL) of the panel photo, from the render script.
    $quad = [
        'stand' => '1.765,0.773 95.701,4.845 95.358,41.384 1.765,42.629',
        'wall' => '1.518,1.320 98.664,1.320 98.664,92.690 1.518,92.690',
    ];

    // Lessons playing on the panel: animated whiteboard lessons (SVG) + classroom slides.
    $lessons = [
        ['key' => 'maths', 'src' => $lesson('lesson-maths.svg'), 'subject' => 'Mathematics', 'topic' => 'Pythagoras theorem', 'icon' => 'sigma', 'how' => 'The teacher draws the triangle, the squares appear and the proof writes itself, step by step.'],
        ['key' => 'science', 'src' => $lesson('lesson-science.svg'), 'subject' => 'Science', 'topic' => 'Our solar system', 'icon' => 'orbit', 'how' => 'Planets orbit live on the board while the teacher labels each one and adds notes.'],
        ['key' => 'biology', 'src' => $lesson('lesson-biology.svg'), 'subject' => 'Biology', 'topic' => 'Photosynthesis', 'icon' => 'leaf', 'how' => 'Sunlight, water and CO₂ flow into the leaf as arrows the teacher draws in colour.'],
        ['key' => 'chemistry', 'src' => $lesson('lesson-chemistry.svg'), 'subject' => 'Chemistry', 'topic' => 'The water molecule', 'icon' => 'flask-conical', 'how' => 'Atoms bond, the angle is marked and the periodic table pops up beside it.'],
        ['key' => 'english', 'src' => $lesson('slide-elearning.jpg'), 'subject' => 'English', 'topic' => 'Digital library', 'icon' => 'book-open', 'how' => 'Open any e-book, highlight passages together and share them with the class.'],
        ['key' => 'computing', 'src' => $lesson('slide-computing.jpg'), 'subject' => 'Computer science', 'topic' => 'Inside a processor', 'icon' => 'cpu', 'how' => 'Zoom into a chip in 4K and trace how every signal moves.'],
        ['key' => 'ai', 'src' => $lesson('slide-ai.jpg'), 'subject' => 'Technology', 'topic' => 'Introduction to AI', 'icon' => 'brain-circuit', 'how' => 'Explain how machines learn to see, with visuals the whole room can follow.'],
    ];

    $sizeScenes = [
        55 => ['stand' => 'elearning', 'wall' => 'maths'],
        65 => ['stand' => 'chemistry', 'wall' => 'science'],
        75 => ['stand' => 'maths', 'wall' => 'biology'],
        85 => ['stand' => 'science', 'wall' => 'computing'],
        100 => ['stand' => 'ai', 'wall' => 'chemistry'],
    ];
    $idealFor = [
        55 => 'Primary classrooms & tuition rooms · up to 30 students',
        65 => 'Standard classrooms & smart labs · up to 40 students',
        75 => 'Large classrooms & seminar rooms · up to 60 students',
        85 => 'Lecture halls & teacher training · up to 80 students',
        100 => 'Auditoriums & lecture theatres · 100+ students',
    ];
@endphp

@section('content')

<div class="overflow-x-clip bg-[#070b18] text-white">

{{-- =========================================================
     HERO — a live lesson on the panel
========================================================= --}}
<section class="relative isolate overflow-hidden pb-16 pt-12 sm:pt-16">
    <div class="absolute inset-0 -z-10">
        <div class="about-grid absolute inset-0 opacity-40"></div>
        <div class="about-blob -left-40 top-10 h-[32rem] w-[32rem] bg-blue-700/50"></div>
        <div class="about-blob -right-32 bottom-0 h-[28rem] w-[28rem] bg-indigo-600/40 [animation-delay:-6s]"></div>
    </div>

    <div class="mx-auto grid max-w-[1500px] items-center gap-12 px-4 sm:px-6 lg:grid-cols-[0.9fr_1.1fr] lg:px-10">

        <div class="about-intro text-center lg:text-left">
            <p class="inline-flex items-center gap-3 rounded-full border border-sky-300/30 bg-sky-400/10 py-2 pl-3 pr-5 text-xs font-semibold uppercase tracking-[0.3em] text-sky-100 backdrop-blur">
                <img src="{{ asset('storage/products/centum/yara-logo-light.png') }}" alt="Yara" class="h-4 w-auto">
                <span class="h-3 w-px bg-white/25"></span>
                Smart Classrooms
            </p>
            <h1 class="mt-6 text-5xl font-bold leading-[1.03] sm:text-7xl">
                Every lesson,<br><span class="bg-gradient-to-r from-sky-300 via-cyan-200 to-indigo-300 bg-clip-text text-transparent">brought to life.</span>
            </h1>
            <p class="mx-auto mt-6 max-w-xl text-lg text-gray-300 sm:text-xl lg:mx-0">
                Yara Interactive Panels are made for teaching. Write and explain on a 4K touch board, show videos and simulations, and let students come up and solve it with you.
            </p>
            <div class="mt-9 flex flex-wrap justify-center gap-4 lg:justify-start">
                <a href="#lesson" class="inline-flex items-center gap-2 rounded-full bg-sky-500 px-7 py-4 text-sm font-semibold shadow-lg shadow-sky-900/40 transition hover:bg-sky-400">
                    Watch a lesson
                    <i data-lucide="play" class="h-4 w-4"></i>
                </a>
                <a href="{{ route('store.demo.create') }}" class="inline-flex items-center gap-2 rounded-full border border-white/20 px-7 py-4 text-sm font-semibold transition hover:bg-white/10">
                    <i data-lucide="calendar-check" class="h-4 w-4"></i>
                    Book a classroom demo
                </a>
            </div>
        </div>

        {{-- live panel on its stand --}}
        <div class="relative">
            <div class="absolute inset-[8%] rounded-full bg-sky-500/20 blur-[90px]"></div>
            <div class="relative mx-auto max-w-2xl" data-no-auto-reveal x-data="liveScreen({ count: {{ count($lessons) }}, interval: 9000 })">
                <img src="{{ $base('ifp-stand-maths.png') }}" alt="Yara Interactive Panel on a stand showing a maths lesson" class="relative block w-full select-none">
                <div class="vw-screen vw-plain" data-quad="{{ $quad['stand'] }}" data-aspect="1.7778">
                    @foreach ($lessons as $k => $l)
                        <img src="{{ $l['src'] }}" alt="" draggable="false" class="vw-slide" :class="i === {{ $k }} && 'is-on'"
                             @if (str_ends_with($l['src'], '.svg')) x-effect="i === {{ $k }} && ($el.src = @js($l['src']) + '?r=' + Date.now())" @endif>
                    @endforeach
                </div>
                <img src="{{ $base('ifp-stand-frame.png') }}" alt="" class="pointer-events-none absolute inset-0 z-10 h-full w-full">
            </div>

            @foreach ([
                ['pen-line', 'Write like on a board', 'left-0 top-[8%]', '0s'],
                ['hand', '20 fingers at once', 'right-0 top-[2%]', '-2s'],
                ['share-2', 'Save & share notes', 'left-[2%] top-[38%]', '-4s'],
                ['monitor', '4K UHD, anti-glare', 'right-[4%] top-[34%]', '-1s'],
            ] as [$icon, $text, $pos, $delay])
                <span class="cd-chip absolute {{ $pos }} z-20 hidden items-center gap-2 rounded-full border border-white/15 bg-[#0b1224]/80 px-4 py-2 text-xs font-semibold shadow-xl backdrop-blur-md sm:inline-flex" style="animation-delay: {{ $delay }}">
                    <i data-lucide="{{ $icon }}" class="h-4 w-4 text-sky-300"></i>
                    {{ $text }}
                </span>
            @endforeach
        </div>
    </div>

    {{-- numbers teachers care about --}}
    <div class="mx-auto mt-14 grid max-w-[1500px] grid-cols-2 gap-px overflow-hidden rounded-3xl bg-white/10 sm:mx-6 lg:mx-auto lg:grid-cols-4">
        @foreach ([
            ['20', 'point', 'Students can write together'],
            ['4K', 'UHD', 'Clear from the last bench'],
            ['0', 'PC needed', 'Android 14 with whiteboard built in'],
            ['55–100', 'inch', 'For every size of classroom'],
        ] as $k => [$big, $unit, $text])
            <div class="bg-[#070b18] p-6 text-center sm:p-8" data-reveal style="--reveal-delay: {{ $k * 110 }}ms">
                <p class="font-display text-4xl font-extrabold sm:text-5xl">{{ $big }}<span class="ml-1 text-base font-semibold text-sky-300">{{ $unit }}</span></p>
                <p class="mt-2 text-xs font-semibold uppercase tracking-[0.2em] text-gray-400">{{ $text }}</p>
            </div>
        @endforeach
    </div>
</section>


{{-- =========================================================
     STICKY BAR
========================================================= --}}
<div class="sticky top-[4.25rem] z-40 border-y border-white/10 bg-[#070b18]/85 backdrop-blur-xl">
    <div class="mx-auto flex max-w-[1500px] items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-10">
        <div class="min-w-0">
            <p class="truncate font-display text-base font-bold sm:text-lg">Yara Interactive Panels</p>
            <p class="hidden truncate text-xs text-gray-400 sm:block">For schools, colleges & coaching centres · 55" to 100"</p>
        </div>
        <nav class="hidden items-center gap-6 text-sm text-gray-300 md:flex">
            <a href="#lesson" class="transition hover:text-white">Live lesson</a>
            <a href="#teach" class="transition hover:text-white">How teachers use it</a>
            <a href="#sizes" class="transition hover:text-white">Sizes</a>
            <a href="#schools" class="transition hover:text-white">For schools</a>
            <a href="#features" class="transition hover:text-white">Features</a>
        </nav>
        <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="shrink-0 rounded-full bg-sky-500 px-5 py-2.5 text-sm font-semibold transition hover:bg-sky-400">Get a quote</a>
    </div>
</div>


{{-- =========================================================
     LIVE LESSON — pick a subject, watch it being explained
========================================================= --}}
<section id="lesson" class="scroll-mt-32 bg-[#f5f7fb] py-24 text-gray-900"
         x-data="liveScreen({ count: {{ count($lessons) }}, interval: 10000 })" data-no-auto-reveal>
    <div class="mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="mx-auto max-w-3xl text-center">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-sky-600">Live lesson</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Explain it once. <span class="text-sky-600">Every student gets it.</span></h2>
            <p class="mt-4 text-lg text-gray-600">Pick a subject and watch it being taught on a Yara panel: drawn, labelled and explained, just like in class.</p>
        </div>

        <div class="mt-10 flex flex-wrap justify-center gap-2">
            @foreach ($lessons as $k => $l)
                <button type="button" @click="i = {{ $k }}" class="inline-flex items-center gap-2 rounded-full px-5 py-2.5 text-sm font-semibold transition"
                        :class="i === {{ $k }} ? 'bg-gray-900 text-white shadow-lg' : 'bg-white text-gray-700 ring-1 ring-gray-200 hover:ring-gray-300'">
                    <i data-lucide="{{ $l['icon'] }}" class="h-4 w-4"></i>
                    {{ $l['subject'] }}
                </button>
            @endforeach
        </div>

        <div class="mt-12 grid items-center gap-12 lg:grid-cols-[1.5fr_1fr]">
            <div class="relative">
                <div class="absolute inset-x-[10%] bottom-0 h-16 rounded-[50%] bg-gray-900/20 blur-2xl"></div>
                <div class="relative" x-ref="host">
                    <img src="{{ $base('ifp-wall-maths.png') }}" alt="Yara Interactive Panel on the wall with a live lesson" class="block w-full select-none">
                    <div class="vw-screen vw-plain" data-quad="{{ $quad['wall'] }}" data-aspect="1.7778">
                        @foreach ($lessons as $k => $l)
                            <img src="{{ $l['src'] }}" alt="{{ $l['subject'] }} lesson on a Yara panel" draggable="false" class="vw-slide" :class="i === {{ $k }} && 'is-on'"
                                 @if (str_ends_with($l['src'], '.svg')) x-effect="i === {{ $k }} && ($el.src = @js($l['src']) + '?r=' + Date.now())" @endif>
                        @endforeach
                    </div>
                    <img src="{{ $base('ifp-wall-frame.png') }}" alt="" class="pointer-events-none absolute inset-0 z-10 h-full w-full">
                </div>
            </div>

            <div class="relative grid">
                @foreach ($lessons as $k => $l)
                    <div class="col-start-1 row-start-1 transition-all duration-500" :class="i === {{ $k }} ? 'opacity-100 translate-y-0' : 'pointer-events-none opacity-0 translate-y-4'"
                         @if ($k) style="opacity: 0" @endif :style="''">
                        <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-sky-500 to-indigo-600 text-white shadow-lg shadow-sky-600/30">
                            <i data-lucide="{{ $l['icon'] }}" class="h-7 w-7"></i>
                        </span>
                        <p class="mt-6 text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">{{ $l['subject'] }}</p>
                        <h3 class="mt-2 text-3xl font-bold sm:text-4xl">{{ $l['topic'] }}</h3>
                        <p class="mt-4 text-lg text-gray-600">{{ $l['how'] }}</p>
                    </div>
                @endforeach
                <div class="col-start-1 row-start-1 self-end pt-72">
                    <div class="flex gap-1.5">
                        @foreach ($lessons as $k => $l)
                            <span class="h-1.5 flex-1 overflow-hidden rounded-full bg-gray-200">
                                <span class="block h-full origin-left bg-sky-500" :class="i === {{ $k }} ? 'centum-thumb-progress [animation-duration:10s]' : (i > {{ $k }} ? '' : 'scale-x-0')"></span>
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- =========================================================
     HOW TEACHERS USE IT — a class in four moments
========================================================= --}}
<section id="teach" class="relative scroll-mt-32 overflow-hidden py-24">
    <div class="about-blob -right-24 top-1/4 h-96 w-96 bg-indigo-700/40"></div>
    <div class="relative mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">
        <div class="mx-auto max-w-3xl text-center" data-reveal>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-sky-300">How teachers use it</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">A whole class, <span class="bg-gradient-to-r from-sky-300 to-indigo-300 bg-clip-text text-transparent">in four moments.</span></h2>
        </div>

        <ol class="relative mt-16 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
            <span class="about-rail absolute left-[12%] right-[12%] top-8 hidden h-px bg-gradient-to-r from-sky-400 via-indigo-400 to-sky-400 xl:block" data-reveal></span>
            @foreach ([
                ['pen-line', 'Explain', 'Write, draw and annotate with the pen or a finger, over any app, video or PDF. Handwriting turns into neat text and shapes.'],
                ['clapperboard', 'Show', 'Play videos, 3D models and PhET science simulations in 4K. Split the screen to compare two things side by side.'],
                ['hand', 'Involve', 'Up to 20 students write on the board at the same time. Quizzes, group work and games keep everyone engaged.'],
                ['qr-code', 'Share', 'Save the whole lesson as a PDF and share it by QR code or email. Absent students never miss the notes.'],
            ] as $k => [$icon, $title, $text])
                <li class="relative rounded-3xl border border-white/10 bg-white/[0.04] p-7 text-center backdrop-blur transition duration-500 hover:-translate-y-1 hover:border-sky-400/40" data-reveal style="--reveal-delay: {{ $k * 140 }}ms">
                    <span class="relative z-10 mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-sky-500 to-indigo-600 shadow-lg shadow-sky-900/50">
                        <i data-lucide="{{ $icon }}" class="h-7 w-7"></i>
                    </span>
                    <p class="mt-5 text-xs font-semibold uppercase tracking-[0.25em] text-sky-300">Step {{ $k + 1 }}</p>
                    <h3 class="mt-1 text-2xl font-bold">{{ $title }}</h3>
                    <p class="mt-3 text-sm leading-6 text-gray-300">{{ $text }}</p>
                </li>
            @endforeach
        </ol>
    </div>
</section>


{{-- =========================================================
     SIZES — wall-mount or stand
========================================================= --}}
<section id="sizes" class="relative scroll-mt-32 overflow-hidden bg-[#0b1224] py-24" x-data="{ mount: 'wall' }">
    <div class="relative mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="flex flex-col items-center justify-between gap-6 text-center md:flex-row md:items-end md:text-left" data-reveal>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-sky-300">Choose by classroom</p>
                <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Five sizes. <span class="bg-gradient-to-r from-sky-300 to-indigo-300 bg-clip-text text-transparent">Every classroom.</span></h2>
            </div>
            <div class="inline-flex rounded-full border border-white/15 bg-white/5 p-1 text-sm font-semibold" role="group" aria-label="Mounting">
                <button type="button" @click="mount = 'wall'" class="inline-flex items-center gap-2 rounded-full px-5 py-2.5 transition"
                        :class="mount === 'wall' ? 'bg-white text-gray-900' : 'text-gray-300 hover:text-white'" :aria-pressed="mount === 'wall'">
                    <i data-lucide="panel-top" class="h-4 w-4"></i> Wall-mount
                </button>
                <button type="button" @click="mount = 'stand'" class="inline-flex items-center gap-2 rounded-full px-5 py-2.5 transition"
                        :class="mount === 'stand' ? 'bg-white text-gray-900' : 'text-gray-300 hover:text-white'" :aria-pressed="mount === 'stand'">
                    <i data-lucide="presentation" class="h-4 w-4"></i> Stand
                </button>
            </div>
        </div>

        <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
            @foreach ($products as $i => $product)
                @php
                    $inch = (int) preg_replace('/\D/', '', $product->sku);
                    $scene = $sizeScenes[$inch] ?? $sizeScenes[65];
                    $price = $product->sale_price ?: $product->price;
                @endphp
                <article class="group flex flex-col rounded-[2rem] border border-white/10 bg-white/[0.04] p-6 transition duration-500 hover:-translate-y-2 hover:border-sky-400/40"
                         data-reveal style="--reveal-delay: {{ $i * 120 }}ms">
                    <div class="relative grid h-64 place-items-center" data-no-auto-reveal>
                        <img src="{{ $base("ifp-wall-{$scene['wall']}.png") }}" alt="Yara {{ $label($inch) }} Interactive Panel, wall-mounted" loading="lazy"
                             class="col-start-1 row-start-1 w-full transition duration-500 group-hover:scale-[1.04]"
                             x-show="mount === 'wall'" x-transition.opacity.duration.500ms>
                        <img src="{{ $base("ifp-stand-{$scene['stand']}.png") }}" alt="Yara {{ $label($inch) }} Interactive Panel on a stand" loading="lazy"
                             class="col-start-1 row-start-1 h-64 w-auto transition duration-500 group-hover:scale-[1.04]"
                             x-show="mount === 'stand'" x-transition.opacity.duration.500ms x-cloak>
                    </div>
                    <p class="mt-6 font-display text-4xl font-extrabold">{{ $inch }}<span class="text-sky-400">"</span></p>
                    <p class="mt-1 text-xs font-semibold uppercase tracking-[0.2em] text-gray-400">4K Interactive Panel</p>
                    <p class="mt-3 text-sm leading-6 text-gray-300">{{ $idealFor[$inch] ?? $product->short_description }}</p>
                    <div class="mt-auto pt-5">
                        @if ($price > 0)
                            <p class="text-lg font-bold">₹{{ number_format($price) }}
                                @if ($product->sale_price && $product->price > $product->sale_price)
                                    <span class="ml-1 text-sm font-normal text-gray-500 line-through">₹{{ number_format($product->price) }}</span>
                                @endif
                            </p>
                        @endif
                        <div class="mt-4 flex gap-3">
                            <a href="{{ route('store.product', $product) }}" class="flex-1 rounded-full bg-white px-4 py-3 text-center text-sm font-semibold text-gray-900 transition hover:bg-sky-500 hover:text-white">View details</a>
                            <a href="{{ $wa("Hi Yara, I am interested in the {$label($inch)} Interactive Flat Panel for our school. Please share the price.") }}" target="_blank" rel="noopener noreferrer"
                               class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full border border-white/20 transition hover:border-sky-400 hover:bg-sky-500" aria-label="Enquire about the {{ $inch }} inch panel on WhatsApp">
                                <i data-lucide="message-circle" class="h-5 w-5"></i>
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>


{{-- =========================================================
     FOR SCHOOLS — who uses it, classroom photo, chalkboard vs Yara
========================================================= --}}
<section id="schools" class="scroll-mt-32 bg-white py-24 text-gray-900">
    <div class="mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="grid items-center gap-12 lg:grid-cols-2">
            <div data-reveal="left">
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-sky-600">Built for education</p>
                <h2 class="mt-3 text-4xl font-bold sm:text-5xl">From chalkboard <span class="text-sky-600">to smart board.</span></h2>
                <p class="mt-5 text-lg text-gray-600">Keep your classroom, upgrade the board. Teachers explain on one bright screen every desk can see, and students learn by doing.</p>
                <div class="mt-8 grid gap-3 sm:grid-cols-2">
                    @foreach ([
                        ['school', 'Schools', 'K-12 classrooms, smart labs'],
                        ['landmark', 'Colleges & universities', 'Lecture halls, seminars'],
                        ['book-open-check', 'Coaching centres', 'JEE, NEET & tuition batches'],
                        ['users', 'Teacher training', 'Staff rooms & workshops'],
                    ] as [$icon, $title, $text])
                        <div class="flex items-start gap-3 rounded-2xl bg-[#f5f7fb] p-4 ring-1 ring-gray-100">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-sky-100 text-sky-700"><i data-lucide="{{ $icon }}" class="h-5 w-5"></i></span>
                            <span><span class="block font-bold">{{ $title }}</span><span class="block text-sm text-gray-500">{{ $text }}</span></span>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="grid grid-cols-5 gap-4" data-reveal="right">
                <figure class="group col-span-3 overflow-hidden rounded-[2rem] ring-1 ring-gray-200">
                    <img src="{{ $base('ifp-classroom.jpg') }}" alt="Yara Interactive Panel in a classroom" loading="lazy" class="h-full w-full object-cover transition duration-[1200ms] group-hover:scale-105">
                </figure>
                <figure class="group col-span-2 overflow-hidden rounded-[2rem] ring-1 ring-gray-200">
                    <img src="{{ $base('students.jpg') }}" alt="Students learning with technology" loading="lazy" class="h-full w-full object-cover transition duration-[1200ms] group-hover:scale-105">
                </figure>
            </div>
        </div>

        <div class="mx-auto mt-20 max-w-5xl overflow-hidden rounded-3xl ring-1 ring-gray-200" data-reveal>
            <div class="grid grid-cols-3 bg-gray-950 text-sm font-semibold text-white">
                <div class="p-4 sm:p-5"></div>
                <div class="p-4 text-center text-gray-400 sm:p-5">Chalkboard</div>
                <div class="bg-sky-600 p-4 text-center sm:p-5">Yara Interactive Panel</div>
            </div>
            @foreach ([
                ['Explaining a concept', 'Chalk & hand-drawn charts', 'Videos, 3D models & simulations'],
                ['Student participation', 'One at a time', 'Up to 20 at once'],
                ['After the class', 'Wiped away', 'Saved as PDF, shared by QR'],
                ['Health', 'Chalk dust every day', 'Dust-free, eye-protective screen'],
                ['Back benches', 'Hard to see', '4K, anti-glare, 178° view'],
            ] as $row)
                <div class="grid grid-cols-3 border-t border-gray-100 text-sm">
                    <div class="p-4 font-semibold sm:p-5">{{ $row[0] }}</div>
                    <div class="p-4 text-center text-gray-500 sm:p-5">{{ $row[1] }}</div>
                    <div class="flex items-center justify-center gap-2 bg-sky-50/70 p-4 text-center font-semibold sm:p-5">
                        <i data-lucide="circle-check" class="hidden h-4 w-4 shrink-0 text-sky-600 sm:block"></i>{{ $row[2] }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>


{{-- =========================================================
     FEATURES
========================================================= --}}
<section id="features" class="scroll-mt-32 bg-[#f5f7fb] py-24 text-gray-900">
    <div class="mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">
        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-sky-600">Teacher's toolkit</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Everything a teacher needs. <span class="text-sky-600">Built in.</span></h2>
        </div>
        <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($products->first()->features as $feature)
                <div class="group rounded-3xl bg-white p-7 shadow-sm ring-1 ring-gray-200 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:ring-sky-200">
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-sky-500 to-indigo-600 text-white shadow-lg shadow-sky-600/30 transition group-hover:-rotate-6">
                        <i data-lucide="{{ $feature->icon }}" class="h-6 w-6"></i>
                    </span>
                    <h3 class="mt-5 text-lg font-bold">{{ $feature->title }}</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-600">{{ $feature->description }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>


{{-- =========================================================
     CTA
========================================================= --}}
<section class="relative overflow-hidden py-28 text-center">
    <div class="about-grid absolute inset-0 opacity-40"></div>
    <div class="about-blob left-1/2 top-0 h-96 w-96 -translate-x-1/2 bg-blue-700/50"></div>
    <div class="relative mx-auto max-w-3xl px-4" data-reveal>
        <h2 class="text-4xl font-bold sm:text-6xl">Make every class <span class="bg-gradient-to-r from-sky-300 to-indigo-300 bg-clip-text text-transparent">unforgettable.</span></h2>
        <p class="mx-auto mt-5 max-w-xl text-lg text-gray-300">Tell us about your classrooms. We'll recommend sizes and mounting, install the panels and train your teachers, with a 3-year warranty.</p>
        <div class="mt-10 flex flex-wrap justify-center gap-4">
            <a href="{{ route('store.demo.create') }}" class="inline-flex items-center gap-2 rounded-full bg-sky-500 px-7 py-4 text-sm font-semibold transition hover:bg-sky-400">
                <i data-lucide="calendar-check" class="h-4 w-4"></i> Book a classroom demo
            </a>
            <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full border border-white/20 px-7 py-4 text-sm font-semibold transition hover:bg-white/10">
                <i data-lucide="message-circle" class="h-4 w-4"></i> Enquire on WhatsApp
            </a>
        </div>
    </div>
</section>

</div>

@endsection
