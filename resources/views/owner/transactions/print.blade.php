<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk {{ $transaction->receipt_number }}</title>
    <style>
        @page { margin: 0; }
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            line-height: 1.2;
            width: 58mm;
            margin: 0 auto;
            padding: 5mm;
            color: #000;
            background: #fff;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .divider { border-top: 1px dashed #000; margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 2px 0; }
        .mt-2 { margin-top: 10px; }
        .mb-2 { margin-bottom: 10px; }
    </style>
</head>
<body onload="window.print()">
    <div class="text-center mb-2">
        <h2 style="margin:0; font-size: 16px;">{{ $transaction->store->name }}</h2>
        @if($transaction->store->address)
            <p style="margin: 3px 0 0; font-size: 10px;">{{ $transaction->store->address }}</p>
        @endif
        @if($transaction->store->phone)
            <p style="margin: 3px 0 0; font-size: 10px;">Telp: {{ $transaction->store->phone }}</p>
        @endif
    </div>
    
    <div class="divider"></div>
    
    <table width="100%">
        <tr>
            <td>No: {{ $transaction->receipt_number }}</td>
        </tr>
        <tr>
            <td>Tgl: {{ $transaction->created_at->format('d/m/y H:i') }}</td>
        </tr>
        <tr>
            <td>Kasir: {{ $transaction->user->name }}</td>
        </tr>
        @if($transaction->table_id)
        <tr>
            <td class="font-bold">Meja: {{ $transaction->table->number }}</td>
        </tr>
        @endif
    </table>
    
    <div class="divider"></div>
    
    <table width="100%">
        @foreach($transaction->items as $item)
        <tr>
            <td colspan="3">{{ $item->product_name }}</td>
        </tr>
        <tr>
            <td width="30%">{{ $item->quantity }}x</td>
            <td width="30%">{{ number_format($item->price, 0, ',', '.') }}</td>
            <td width="40%" class="text-right">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </table>
    
    <div class="divider"></div>
    
    <table width="100%">
        <tr>
            <td>Subtotal</td>
            <td class="text-right">{{ number_format($transaction->subtotal, 0, ',', '.') }}</td>
        </tr>
        @if($transaction->discount_amount > 0)
        <tr>
            <td>Diskon</td>
            <td class="text-right">-{{ number_format($transaction->discount_amount, 0, ',', '.') }}</td>
        </tr>
        @endif
        @if($transaction->tax_amount > 0)
        <tr>
            <td>Pajak</td>
            <td class="text-right">{{ number_format($transaction->tax_amount, 0, ',', '.') }}</td>
        </tr>
        @endif
        <tr>
            <td class="font-bold" style="font-size: 14px;">TOTAL</td>
            <td class="text-right font-bold" style="font-size: 14px;">{{ number_format($transaction->grand_total, 0, ',', '.') }}</td>
        </tr>
    </table>
    
    <div class="divider"></div>
    
    <table width="100%">
        <tr>
            <td>Bayar ({{ strtoupper($transaction->payment_method) }})</td>
            <td class="text-right">{{ number_format($transaction->paid_amount, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Kembali</td>
            <td class="text-right">{{ number_format($transaction->change_amount, 0, ',', '.') }}</td>
        </tr>
    </table>
    
    <div class="divider mt-2"></div>
    <div class="text-center mt-2 mb-2" style="font-size: 10px;">
        Terima kasih atas kunjungan Anda!
    </div>
</body>
</html>
