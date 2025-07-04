<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sales Order #{{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #000;
            font-size: 14px;
            margin: 40px;
        }

        .header,
        .section {
            width: 100%;
            margin-bottom: 35px;
            overflow: hidden;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 5px;
        }

        .header .left,
        .header .right {
            width: 49%;
            display: inline-block;
            vertical-align: top;
        }

        .section-title {
            font-weight: bold;
            font-size: 16px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 6px;
            margin-bottom: 14px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 6px 8px;
            vertical-align: top;
        }

        .info-table td.label {
            width: 35%;
            font-weight: bold;
            text-align: right;
            padding-right: 12px;
            white-space: nowrap;
        }

        .info-table td.value {
            width: 65%;
            text-align: left;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        .items-table th,
        .items-table td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }

        .items-table th {
            background-color: #333;
            color: #fff;
        }

        .totals {
            margin-top: 25px;
            width: 40%;
            float: right;
        }

        .totals td {
            padding: 8px 12px;
        }

        .totals td:last-child {
            text-align: right;
        }

        .ship-to {
            float: left;
            width: 49%;
            text-align: left;
        }

        .sold-to {
            float: right;
            width: 49%;
            text-align: right;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="left">
            <h1>Sanita</h1>
            <table class="info-table">
                <tr>
                    <td class="label">Address:</td>
                    <td class="value">Iraq - Erbil</td>
                </tr>
                <tr>
                    <td class="label">Postal Code:</td>
                    <td class="value">112354</td>
                </tr>
                <tr>
                    <td class="label">Phone:</td>
                    <td class="value">+964 7 73 466 5969</td>
                </tr>
                <tr>
                    <td class="label">Fax:</td>
                    <td class="value">+964 7 73 466 5969</td>
                </tr>
            </table>
        </div>
        <div class="right" style="text-align: right;">
            <h1>SALES ORDER</h1>
            <table class="info-table" style="float: right;">
                <tr>
                    <td class="label">Print Date:</td>
                    <td class="value">{{ now()->format('d M Y') }}</td>
                </tr>
                <tr>
                    <td class="label">Order #:</td>
                    <td class="value">{{ $order->id }}</td>
                </tr>
                <tr>
                    <td class="label">Payment Status:</td>
                    <td class="value">{{ $order->payment_method ?? 'NOT PAID (COD)' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="section">
        @php $address = $order->customer->addresses->first(); @endphp

        <div class="ship-to">
            <div class="section-title">SHIP TO</div>
            <table class="info-table">
                <tr>
                    <td class="label">Governorate:</td>
                    <td class="value">{{ $address?->governorate?->name_en ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">District:</td>
                    <td class="value">{{ $address?->district?->name_en ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">City:</td>
                    <td class="value">{{ $address?->city?->name_en ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">Details:</td>
                    <td class="value">
                        {{
                            ($address?->street ? 'Street - ' . $address->street . ' ' : '') .
                            ($address?->building ? 'Building - ' . $address->building . ' ' : '') .
                            ($address?->floor ? 'Floor - ' . $address->floor : '') ?: 'N/A'
                        }}
                    </td>
                </tr>
                <tr>
                    <td class="label">Full Name:</td>
                    <td class="value">{{ $order->customer->first_name }}</td>
                </tr>
                <tr>
                    <td class="label">Phone:</td>
                    <td class="value">{{ $order->customer->mobile }}</td>
                </tr>
                <tr>
                    <td class="label">Email:</td>
                    <td class="value">{{ $order->customer->email }}</td>
                </tr>
            </table>
        </div>

        <div class="sold-to">
            <div class="section-title">SOLD TO</div>
            <table class="info-table">
                <tr>
                    <td class="label">Governorate:</td>
                    <td class="value">{{ $address?->governorate?->name_en ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">District:</td>
                    <td class="value">{{ $address?->district?->name_en ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">City:</td>
                    <td class="value">{{ $address?->city?->name_en ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">Details:</td>
                    <td class="value">
                        {{
                            ($address?->street ? 'Street - ' . $address->street . ' ' : '') .
                            ($address?->building ? 'Building - ' . $address->building . ' ' : '') .
                            ($address?->floor ? 'Floor - ' . $address->floor : '') ?: 'N/A'
                        }}
                    </td>
                </tr>
                <tr>
                    <td class="label">Full Name:</td>
                    <td class="value">{{ $order->customer->first_name }}</td>
                </tr>
                <tr>
                    <td class="label">Phone:</td>
                    <td class="value">{{ $order->customer->mobile }}</td>
                </tr>
                <tr>
                    <td class="label">Email:</td>
                    <td class="value">{{ $order->customer->email }}</td>
                </tr>
            </table>
        </div>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th>CODE</th>
                <th>ITEM DESCRIPTION</th>
                <th>QTY</th>
                <th>Unit Of Measure</th>
                <th>UNIT PRICE</th>
                <th>TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderDetails as $item)
            <tr>
                <td>{{ $item->product->sku }}</td>
                <td>{{ $item->product->name_en }}</td>
                <td>{{ $item->quantity_foreign }}</td>
                <td>{{ $item->UOM }}</td>
                <td>{{ number_format($item->shelf_price, 2) }}</td>
                <td>{{ number_format($item->extended_price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals">
        <tr>
            <td><strong>Total</strong></td>
            <td><strong>IQD</strong></td>
            <td><strong>{{ number_format($order->total_amount, 2) }}</strong></td>
        </tr>
    </table>

</body>

</html>