@extends('layouts.admin')

@section('title', 'Manajemen Konten Edukasi')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-slate-100">Daftar Artikel</h2>
        <a href="{{ route('admin.articles.create') }}" class="px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white font-medium rounded-lg transition-colors flex items-center gap-2">
            <i data-lucide="plus" class="w-5 h-5"></i>
            Tulis Artikel
        </a>
    </div>

    @if(session('success'))
    <div class="p-4 bg-green-500/10 border border-green-500/20 text-green-400 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden shadow-sm">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-800/50 text-slate-400 border-b border-slate-800">
                <tr>
                    <th class="px-6 py-4 font-medium">Judul</th>
                    <th class="px-6 py-4 font-medium">Status</th>
                    <th class="px-6 py-4 font-medium">Tanggal</th>
                    <th class="px-6 py-4 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/50">
                @forelse($articles as $article)
                <tr class="hover:bg-slate-800/30 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-medium text-slate-200">{{ $article->title }}</div>
                        <div class="text-xs text-slate-500 mt-1">Oleh: {{ $article->author->name }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @if($article->status == 'published')
                        <span class="px-2.5 py-1 text-xs font-medium bg-green-500/10 text-green-400 border border-green-500/20 rounded-full">Terbit</span>
                        @else
                        <span class="px-2.5 py-1 text-xs font-medium bg-slate-500/10 text-slate-400 border border-slate-500/20 rounded-full">Draft</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-slate-400">
                        {{ $article->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.articles.edit', $article) }}" class="p-2 text-blue-400 hover:bg-blue-500/10 rounded-lg transition-colors">
                                <i data-lucide="edit" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-400 hover:bg-red-500/10 rounded-lg transition-colors">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                        Belum ada artikel yang ditulis.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($articles->hasPages())
        <div class="p-4 border-t border-slate-800">
            {{ $articles->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
