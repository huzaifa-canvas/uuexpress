<table style="width:100%;border-collapse:collapse;margin:12px 0;">
    <thead>
        <tr style="text-align:left;border-bottom:2px solid #e5e7eb;">
            <th style="padding:8px 6px;">Item</th>
            <th style="padding:8px 6px;text-align:center;">Qty</th>
            <th style="padding:8px 6px;text-align:right;">Price</th>
            <th style="padding:8px 6px;text-align:right;">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->items as $item)
        <tr style="border-bottom:1px solid #eee;">
            <td style="padding:8px 6px;">{{ $item->name }}</td>
            <td style="padding:8px 6px;text-align:center;">{{ $item->quantity }}</td>
            <td style="padding:8px 6px;text-align:right;">${{ number_format($item->price, 2) }}</td>
            <td style="padding:8px 6px;text-align:right;">${{ number_format($item->line_total, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" style="padding:10px 6px;text-align:right;font-weight:700;">Total</td>
            <td style="padding:10px 6px;text-align:right;font-weight:700;">${{ number_format($order->total, 2) }}</td>
        </tr>
    </tfoot>
</table>
