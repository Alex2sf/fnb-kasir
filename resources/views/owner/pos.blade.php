@extends('layouts.owner')

@section('title', 'Point of Sale')

@section('content')
<div class="h-[calc(100vh-4rem)] -m-4 sm:-m-6 lg:-m-8 flex flex-col md:flex-row overflow-hidden bg-slate-50" x-data="posApp()">
    
    <!-- Mobile Cart Toggle -->
    <button @click="showCartMobile = !showCartMobile" class="md:hidden fixed bottom-6 right-6 z-50 w-14 h-14 bg-indigo-600 text-white rounded-full shadow-lg flex items-center justify-center">
        <i data-lucide="shopping-cart" class="w-6 h-6"></i>
        <span x-show="cartTotalItems > 0" class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 rounded-full text-[10px] font-bold flex items-center justify-center border-2 border-white" x-text="cartTotalItems"></span>
    </button>

    <!-- Left Panel: Products -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden border-r border-slate-200" x-show="!showCartMobile || window.innerWidth >= 768">
        <!-- Search & Filter -->
        <div class="p-4 bg-white border-b border-slate-200 z-10 shadow-sm flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="relative flex-1">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"></i>
                    <input type="text" x-model="searchQuery" placeholder="Cari nama produk..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                </div>
                <button class="p-2.5 bg-slate-50 border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-100 transition-colors">
                    <i data-lucide="barcode" class="w-5 h-5"></i>
                </button>
            </div>
            
            <!-- Category Pills -->
            <div class="mt-4 flex overflow-x-auto hide-scrollbar gap-2 pb-1">
                <button @click="activeCategory = 'all'" :class="{'bg-slate-800 text-white shadow-md': activeCategory === 'all', 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50': activeCategory !== 'all'}" class="px-4 py-1.5 rounded-full text-sm font-semibold whitespace-nowrap transition-all">
                    Semua
                </button>
                @foreach($categories as $category)
                <button @click="activeCategory = {{ $category->id }}" :class="{'bg-slate-800 text-white shadow-md': activeCategory === {{ $category->id }}, 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50': activeCategory !== {{ $category->id }}}" class="px-4 py-1.5 rounded-full text-sm font-semibold whitespace-nowrap transition-all">
                    {{ $category->name }}
                </button>
                @endforeach
            </div>
        </div>

        <!-- Product Grid -->
        <div class="flex-1 overflow-y-auto p-4 hide-scrollbar">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                @foreach($products as $product)
                <div x-show="matchesSearch('{{ strtolower($product->name) }}') && matchesCategory({{ $product->category_id ?? 'null' }})" 
                     class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-indigo-200 transition-all cursor-pointer overflow-hidden group flex flex-col h-full"
                     @click="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, '{{ $product->image ? Storage::url($product->image) : '' }}')">
                    
                    <div class="aspect-square bg-slate-50 relative overflow-hidden">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <i data-lucide="coffee" class="w-12 h-12 group-hover:scale-110 transition-transform duration-500"></i>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-indigo-900/0 group-hover:bg-indigo-900/5 transition-colors flex items-center justify-center">
                            <div class="w-10 h-10 bg-white/95 rounded-full flex items-center justify-center text-indigo-600 opacity-0 group-hover:opacity-100 transform scale-50 group-hover:scale-100 transition-all shadow-sm">
                                <i data-lucide="plus" class="w-5 h-5"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-3 flex-1 flex flex-col justify-between">
                        <div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">{{ $product->category->name ?? 'UMUM' }}</p>
                            <h3 class="font-bold text-slate-800 leading-tight text-sm">{{ $product->name }}</h3>
                        </div>
                        <p class="text-indigo-600 font-bold mt-2 text-sm">Rp <span x-text="formatMoney({{ $product->price }})"></span></p>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Empty State for Search -->
            <div x-show="!hasVisibleProducts()" class="flex flex-col items-center justify-center py-12 text-center" style="display: none;">
                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4 text-slate-400">
                    <i data-lucide="search-x" class="w-8 h-8"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-800">Produk tidak ditemukan</h3>
                <p class="text-slate-500 mt-1 text-sm">Coba gunakan kata kunci pencarian yang lain.</p>
            </div>
        </div>
    </div>

    <!-- Right Panel: Cart Sidebar -->
    <div class="w-full md:w-96 lg:w-[400px] bg-white flex flex-col flex-shrink-0 z-40 shadow-2xl md:shadow-none" :class="{'fixed inset-0 md:relative': showCartMobile, 'hidden md:flex': !showCartMobile}">
        
        <!-- Cart Header -->
        <div class="p-4 border-b border-slate-100 flex items-center justify-between bg-white flex-shrink-0">
            <div class="flex items-center gap-3">
                <button @click="showCartMobile = false" class="md:hidden text-slate-500 hover:text-slate-800">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
                <div>
                    <h2 class="font-bold text-lg text-slate-800">Detail Pesanan</h2>
                    <p class="text-xs font-medium text-slate-400" x-text="new Date().toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })"></p>
                </div>
            </div>
            <button @click="clearCart()" x-show="cart.length > 0" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Kosongkan">
                <i data-lucide="trash-2" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Customer Selection -->
        <div class="p-3 border-b border-slate-100 flex-shrink-0 bg-slate-50/50">
            <select x-model="customerId" class="w-full bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all p-2.5 text-sm text-slate-700 font-medium cursor-pointer">
                <option value="">Pelanggan Umum</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->phone ?? '-' }})</option>
                @endforeach
            </select>
        </div>

        <!-- Cart Items -->
        <div class="flex-1 overflow-y-auto p-4 hide-scrollbar bg-slate-50/30">
            <template x-if="cart.length === 0">
                <div class="h-full flex flex-col items-center justify-center text-center">
                    <div class="w-24 h-24 mb-4 opacity-20">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-full h-full text-slate-800">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                        </svg>
                    </div>
                    <p class="font-bold text-slate-600">Keranjang masih kosong</p>
                    <p class="text-sm text-slate-400 mt-1">Pilih produk di area kiri untuk menambahkan pesanan.</p>
                </div>
            </template>

            <div class="space-y-3">
                <template x-for="(item, index) in cart" :key="item.id">
                    <div class="flex items-center gap-3 p-3 bg-white border border-slate-100 rounded-xl shadow-sm">
                        <div class="w-12 h-12 bg-slate-100 rounded-lg overflow-hidden flex-shrink-0">
                            <template x-if="item.image">
                                <img :src="item.image" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!item.image">
                                <div class="w-full h-full flex items-center justify-center text-slate-400">
                                    <i data-lucide="coffee" class="w-6 h-6"></i>
                                </div>
                            </template>
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-slate-800 text-sm truncate" x-text="item.name"></h4>
                            <p class="text-indigo-600 font-bold text-xs mt-0.5">Rp <span x-text="formatMoney(item.price)"></span></p>
                        </div>

                        <div class="flex items-center bg-slate-100 rounded-lg p-1 border border-slate-200 flex-shrink-0">
                            <button @click="decrement(index)" class="w-7 h-7 flex items-center justify-center bg-white rounded-md text-slate-600 hover:text-indigo-600 shadow-sm transition-colors">
                                <i data-lucide="minus" class="w-3 h-3"></i>
                            </button>
                            <span class="w-8 text-center font-bold text-sm text-slate-800" x-text="item.quantity"></span>
                            <button @click="increment(index)" class="w-7 h-7 flex items-center justify-center bg-white rounded-md text-slate-600 hover:text-indigo-600 shadow-sm transition-colors">
                                <i data-lucide="plus" class="w-3 h-3"></i>
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Checkout Section -->
        <div class="p-4 bg-white border-t border-slate-100 flex-shrink-0 z-10 shadow-[0_-10px_20px_-10px_rgba(0,0,0,0.05)]">
            <div class="space-y-3 mb-4 text-sm">
                <div class="flex justify-between text-slate-500">
                    <span>Subtotal</span>
                    <span class="font-medium text-slate-700">Rp <span x-text="formatMoney(subtotal())"></span></span>
                </div>
                <!-- Pajak dinonaktifkan
                <div class="flex justify-between text-slate-500">
                    <span>Pajak (11%)</span>
                    <span class="font-medium text-slate-700">Rp <span x-text="formatMoney(tax())"></span></span>
                </div>
                -->
                <div class="flex justify-between items-center pt-3 border-t border-slate-100 border-dashed">
                    <span class="font-bold text-slate-800 text-base">Total Tagihan</span>
                    <span class="font-black text-indigo-600 text-2xl">Rp <span x-text="formatMoney(grandTotal())"></span></span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2 mb-3">
                <button @click="paymentMethod = 'cash'" :class="{'bg-indigo-50 border-indigo-500 text-indigo-700': paymentMethod === 'cash', 'bg-white border-slate-200 text-slate-600 hover:bg-slate-50': paymentMethod !== 'cash'}" class="border rounded-lg py-2 text-sm font-semibold transition-colors">Tunai</button>
                <button @click="paymentMethod = 'qris'" :class="{'bg-indigo-50 border-indigo-500 text-indigo-700': paymentMethod === 'qris', 'bg-white border-slate-200 text-slate-600 hover:bg-slate-50': paymentMethod !== 'qris'}" class="border rounded-lg py-2 text-sm font-semibold transition-colors">QRIS</button>
            </div>

            <div x-show="paymentMethod === 'cash'" class="mb-4">
                <label class="block text-xs font-semibold text-slate-500 mb-1">Jumlah Uang Diterima (Rp)</label>
                <input type="number" x-model.number="amountPaid" class="w-full border border-slate-200 rounded-lg p-2 text-sm font-semibold focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <button @click="checkout()" :disabled="cart.length === 0 || isProcessing" 
                    :class="{'bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-200': cart.length > 0 && !isProcessing, 'bg-slate-200 text-slate-400 cursor-not-allowed': cart.length === 0 || isProcessing}" 
                    class="w-full py-3.5 rounded-xl text-white font-bold text-lg flex items-center justify-center gap-2 transition-all">
                <i data-lucide="credit-card" class="w-5 h-5" x-show="!isProcessing"></i>
                <i data-lucide="loader-2" class="w-5 h-5 animate-spin" x-show="isProcessing" style="display: none;"></i>
                <span x-text="isProcessing ? 'Memproses...' : 'Proses Pembayaran'"></span>
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function posApp() {
        return {
            searchQuery: '',
            activeCategory: 'all',
            showCartMobile: false,
            cart: [],
            customerId: '',
            paymentMethod: 'cash',
            amountPaid: 0,
            isProcessing: false,
            
            formatMoney(amount) {
                return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            },
            
            matchesSearch(name) {
                if (this.searchQuery === '') return true;
                return name.includes(this.searchQuery.toLowerCase());
            },
            
            matchesCategory(categoryId) {
                if (this.activeCategory === 'all') return true;
                return this.activeCategory === categoryId;
            },
            
            hasVisibleProducts() {
                return true; 
            },
            
            addToCart(id, name, price, image) {
                const existing = this.cart.find(item => item.id === id);
                if (existing) {
                    existing.quantity++;
                } else {
                    this.cart.push({
                        id: id,
                        name: name,
                        price: price,
                        image: image,
                        quantity: 1
                    });
                }
                
                if (this.cart.length === 1 && this.amountPaid === 0) {
                    this.amountPaid = this.grandTotal();
                } else {
                    if(this.paymentMethod === 'cash') {
                       this.amountPaid = this.grandTotal();
                    }
                }
            },
            
            increment(index) {
                this.cart[index].quantity++;
                if(this.paymentMethod === 'cash') this.amountPaid = this.grandTotal();
            },
            
            decrement(index) {
                if (this.cart[index].quantity > 1) {
                    this.cart[index].quantity--;
                } else {
                    this.cart.splice(index, 1);
                }
                if(this.paymentMethod === 'cash') this.amountPaid = this.grandTotal();
            },
            
            clearCart() {
                if(confirm('Yakin ingin mengosongkan pesanan ini?')) {
                    this.cart = [];
                    this.amountPaid = 0;
                }
            },
            
            get cartTotalItems() {
                return this.cart.reduce((total, item) => total + item.quantity, 0);
            },
            
            subtotal() {
                return this.cart.reduce((total, item) => total + (item.price * item.quantity), 0);
            },
            
            tax() {
                return 0; // Pajak dinonaktifkan sementara
            },
            
            grandTotal() {
                return this.subtotal() + this.tax();
            },

            checkout() {
                if (this.cart.length === 0) return;
                
                const gTotal = this.grandTotal();
                if (this.paymentMethod === 'cash' && this.amountPaid < gTotal) {
                    alert('Nominal uang pembayaran tunai kurang dari total tagihan!');
                    return;
                }

                this.isProcessing = true;

                fetch('{{ route("owner.transactions.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        items: this.cart,
                        customer_id: this.customerId || null,
                        payment_method: this.paymentMethod,
                        amount_paid: this.paymentMethod === 'cash' ? this.amountPaid : gTotal
                    })
                })
                .then(async response => {
                    if (!response.ok && response.status === 422) {
                        const errData = await response.json();
                        throw new Error(errData.message || 'Validasi gagal, cek input Anda.');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        this.cart = [];
                        this.amountPaid = 0;
                        window.location.href = data.redirect;
                    } else {
                        alert(data.message || 'Gagal memproses transaksi.');
                        this.isProcessing = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.message || 'Terjadi kesalahan pada server saat memproses transaksi.');
                    this.isProcessing = false;
                });
            }
        }
    }
</script>
@endpush
