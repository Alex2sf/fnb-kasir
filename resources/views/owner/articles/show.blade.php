@extends('layouts.owner')

@section('title', $article->title)

@section('content')
<div class="max-w-4xl mx-auto pb-12">
    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-sm text-slate-500 mb-6">
        <a href="{{ route('owner.dashboard') }}" class="hover:text-indigo-600 transition-colors">Dashboard</a>
        <i data-lucide="chevron-right" class="w-4 h-4"></i>
        <a href="{{ route('owner.articles.index') }}" class="hover:text-indigo-600 transition-colors">Pusat Edukasi</a>
        <i data-lucide="chevron-right" class="w-4 h-4"></i>
        <span class="text-slate-800 font-medium truncate max-w-[200px] sm:max-w-xs">{{ $article->title }}</span>
    </nav>

    <article class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        @if($article->thumbnail)
            <div class="w-full aspect-[21/9] bg-slate-100 border-b border-slate-100 relative">
                <img src="{{ Storage::url($article->thumbnail) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
            </div>
        @endif

        <div class="p-6 sm:p-10 lg:p-12">
            <header class="mb-8 pb-8 border-b border-slate-100">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight mb-6">
                    {{ $article->title }}
                </h1>
                
                <div class="flex flex-wrap items-center gap-6 text-sm text-slate-500">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center font-bold shadow-md">
                            {{ strtoupper(substr($article->author->name ?? 'A', 0, 1)) }}
                        </div>
                        <span class="font-medium text-slate-700">{{ $article->author->name ?? 'Admin WarungGalih' }}</span>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <i data-lucide="calendar" class="w-4 h-4"></i>
                        {{ $article->created_at->format('d M Y, H:i') }}
                    </div>
                </div>
            </header>

            <div class="prose prose-slate prose-lg max-w-none prose-img:rounded-xl prose-img:shadow-sm prose-a:text-indigo-600 hover:prose-a:text-indigo-500 prose-headings:text-slate-800 prose-headings:font-bold">
                {!! $article->content !!}
            </div>
        </div>
    </article>

    <div class="mt-8 flex justify-center">
        <a href="{{ route('owner.articles.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white border border-slate-200 rounded-full text-slate-600 hover:text-indigo-600 hover:border-indigo-200 hover:bg-indigo-50 transition-all shadow-sm hover:shadow font-medium">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali ke Pusat Edukasi
        </a>
    </div>
</div>

<style>
    /* Styling tambahan untuk Trix Content */
    .prose blockquote { border-left-color: #6366f1; background-color: #f8fafc; padding: 1rem; font-style: italic; border-radius: 0 0.5rem 0.5rem 0; }
    .prose ul > li::marker { color: #6366f1; }
    .prose ol > li::marker { color: #6366f1; font-weight: 600; }
</style>
@endsection
