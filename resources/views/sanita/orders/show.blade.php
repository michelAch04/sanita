<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ __('order.sales_order') }} #{{ $order->id }}</title>
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
                    <td class="label">{{ __('order.address_label') }}:</td>
                    <td class="value">Iraq - Erbil</td>
                </tr>
                <tr>
                    <td class="label">{{ __('order.postal_code') }}:</td>
                    <td class="value">112354</td>
                </tr>
                <tr>
                    <td class="label">{{ __('order.phone_label') }}:</td>
                    <td class="value">+964 7 73 466 5969</td>
                </tr>
                <tr>
                    <td class="label">{{ __('order.fax_label') }}:</td>
                    <td class="value">+964 7 73 466 5969</td>
                </tr>
            </table>
        </div>
        <div class="right" style="text-align: right;">
            <h1>{{ __('order.sales_order') }}</h1>
            <table class="info-table" style="float: right;">
                <tr>
                    <td class="label">{{ __('order.print_date') }}:</td>
                    <td class="value">{{ now()->format('d M Y') }}</td>
                </tr>
                <tr>
                    <td class="label">{{ __('order.order_num') }}:</td>
                    <td class="value">{{ $order->id }}</td>
                </tr>
                <tr>
                    <td class="label">{{ __('order.payment_status') }}:</td>
                    <td class="value">{{ $order->payment_method ?? __('order.not_paid_cod') }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="section">
        @php $address = $order->customer->addresses->first(); @endphp

        <div class="ship-to">
            <div class="section-title">{{ __('order.ship_to') }}</div>
            <table class="info-table">
                <tr>
                    <td class="label">{{ __('address.Governorate') }}:</td>
                    <td class="value">{{ $address?->governorate?->name_en ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">{{ __('address.District') }}:</td>
                    <td class="value">{{ $address?->district?->name_en ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">{{ __('address.City') }}:</td>
                    <td class="value">{{ $address?->city?->name_en ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">{{ __('order.details') }}:</td>
                    <td class="value">
                        {{
                            ($address?->street ? __('order.street_prefix') . ' - ' . $address->street . ' ' : '') .
                            ($address?->building ? __('order.building_prefix') . ' - ' . $address->building . ' ' : '') .
                            ($address?->floor ? __('order.floor_prefix') . ' - ' . $address->floor : '') ?: 'N/A'
                        }}
                    </td>
                </tr>
                <tr>
                    <td class="label">{{ __('order.full_name') }}:</td>
                    <td class="value">{{ $order->customer->first_name }}</td>
                </tr>
                <tr>
                    <td class="label">{{ __('order.phone_label') }}:</td>
                    <td class="value">{{ $order->customer->mobile }}</td>
                </tr>
                <tr>
                    <td class="label">{{ __('order.email_label') }}:</td>
                    <td class="value">{{ $order->customer->email }}</td>
                </tr>
            </table>
        </div>

        <div class="sold-to">
            <div class="section-title">{{ __('order.sold_to') }}</div>
            <table class="info-table">
                <tr>
                    <td class="label">{{ __('address.Governorate') }}:</td>
                    <td class="value">{{ $address?->governorate?->name_en ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">{{ __('address.District') }}:</td>
                    <td class="value">{{ $address?->district?->name_en ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">{{ __('address.City') }}:</td>
                    <td class="value">{{ $address?->city?->name_en ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">{{ __('order.details') }}:</td>
                    <td class="value">
                        {{
                            ($address?->street ? __('order.street_prefix') . ' - ' . $address->street . ' ' : '') .
                            ($address?->building ? __('order.building_prefix') . ' - ' . $address->building . ' ' : '') .
                            ($address?->floor ? __('order.floor_prefix') . ' - ' . $address->floor : '') ?: 'N/A'
                        }}
                    </td>
                </tr>
                <tr>
                    <td class="label">{{ __('order.full_name') }}:</td>
                    <td class="value">{{ $order->customer->first_name }}</td>
                </tr>
                <tr>
                    <td class="label">{{ __('order.phone_label') }}:</td>
                    <td class="value">{{ $order->customer->mobile }}</td>
                </tr>
                <tr>
                    <td class="label">{{ __('order.email_label') }}:</td>
                    <td class="value">{{ $order->customer->email }}</td>
                </tr>
            </table>
        </div>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th>{{ __('order.code') }}</th>
                <th>{{ __('order.item_description') }}</th>
                <th>{{ __('order.qty') }}</th>
                <th>{{ __('order.unit_of_measure') }}</th>
                <th>{{ __('order.unit_price') }}</th>
                <th>{{ __('order.total') }}</th>
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
            <td><strong>{{ __('order.total') }}</strong></td>
            <td><strong>{{ __('order.currency') }}</strong></td>
            <td><strong>{{ number_format($order->total_amount, 2) }}</strong></td>
        </tr>
    </table>

</body>

</html>
