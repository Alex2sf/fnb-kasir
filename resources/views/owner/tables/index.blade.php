@extends('layouts.owner')
@section('title', 'Manajemen Meja')

@section('content')
<div x-data="{ showModal: false, editMode: false, tableId: '', number: '', status: 'available' }">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Manajemen Meja</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola data meja untuk pesanan dine-in.</p>
        </div>
        <button @click="showModal = true; editMode = false; number = ''; status = 'available'" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl font-medium flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i> Tambah Meja
        </button>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-600 p-4 rounded-xl mb-6 flex items-center gap-3 border border-emerald-100">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            <span class="font-medium text-sm">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
        @foreach($tables as $table)
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col items-center justify-center relative group">
            <div class="absolute top-2 right-2 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                <button @click="showModal = true; editMode = true; tableId = {{ $table->id }}; number = '{{ $table->number }}'; status = '{{ $table->status }}'" class="p-1.5 bg-amber-50 text-amber-600 rounded-lg hover:bg-amber-100">
                    <i data-lucide="edit" class="w-4 h-4"></i>
                </button>
                <form action="{{ route('owner.tables.destroy', $table) }}" method="POST" onsubmit="return confirm('Hapus meja ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="p-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>
            
            <div class="w-16 h-16 rounded-full flex items-center justify-center mb-3 {{ $table->status == 'available' ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 text-slate-500' }}">
                <i data-lucide="grid-2x2" class="w-8 h-8"></i>
            </div>
            <h3 class="text-xl font-black text-slate-800">{{ $table->number }}</h3>
            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider mt-2 {{ $table->status == 'available' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                {{ $table->status == 'available' ? 'Tersedia' : 'Terpakai' }}
            </span>
        </div>
        @endforeach
        
        @if($tables->isEmpty())
        <div class="col-span-full bg-white p-12 rounded-2xl border border-slate-200 text-center">
            <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="grid-2x2" class="w-8 h-8"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">Belum Ada Meja</h3>
            <p class="text-slate-500 text-sm">Tambahkan data meja untuk mempermudah pesanan dine-in.</p>
        </div>
        @endif
    </div>

    <!-- Modal -->
    <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="showModal" x-transition.opacity class="fixed inset-0 transition-opacity bg-slate-900/50 backdrop-blur-sm" @click="showModal = false"></div>

            <div x-show="showModal" x-transition class="relative inline-block w-full max-w-sm p-6 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-slate-800" x-text="editMode ? 'Edit Meja' : 'Tambah Meja Baru'"></h3>
                    <button @click="showModal = false" class="text-slate-400 hover:text-slate-600"><i data-lucide="x" class="w-5 h-5"></i></button>
                </div>

                <form :action="editMode ? '{{ url('owner/tables') }}/' + tableId : '{{ route('owner.tables.store') }}'" method="POST">
                    @csrf
                    <template x-if="editMode">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nomor/Nama Meja</label>
                            <input type="text" name="number" x-model="number" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500" placeholder="Contoh: 01 atau VIP-1">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Status</label>
                            <select name="status" x-model="status" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500">
                                <option value="available">Tersedia</option>
                                <option value="occupied">Terpakai</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" @click="showModal = false" class="px-4 py-2.5 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl">Batal</button>
                        <button type="submit" class="px-4 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl" x-text="editMode ? 'Simpan' : 'Tambah'"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
