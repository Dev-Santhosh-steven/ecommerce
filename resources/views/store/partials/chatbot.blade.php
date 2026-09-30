{{--
    Website chatbot ("Yara Assistant").
    Answers come from Admin → Chatbot (knowledge base) and the product catalogue, via ChatbotService.
--}}
@php
    $chatbotSuggestions = app(\App\Services\ChatbotService::class)->suggestions();
    $chatbotWhatsapp = 'https://wa.me/' . config('services.chatbot.whatsapp');
@endphp

<script>
    window.yaraChatbot = function () {
        const STORAGE_KEY = 'yara-chatbot-v1';
        const WELCOME = {
            role: 'bot',
            text: "Hi there! 👋 I'm the Yara Assistant.\n\nAsk me about our TVs, interactive panels, LED video walls, prices, delivery, warranty or booking a demo.",
            links: [],
            products: [],
        };

        return {
            open: false,
            bubble: false,
            bubbleDismissed: false,
            typing: false,
            input: '',
            unread: 0,
            messages: [],
            suggestions: @json($chatbotSuggestions),
            timers: [],

            init() {
                try {
                    const saved = JSON.parse(sessionStorage.getItem(STORAGE_KEY) || 'null');
                    if (saved?.messages?.length) {
                        this.messages = saved.messages;
                        this.suggestions = saved.suggestions ?? this.suggestions;
                    }
                } catch (e) {}

                if (!this.messages.length) {
                    this.messages = [{ ...WELCOME, time: this.now() }];
                }

                // "Chat with us" popup: first appears 3s after the page loads,
                // then shows for 10s, hides for 3s, and repeats until the chat is opened.
                this.later(() => this.cycleBubble(), 3000);
            },

            cycleBubble() {
                if (this.open || this.bubbleDismissed) return;

                this.bubble = true;

                this.later(() => {
                    this.bubble = false;
                    this.later(() => this.cycleBubble(), 3000);
                }, 10000);
            },

            dismissBubble() {
                this.bubble = false;
                this.bubbleDismissed = true;
                this.clearTimers();
            },

            later(fn, ms) {
                this.timers.push(setTimeout(fn, ms));
            },

            clearTimers() {
                this.timers.forEach(clearTimeout);
                this.timers = [];
            },

            toggle() {
                this.open = !this.open;

                if (this.open) {
                    this.bubble = false;
                    this.unread = 0;
                    this.clearTimers();
                    this.$nextTick(() => {
                        this.scrollDown();
                        if (window.matchMedia('(min-width: 640px)').matches) this.$refs.input?.focus();
                    });
                }
            },

            async send(text = null) {
                const message = (text ?? this.input).trim();
                if (!message || this.typing) return;

                this.input = '';
                this.messages.push({ role: 'user', text: message, time: this.now() });
                this.typing = true;
                this.save();
                this.scrollDown();

                const started = Date.now();
                let reply;

                try {
                    const response = await fetch(@json(route('store.chatbot.message')), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify({ message }),
                    });

                    if (!response.ok) throw new Error(response.status);

                    reply = await response.json();
                } catch (e) {
                    reply = {
                        reply: "Sorry, I couldn't connect just now. Please try again, or reach our team directly.",
                        links: [{ label: 'Chat on WhatsApp', url: @json($chatbotWhatsapp) }],
                        products: [],
                    };
                }

                // Short, natural "typing…" pause.
                const wait = Math.max(0, 650 + Math.min(reply.reply.length * 4, 900) - (Date.now() - started));
                await new Promise((resolve) => setTimeout(resolve, wait));

                this.typing = false;
                this.messages.push({
                    role: 'bot',
                    text: reply.reply,
                    links: reply.links || [],
                    products: reply.products || [],
                    time: this.now(),
                });

                if (reply.suggestions?.length) this.suggestions = reply.suggestions;
                if (!this.open) this.unread++;

                this.save();
                this.scrollDown();
            },

            restart() {
                this.messages = [{ ...WELCOME, time: this.now() }];
                this.suggestions = @json($chatbotSuggestions);
                this.save();
            },

            save() {
                try {
                    sessionStorage.setItem(STORAGE_KEY, JSON.stringify({
                        messages: this.messages.slice(-40),
                        suggestions: this.suggestions,
                    }));
                } catch (e) {}
            },

            scrollDown() {
                this.$nextTick(() => {
                    const body = this.$refs.body;
                    if (body) body.scrollTo({ top: body.scrollHeight, behavior: 'smooth' });
                });
            },

            isExternal(url) {
                return /^(https?:)?\/\//.test(url) && !url.startsWith(window.location.origin);
            },

            now() {
                return new Date().toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });
            },
        };
    };
</script>


<div x-data="yaraChatbot()" @keydown.escape.window="open && toggle()" class="yara-chatbot">

    {{-- "Chat with us" popup --}}
    <div
        x-show="bubble && ! open"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-3 scale-90"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-3 scale-90"
        class="fixed bottom-[6.5rem] right-4 z-[60] w-64 origin-bottom-right sm:right-6"
    >
        <div class="relative rounded-2xl bg-white p-4 pr-9 shadow-2xl ring-1 ring-black/5">

            <button type="button" @click="dismissBubble()" class="absolute right-2 top-2 rounded-full p-1 text-gray-400 transition hover:bg-gray-100 hover:text-gray-600" aria-label="Close">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
            </button>

            <button type="button" @click="toggle()" class="flex items-start gap-3 text-left">

                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-brand-600 to-brand-red text-white">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8V4H8"/><rect width="16" height="12" x="4" y="8" rx="2"/><path d="M2 14h2M20 14h2M15 13v2M9 13v2"/></svg>
                </span>

                <span>
                    <span class="block font-bold text-gray-900">Chat with us 👋</span>
                    <span class="mt-0.5 block text-sm leading-5 text-gray-500">Hi! Ask me anything about our products.</span>
                </span>

            </button>

            <span class="absolute -bottom-2 right-7 h-4 w-4 rotate-45 bg-white ring-1 ring-black/5 [clip-path:polygon(100%_0,100%_100%,0_100%)]"></span>

        </div>
    </div>


    {{-- Chat window --}}
    <section
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-6 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-6 scale-95"
        class="fixed inset-x-3 bottom-[6.5rem] z-[60] flex h-[min(600px,calc(100dvh-8.5rem))] origin-bottom-right flex-col overflow-hidden rounded-3xl bg-white shadow-2xl ring-1 ring-black/10 sm:inset-x-auto sm:right-6 sm:w-[390px]"
        role="dialog"
        aria-label="Chat with Yara Assistant"
    >

        {{-- Header --}}
        <header class="relative flex items-center gap-3 overflow-hidden bg-gradient-to-br from-brand-700 via-brand-600 to-brand-red px-5 py-4 text-white">

            <span class="pointer-events-none absolute -right-8 -top-10 h-32 w-32 rounded-full bg-white/10"></span>

            <span class="relative flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-white/15 ring-2 ring-white/30">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8V4H8"/><rect width="16" height="12" x="4" y="8" rx="2"/><path d="M2 14h2M20 14h2M15 13v2M9 13v2"/></svg>
                <span class="absolute bottom-0 right-0 h-3 w-3 rounded-full bg-emerald-400 ring-2 ring-brand-600"></span>
            </span>

            <div class="relative min-w-0 flex-1">
                <p class="font-bold leading-tight">Yara Assistant</p>
                <p class="text-xs text-white/80">Online · replies instantly</p>
            </div>

            <button type="button" @click="restart()" class="relative rounded-full p-2 text-white/80 transition hover:bg-white/15 hover:text-white" title="Start a new chat" aria-label="Start a new chat">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
            </button>

            <button type="button" @click="toggle()" class="relative rounded-full p-2 text-white/80 transition hover:bg-white/15 hover:text-white" aria-label="Close chat">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="m6 9 6 6 6-6"/></svg>
            </button>

        </header>


        {{-- Messages --}}
        <div x-ref="body" class="flex-1 space-y-4 overflow-y-auto bg-gray-50 px-4 py-5" aria-live="polite">

            <template x-for="(msg, index) in messages" :key="index">

                <div :class="msg.role === 'user' ? 'flex justify-end' : 'flex items-end gap-2'" class="chatbot-msg">

                    {{-- Bot avatar --}}
                    <template x-if="msg.role === 'bot'">
                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-brand-600 to-brand-red text-white">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8V4H8"/><rect width="16" height="12" x="4" y="8" rx="2"/><path d="M2 14h2M20 14h2M15 13v2M9 13v2"/></svg>
                        </span>
                    </template>

                    <div :class="msg.role === 'user' ? 'max-w-[80%]' : 'min-w-0 max-w-[85%]'">

                        <div
                            :class="msg.role === 'user'
                                ? 'rounded-2xl rounded-br-md bg-brand-600 text-white'
                                : 'rounded-2xl rounded-bl-md bg-white text-gray-700 ring-1 ring-gray-200'"
                            class="whitespace-pre-line px-4 py-2.5 text-sm leading-6 shadow-sm"
                            x-text="msg.text"
                        ></div>

                        {{-- Product cards --}}
                        <template x-if="msg.products?.length">
                            <div class="mt-2 space-y-2">
                                <template x-for="product in msg.products" :key="product.url">
                                    <a :href="product.url" class="group flex items-center gap-3 rounded-xl bg-white p-2 pr-3 ring-1 ring-gray-200 transition hover:ring-brand-300 hover:shadow-md">
                                        <template x-if="product.image">
                                            <img :src="product.image" :alt="product.name" class="h-12 w-12 shrink-0 rounded-lg bg-gray-100 object-cover">
                                        </template>
                                        <template x-if="! product.image">
                                            <span class="h-12 w-12 shrink-0 rounded-lg bg-gray-100"></span>
                                        </template>
                                        <span class="min-w-0 flex-1">
                                            <span class="block truncate text-sm font-semibold text-gray-900 group-hover:text-brand-600" x-text="product.name"></span>
                                            <span class="block text-xs font-medium text-brand-600" x-text="product.price || 'View details'"></span>
                                        </span>
                                        <svg class="h-4 w-4 shrink-0 text-gray-400 transition group-hover:translate-x-0.5 group-hover:text-brand-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="m9 18 6-6-6-6"/></svg>
                                    </a>
                                </template>
                            </div>
                        </template>

                        {{-- Action buttons --}}
                        <template x-if="msg.links?.length">
                            <div class="mt-2 flex flex-wrap gap-2">
                                <template x-for="link in msg.links" :key="link.url">
                                    <a :href="link.url"
                                       :target="isExternal(link.url) ? '_blank' : null"
                                       :rel="isExternal(link.url) ? 'noopener noreferrer' : null"
                                       class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 px-3.5 py-1.5 text-xs font-semibold text-brand-700 ring-1 ring-brand-200 transition hover:bg-brand-600 hover:text-white">
                                        <span x-text="link.label"></span>
                                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                    </a>
                                </template>
                            </div>
                        </template>

                        <p :class="msg.role === 'user' ? 'text-right' : ''" class="mt-1 px-1 text-[10px] text-gray-400" x-text="msg.time"></p>

                    </div>

                </div>

            </template>


            {{-- Typing indicator --}}
            <div x-show="typing" x-cloak class="flex items-end gap-2">
                <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-brand-600 to-brand-red text-white">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8V4H8"/><rect width="16" height="12" x="4" y="8" rx="2"/><path d="M2 14h2M20 14h2M15 13v2M9 13v2"/></svg>
                </span>
                <div class="flex gap-1 rounded-2xl rounded-bl-md bg-white px-4 py-3.5 ring-1 ring-gray-200">
                    <span class="chatbot-dot h-2 w-2 rounded-full bg-gray-400"></span>
                    <span class="chatbot-dot h-2 w-2 rounded-full bg-gray-400 [animation-delay:150ms]"></span>
                    <span class="chatbot-dot h-2 w-2 rounded-full bg-gray-400 [animation-delay:300ms]"></span>
                </div>
            </div>

        </div>


        {{-- Quick replies --}}
        <div x-show="suggestions.length && ! typing" class="flex gap-2 overflow-x-auto border-t border-gray-100 bg-white px-4 pb-1 pt-3 [scrollbar-width:none]">
            <template x-for="suggestion in suggestions" :key="suggestion">
                <button type="button" @click="send(suggestion)"
                        class="shrink-0 rounded-full border border-brand-200 px-3.5 py-1.5 text-xs font-medium text-brand-700 transition hover:border-brand-600 hover:bg-brand-600 hover:text-white"
                        x-text="suggestion"></button>
            </template>
        </div>


        {{-- Input --}}
        <form @submit.prevent="send()" class="flex items-center gap-2 bg-white px-4 pb-3 pt-2">
            <input
                x-ref="input"
                x-model="input"
                type="text"
                maxlength="300"
                autocomplete="off"
                placeholder="Type your question…"
                class="min-w-0 flex-1 rounded-full border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm outline-none transition focus:border-brand-400 focus:bg-white focus:ring-2 focus:ring-brand-100"
                aria-label="Type your question"
            >
            <button
                type="submit"
                :disabled="! input.trim() || typing"
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-600 text-white shadow-md transition hover:bg-brand-700 disabled:cursor-not-allowed disabled:opacity-40"
                aria-label="Send"
            >
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z"/><path d="m21.854 2.147-10.94 10.939"/></svg>
            </button>
        </form>

        <p class="bg-white pb-3 text-center text-[11px] text-gray-400">
            Automated assistant ·
            <a href="{{ $chatbotWhatsapp }}" target="_blank" rel="noopener noreferrer" class="font-medium text-gray-500 underline-offset-2 hover:text-brand-600 hover:underline">Talk to a person</a>
        </p>

    </section>


    {{-- Robot launcher button --}}
    <button
        type="button"
        @click="toggle()"
        class="group fixed bottom-6 right-4 z-[60] flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-brand-600 to-brand-red text-white shadow-xl shadow-brand-900/30 transition duration-300 hover:scale-105 hover:shadow-2xl sm:right-6"
        :aria-label="open ? 'Close chat' : 'Open chat'"
        :aria-expanded="open"
    >
        <span x-show="! open" class="absolute inset-0 animate-ping rounded-full bg-brand-600 opacity-25"></span>

        {{-- Robot --}}
        <svg x-show="! open" class="chatbot-robot relative h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M12 8V4H8"/><rect width="16" height="12" x="4" y="8" rx="2"/><path d="M2 14h2M20 14h2M15 13v2M9 13v2"/>
        </svg>

        {{-- Close --}}
        <svg x-show="open" x-cloak class="relative h-7 w-7 rotate-0 transition-transform duration-300 group-hover:rotate-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
            <path d="M18 6 6 18M6 6l12 12"/>
        </svg>

        {{-- Online dot / unread badge --}}
        <span x-show="! open && ! unread" class="absolute right-1 top-1 h-3.5 w-3.5 rounded-full bg-emerald-400 ring-2 ring-white"></span>
        <span x-show="! open && unread" x-cloak class="absolute -right-0.5 -top-0.5 flex h-5 min-w-5 items-center justify-center rounded-full bg-white px-1 text-[11px] font-bold text-brand-700 shadow" x-text="unread"></span>
    </button>

</div>
