@extends('layouts.admin')

@section('title', 'Edit Artikel')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.articles.index') }}" class="p-2 bg-slate-800 text-slate-400 hover:text-white hover:bg-slate-700 rounded-lg transition-colors">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <h2 class="text-2xl font-bold text-slate-100">Edit Artikel</h2>
    </div>

    <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data" class="bg-slate-900 border border-slate-800 rounded-xl p-6 shadow-sm space-y-6">
        @csrf
        @method('PUT')
        
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-2">Judul Artikel</label>
            <input type="text" name="title" value="{{ old('title', $article->title) }}" required class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-2.5 text-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            @error('title')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-300 mb-2">Gambar Sampul (Opsional)</label>
            @if($article->thumbnail)
                <div class="mb-3">
                    <img src="{{ Storage::url($article->thumbnail) }}" alt="Thumbnail" class="h-32 rounded-lg object-cover">
                </div>
            @endif
            <input type="file" name="thumbnail" accept="image/*" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-2 text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-500/10 file:text-indigo-400 hover:file:bg-indigo-500/20">
            <p class="text-xs text-slate-500 mt-2">Biarkan kosong jika tidak ingin mengubah gambar.</p>
            @error('thumbnail')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-300 mb-2">Status</label>
            <select name="status" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-2.5 text-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="published" {{ $article->status == 'published' ? 'selected' : '' }}>Terbit (Published)</option>
                <option value="draft" {{ $article->status == 'draft' ? 'selected' : '' }}>Simpan sebagai Draft</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-300 mb-2">Isi Artikel</label>
            <input id="x" type="hidden" name="content" value="{{ old('content', $article->content) }}">
            <trix-editor input="x" class="bg-slate-950 border-slate-800 text-slate-200 rounded-lg min-h-[300px] prose prose-invert max-w-none"></trix-editor>
            @error('content')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
        </div>

        <div class="pt-4 flex justify-end">
            <button type="submit" class="px-6 py-2.5 bg-indigo-500 hover:bg-indigo-600 text-white font-medium rounded-lg transition-colors">
                Perbarui Artikel
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
<style>
    trix-toolbar [data-trix-button-group="file-tools"] { display: none; }
    .trix-button { background-color: #1e293b !important; border-color: #334155 !important; color: #cbd5e1 !important; }
    .trix-button.trix-active { background-color: #334155 !important; }
    .trix-button::before { filter: invert(1); }
</style>
@endpush
