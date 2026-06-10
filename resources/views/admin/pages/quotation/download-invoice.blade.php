<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title> {{ settings('app_title') ?? config.app.name }} Quotation</title>

    <!-- Favicon -->
    <link rel="icon" href="./images/favicon.png" type="image/x-icon" />

    <!-- Invoice styling -->
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            text-align: center;
            color: #777;
        }

        body h1 {
            font-weight: 300;
            margin-bottom: 0px;
            padding-bottom: 0px;
            color: #000;
        }

        body h3 {
            font-weight: 300;
            margin-top: 10px;
            margin-bottom: 20px;
            font-style: italic;
            color: #555;
        }

        body a {
            color: #06f;
        }

        .mx-1 {
            margin: 0 0.25rem;
        }

        .mx-2 {
            margin: 0 0.5rem;
        }

        .mx-3 {
            margin: 0 0.75rem;
        }

        .mx-4 {
            margin: 0 1rem;
        }

        .text-right {
            text-align: right !important;
        }

        .text-left {
            text-align: left !important;
        }

        .text-center {
            text-align: center !important;
        }

        .table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .table thead {
            background-color: #07a769;
            color: white;
        }

        .table td,
        .table th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        .table tfoot td,
        .table tfoot th {
            border: none;
            border-bottom: 1px solid #dddddd;
            padding: 8px;
        }

        .border-bottom {
            border-bottom: 1px solid #777 !important;
        }

        .border-top {
            border-top: 1px solid #777 !important;
        }

        .badge-warning {
            color: #212529;
            background-color: #ffc107;
        }

        .badge-pill {
            padding-right: 0.6em;
            padding-left: 0.6em;
            border-radius: 10rem;
        }

        .badge {
            display: inline-block;
            padding: 0.25em 0.4em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25rem;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 10px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <div>
            <a href="{{ route('admin.home.dashboard') }}" target="_blank" style="text-decoration: none; color:#005C2D">
                <img src="data:image/png;base64,{{ $image }}" style="height:60px" />
            </a>
        </div>
        <table>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr class="border-top">
                            <td>
                                <h4> Billed To:</h4>
                                <span class="">{{ $order?->customer ? $order?->customer?->full_name : $order?->order_person_name }}</span> <br />
                                Address: {{ $order?->customer ? $order?->customer?->address : $order?->order_person_address }}<br />
                                Phone: {{ $order?->customer ? $order?->customer?->phone : $order?->order_person_phone }}<br />
                            </td>

                            <td>
                                <div class="text-grey-m2">
                                    <br />
                                    <b class="text-600">{{ settings('app_title') ?? config.app.name }}</b><br />
                                    <span class="text-600">{{ getCompanyAddress() }}</span><br />
                                    <span class="text-600">{{ settings('phone') ?? 'N/A' }}</span><br />

                                    <span class="text-600">{{ settings('email') ?? 'N/A' }}</span><br />

                                    <span class="text-600">www.example.com</span>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div style="padding-bottom: 10px; padding: 8px 0;background-color: #f1f1f1;margin-bottom: 18px;     display: flex;
    justify-content: center;
    align-items: center;">
            <span class="mx-2">Quotation Number: {{ $order->id }}</span>
            <span class="mx-2">Date: {{ date('jS M Y', strtotime(now())) }}</span>
            <span class="text-600 text-90 mx-2">Payment Status:</span>
            {!! getOrderPaymentStatus($order->payment_status) !!}
            {{-- <span
                class="badge badge-warning badge-pill px-25">{{ \App\Library\Enum::getPaymentStatusType($order?->payment_status) }}
            </span> --}}
            <br />
        </div>

        <div class="border-top">
            <h4>Order Summary</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center" style="width:5%">#</th>
                        <th style="width:40%">Item</th>
                        <th class="text-center" style="width:15%">Quantity</th>
                        <th class="text-center" style="width:15%">Unit Price</th>
                        <th class="text-center" style="width:15%">Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    @php $qty =0; $subtotal = 0; @endphp
                        @foreach ($orderDetails as $key => $orderDetail)
                    @php
                        $qty = $qty + $orderDetail->quantity;
                        $subtotal = $orderDetail->quantity*$orderDetail->sale_price;
                    @endphp
                    <tr>
                        <td class="text-center">{{++$key}}</td>
                        <td class="text-left">{{ $orderDetail->product->title }} </td>
                        <td class="text-center">{{ $orderDetail->quantity }}</td>
                        <td class="text-center">{{ formatPrice($orderDetail->sale_price) }}</td>
                        <td class="text-center">{{ formatPrice($subtotal) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-right">Sub Total</th>
                        <td class="text-center">{{ formatPrice($order->sub_total_amount) }}</td>
                    </tr>

                    <tr>
                        <td colspan="4" class="text-right">VAT/Tax</td>
                        <td class="text-center">{{ getFormattedAmount($order->vat_amount) }}</td>
                    </tr>

                    <tr>
                        <td colspan="4" class="text-right">Packaging Charge</td>
                        <td class="text-center">{{ getFormattedAmount($order->packaging_cost) }}</td>
                    </tr>

                    <tr>
                        <td colspan="4" class="text-right">Delivery Charge</td>
                        <td class="text-center">{{ getFormattedAmount($order->shipping_cost) }}</td>
                    </tr>

                    <tr>
                        <td colspan="4" class="text-right">Discount</td>
                        <td class="text-center">{{ getFormattedAmount($order->discount_amount) }}</td>
                    </tr>

                    <tr>
                        <th colspan="4" class="text-right">Total <small>({{ numberToWord($order->total_amount) }})</small></th>
                        <td class="text-center">{{formatPrice($order->total_amount)}}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div style="display:flex;justify-content: space-around;background-color: #00a967;color: white;padding: 10px;margin-top: 63px;">
            <span style="margin-right: 20px !important;">Thank you for business with us.</span>
            <span class="">Developed By: <a style="color: #0047ff;font-weight: 900;" href="https://web.ferdausahmed.com" >NCloud Solutions
</a> </span>
        </div>
    </div>
</body>

</html>
