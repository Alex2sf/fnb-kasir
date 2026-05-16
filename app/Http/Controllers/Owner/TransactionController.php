<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;
        $transactions = Transaction::with('customer', 'user')->where('store_id', $store->id)->latest()->paginate(15);
        return view('owner.transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        if($transaction->store_id !== auth()->user()->store->id) abort(403);
        $transaction->load('items.product', 'customer', 'user');
        return view('owner.transactions.show', compact('transaction'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'customer_id' => 'nullable|exists:customers,id',
            'table_id' => 'nullable|exists:tables,id',
            'discount_id' => 'nullable|exists:discounts,id',
            'payment_method' => 'required|string|in:cash,qris,transfer',
            'amount_paid' => 'required|numeric|min:0'
        ]);

        $store = auth()->user()->store;
        
        DB::beginTransaction();
        try {
            $subtotal = 0;
            foreach ($request->items as $item) {
                $subtotal += ($item['price'] * $item['quantity']);
            }

            $discountAmount = 0;
            if ($request->discount_id) {
                $discount = \App\Models\Discount::find($request->discount_id);
                if ($discount && $discount->store_id === $store->id) {
                    if ($discount->type === 'percentage') {
                        $discountAmount = $subtotal * ($discount->value / 100);
                    } else {
                        $discountAmount = $discount->value;
                    }
                }
            }

            $tax = 0; // round(($subtotal - $discountAmount) * 0.11);
            $grandTotal = $subtotal - $discountAmount + $tax;
            
            if ($request->amount_paid < $grandTotal && $request->payment_method === 'cash') {
                return response()->json(['success' => false, 'message' => 'Uang pembayaran kurang dari total tagihan.'], 400);
            }

            $changeAmount = $request->payment_method === 'cash' ? ($request->amount_paid - $grandTotal) : 0;
            $receiptNumber = 'INV-' . date('Ymd') . '-' . rand(1000, 9999);

            $transaction = Transaction::create([
                'store_id' => $store->id,
                'user_id' => auth()->id(),
                'customer_id' => $request->customer_id,
                'table_id' => $request->table_id,
                'discount_id' => $request->discount_id,
                'receipt_number' => $receiptNumber,
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'tax_amount' => $tax,
                'grand_total' => $grandTotal,
                'payment_method' => $request->payment_method,
                'paid_amount' => $request->payment_method === 'cash' ? $request->amount_paid : $grandTotal,
                'change_amount' => $changeAmount,
            ]);

            if ($request->table_id) {
                \App\Models\Table::where('id', $request->table_id)->update(['status' => 'occupied']);
            }

            foreach ($request->items as $item) {
                $product = Product::find($item['id']);
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'],
                    'toppings' => isset($item['toppings']) && is_array($item['toppings']) ? array_values($item['toppings']) : null,
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true, 
                'message' => 'Transaksi berhasil!', 
                'transaction_id' => $transaction->id,
                'print_url' => route('owner.transactions.print', $transaction->id),
                'redirect' => route('owner.pos')
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()], 500);
        }
    }

    public function export()
    {
        $transactions = Transaction::where('store_id', auth()->user()->store->id)
            ->with(['customer', 'user'])
            ->latest()
            ->get();

        $filename = "Laporan_Transaksi_" . auth()->user()->store->name . "_" . date('Y-m-d_H-i') . ".csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['No. Resi', 'Tanggal', 'Kasir', 'Pelanggan', 'Metode Pembayaran', 'Total Tagihan', 'Uang Diterima', 'Kembalian'];

        $callback = function() use($transactions, $columns) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF"); // UTF-8 BOM
            fputcsv($file, $columns);

            foreach ($transactions as $trx) {
                fputcsv($file, [
                    $trx->receipt_number,
                    $trx->created_at->format('Y-m-d H:i:s'),
                    $trx->user->name,
                    $trx->customer ? $trx->customer->name : 'Umum',
                    strtoupper($trx->payment_method),
                    $trx->grand_total,
                    $trx->paid_amount,
                    $trx->change_amount
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }


    public function print(Transaction $transaction)
    {
        if ($transaction->store_id !== auth()->user()->store->id) {
            abort(403);
        }
        
        return view('owner.transactions.print', compact('transaction'));
    }
}
