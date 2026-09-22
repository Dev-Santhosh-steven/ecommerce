@extends('admin.layouts.app')

@section('content')
    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold">{{ $product->name }}</h1>
                <p class="mt-2 text-slate-600">{{ $product->short_description }}</p>
            </div>
            <a href="{{ route('admin.products.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700">Back</a>
        </div>

        @if ($product->images->isNotEmpty())

            <div class="mt-8 grid grid-cols-3 gap-4 sm:grid-cols-4 md:grid-cols-6">

                @foreach ($product->images as $image)

                    <div class="relative overflow-hidden rounded-lg border border-slate-200">

                        <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $product->name }}" class="aspect-square w-full object-cover">

                        @if ($image->is_primary)

                            <span class="absolute left-1 top-1 rounded-full bg-slate-900 px-2 py-0.5 text-[10px] font-semibold text-white">
                                Primary
                            </span>

                        @endif

                    </div>

                @endforeach

            </div>

        @endif

        <div class="mt-8 grid gap-6 md:grid-cols-2">
            <div class="rounded-xl bg-slate-50 p-5">
                <p class="text-sm text-slate-500">Category</p>
                <p class="mt-2 font-medium">{{ $product->category?->name ?? '—' }}</p>
            </div>
            <div class="rounded-xl bg-slate-50 p-5">
                <p class="text-sm text-slate-500">SKU</p>
                <p class="mt-2 font-medium">{{ $product->sku }}</p>
            </div>
            <div class="rounded-xl bg-slate-50 p-5">
                <p class="text-sm text-slate-500">Price</p>
                <p class="mt-2 font-medium">₹{{ number_format($product->price, 2) }}</p>
            </div>
            <div class="rounded-xl bg-slate-50 p-5">
                <p class="text-sm text-slate-500">Status</p>
                <p class="mt-2 font-medium">{{ $product->status ? 'Active' : 'Inactive' }}</p>
            </div>
        </div>

        <div class="mt-8 rounded-xl bg-slate-50 p-5">
            <p class="text-sm text-slate-500">Description</p>
            <div class="mt-3 whitespace-pre-line text-slate-700">{{ $product->description }}</div>
        </div>
    </div>
@endsection
