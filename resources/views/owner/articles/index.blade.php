@extends('layouts.owner')

@section('title', 'Pusat Edukasi')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800 tracking-tight">Pusat Edukasi UMKM</h2>
        <p class="text-slate-500 mt-2 text-lg">Temukan tips, trik, dan informasi terbaru untuk mengembangkan bisnis Anda.</p>
    </div>

    @if($articles->isEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-12 text-center">
            <div class="w-16 h-16 bg-indigo-50 text-indigo-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="book-open" class="w-8 h-8"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-700 mb-1">Belum Ada Artikel</h3>
            <p class="text-slate-500">Saat ini belum ada artikel yang diterbitkan. Silakan periksa kembali nanti.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($articles as $article)
                <a href="{{ route('owner.articles.show', $article) }}" class="group bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
                    @if($article->thumbnail)
                        <div class="aspect-video w-full overflow-hidden bg-slate-100">
                            <img src="{{ Storage::url($article->thumbnail) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                    @else
                        <div class="aspect-video w-full bg-gradient-to-br from-indigo-50 to-purple-50 flex items-center justify-center border-b border-slate-100">
                            <i data-lucide="image" class="w-10 h-10 text-indigo-200"></i>
                        </div>
                    @endif
                    
                    <div class="p-5 flex-1 flex flex-col">
                        <div class="flex items-center gap-2 text-xs text-slate-400 mb-3">
                            <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                            {{ $article->created_at->format('d M Y') }}
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 leading-snug group-hover:text-indigo-600 transition-colors mb-2 line-clamp-2">
                            {{ $article->title }}
                        </h3>
                        <p class="text-sm text-slate-500 line-clamp-3 mb-4 flex-1">
                            {{ strip_tags($article->content) }}
                        </p>
                        
                        <div class="pt-4 border-t border-slate-50 mt-auto flex items-center justify-between">
                            <span class="text-xs font-medium text-slate-500 flex items-center gap-1.5">
                                <i data-lucide="user" class="w-3.5 h-3.5"></i>
                                {{ $article->author->name ?? 'Admin' }}
                            </span>
                            <span class="text-sm font-semibold text-indigo-600 flex items-center gap-1 group-hover:gap-2 transition-all">
                                Baca <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        @if($articles->hasPages())
            <div class="mt-8">
                {{ $articles->links() }}
            </div>
        @endif
    @endif
</div>
@endsection
