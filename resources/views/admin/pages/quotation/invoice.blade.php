<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title> {{ settings('app_title') ?? config.app.name }} Quotation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        :root {
            --color-deep-primary: #024422;
            --color-primary: #005C2D;
            --color-deep-secondary: #0dbb62;
            --color-secondary: #4ACE8B;
            --color-light-deep-secondary: #8fe9aa;
            --color-light-secondary: #C1FCD3;
            --color-light-secondary-trans: #c1fcd33b;
            --color-black: #000000;
            --color-white: #FFFFFF;
            --color-soft-gray: #ededed;
            --color-red: #FF4747;
            --color-text-secondary: #728299;
        }

        body {
            margin-top: 20px;
            color: #484b51;
            background-color: #eaeaea;
        }

        .page-content {
            background: #ffffff none repeat scroll 0 0;
            border-bottom: 12px solid #333333;
            border-top: 12px solid var(--color-deep-secondary);
            margin-top: 50px;
            margin-bottom: 50px;
            padding: 20px 30px !important;
            position: relative;
            box-shadow: 0 1px 21px #acacac;
            color: #333333;
            font-family: open sans;
        }

        .table thead {
            background-color: #07a769;
            color: white;
        }

        .table td,
        .table th {
            padding: 0.5rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .text-secondary-d1 {
            color: var(--color-text-secondary) !important;
        }

        .text-default-d3 {
            font-weight: 900;
            color: var(--color-deep-secondary);
            font-size: 40px;
        }

        .page-header {
            margin: 0 0 1rem;
            /* padding-bottom: 0.3rem; */
            /* padding-top: 0.5rem; */
            display: -ms-flexbox;
            display: flex;
            -ms-flex-pack: justify;
            justify-content: space-between;
            -ms-flex-align: center;
            align-items: center;
        }

        .page-title {
            padding: 0;
            margin: 0;
            font-size: 1.75rem;
            font-weight: 300;
        }

        .company-logo {
            border-bottom: 1px dotted #e2e2e2;
            border-top: 1px dotted #e2e2e2;
        }

        .brand-logo-mini {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-logo-mini img {
            width: auto;
            height: 100px;
        }

        .brc-default-l1 {
            border-color: #dce9f0 !important;
        }

        .ml-n1,
        .mx-n1 {
            margin-left: -.25rem !important;
        }

        .mr-n1,
        .mx-n1 {
            margin-right: -.25rem !important;
        }

        .mb-4,
        .my-4 {
            margin-bottom: 1.5rem !important;
        }

        hr {
            margin-top: 1rem;
            margin-bottom: 1rem;
            border: 0;
            border-top: 1px solid rgba(0, 0, 0, .1);
        }

        .text-grey-m2 {
            color: #888a8d !important;
        }

        .text-success-m2 {
            color: #86bd68 !important;
        }

        .font-bolder,
        .text-600 {
            font-weight: 600 !important;
        }

        .text-110 {
            font-size: 110% !important;
        }

        .text-primary-m1 {
            color: #478fcc !important;
        }

        .pb-25,
        .py-25 {
            padding-bottom: .75rem !important;
        }

        .pt-25,
        .py-25 {
            padding-top: .75rem !important;
        }

        .bgc-default-tp1 {
            background-color: rgba(121, 169, 197, .92) !important;
        }

        .bgc-default-l4,
        .bgc-h-default-l4:hover {
            background-color: #f3f8fa !important;
        }

        .page-header .page-tools {
            -ms-flex-item-align: end;
            align-self: flex-end;
        }

        .btn-light {
            color: #757984;
            background-color: #f5f6f9;
            border-color: #dddfe4;
        }

        .w-2 {
            width: 1rem;
        }

        .text-120 {
            font-size: 120% !important;
        }

        .text-primary-m1 {
            color: var(--color-deep-secondary) !important;
        }

        .text-danger-m1 {
            color: #dd4949 !important;
        }

        .text-150 {
            font-size: 150% !important;
        }

        .text-60 {
            font-size: 60% !important;
        }

        .text-grey-m1 {
            color: #7b7d81 !important;
        }

        .align-bottom {
            vertical-align: bottom !important;
        }
    </style>
</head>

<body>
    @php
    use App\Library\Helper;
    @endphp
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <div class="page-content container">
        <div class="page-header text-primary-m1-d2">
            <h1 class="page-title text-secondary-d1">
                Quotation
                <small class="page-info">
                    <i class="fa fa-angle-double-right text-80"></i>
                    Quotation Number: {{ $order->id }}
                </small>
            </h1>
            <div class="page-tools">
                <div class="action-buttons">
                    <a class="btn bg-white btn-light mx-1px text-95"
                        href="{{ route('admin.quotation.invoice.download',$order->id)}}" data-title="Print">
                        <i class="mr-1 fa fa-file-pdf text-primary-m1 text-120 w-2"></i>
                        Download
                    </a>
                </div>
            </div>
        </div>
        <div class="container px-0">
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="row company-logo">
                        <div class="col-12">
                            <div class="row d-flex justify-content-around">
                                <div class="text-center text-150 col-sm-6 d-sm-flex justify-content-center">
                                    <a class="brand-logo-mini" href="{{ route('admin.home.dashboard') }}"><img
                                            class="img-fluid"
                                            src="{{ settings('invoice_logo') ? asset(settings('invoice_logo')) : Vite::asset(\App\Library\Enum::LOGO_PATH) }}"
                                            alt="logo" />
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div>
                                <span class="text-sm text-grey-m2 align-middle">Billed To:</span>
                            </div>
                            <div class="text-grey-m2">
                                <div class="my-1"><i class="fa-solid fa-user fa-flip-horizontal text-secondary"></i> <b
                                        class="text-600 text-primary-m1">{{ $order?->customer ? $order?->customer?->full_name : $order?->order_person_name }}</b></div>
                                <div class="my-1"><i
                                        class="fa-solid fa-map-location-dot fa-flip-horizontal text-secondary"></i> <b
                                        class="text-600">{{ $order?->customer ? $order?->customer?->address : $order?->order_person_address }}</b></div>

                                <div class="my-1"><i class="fa fa-phone text-secondary"></i> <b
                                        class="text-600">{{ $order?->customer ? $order?->customer?->phone : $order?->order_person_phone }}</b></div>
                                <div class="my-1"><i class="fa fa-envelope fa-flip-horizontal text-secondary"></i> <b
                                        class="text-600">{{ $order?->customer?->email }}</b></div>
                            </div>
                        </div>

                        <div class="text-95 col-sm-6 align-self-start d-sm-flex justify-content-end">
                            <hr class="d-sm-none" />
                            <div class="text-grey-m2">

                                <div class="text-grey-m2">

                                    <div class=""><i class="fa-solid fa-building fa-flip-horizontal text-secondary"></i>
                                        <b class="text-600">{{ settings('app_title') ?? config.app.name }}</b>
                                    </div>
                                    <div class="my-1"><i
                                            class="fa-solid fa-map-location-dot fa-flip-horizontal text-secondary"></i>
                                        <b class="text-600">{{ getCompanyAddress() }}</b></div>

                                    <div class=""><i class="fa fa-phone text-secondary"></i>
                                        <b class="text-600">{{ settings('phone') ?? 'N/A' }}</b></div>
                                    <div class="my-1"><i class="fa fa-envelope fa-flip-horizontal text-secondary"></i>
                                        <b class="text-600">{{ settings('email') ?? 'N/A' }}</b></div>
                                    <div class=""><i class="fa fa-globe fa-flip-horizontal text-secondary"></i>
                                        <b class="text-600">www.example.com</b></div>
                                </div>
                            </div>
                        </div>

                        <div class="text-95 col-sm-12 align-self-start d-sm-flex justify-content-center"
                            style="background-color: #e9eae9;padding: 5px 0;border-radius: 10px; margin-top: 10px;">
                            <hr class="d-sm-none" />
                            <div class="text-grey-m2">

                                <div class="mx-3 d-inline"><i class="fa fa-circle text-primary-m1 text-xs mr-1"></i>
                                    <span class="text-600 text-90">Quotation Number:</span> {{ $order->id }}
                                </div>
                                <div class="mx-3 d-inline"><i class="fa fa-circle text-primary-m1 text-xs mr-1"></i>
                                    <span class="text-600 text-90">Date:</span>
                                    {{ date('jS F Y', strtotime(now())) }} </div>
                                <div class="mx-3 d-inline"><i class="fa fa-circle text-primary-m1 text-xs mr-1"></i>
                                    <span class="text-600 text-90">Payment Status:</span>
                                    {!! getOrderPaymentStatus($order->payment_status) !!}
                                    {{-- <span
                                        class="badge badge-warning badge-pill px-25">{{ \App\Library\Enum::getPaymentStatusType($order?->payment_status) }}
                                    </span> --}}
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="mt-4">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:5%">#</th>
                                    <th style="width:50%">Item</th>
                                    <th class="text-right" style="width:15%">Quantity</th>
                                    <th class="text-right" style="width:15%">Unit Price</th>
                                    <th class="text-right" style="width:15%">Total Price</th>
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
                                    <td class="text-right">{{ $orderDetail->quantity }}</td>
                                    <td class="text-right">{{ formatPrice($orderDetail->sale_price) }}</td>
                                    <td class="text-right">{{ formatPrice($subtotal) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-right">Sub Total</th>
                                    <td class="text-right">{{ formatPrice($order->sub_total_amount) }}</td>
                                </tr>

                                <tr>
                                    <td colspan="4" class="text-right">VAT/Tax</td>
                                    <td class="text-right"><span
                                            class="text-120 text-secondary-d1">{{ getFormattedAmount($order->vat_amount) }}</span>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="4" class="text-right">Packaging Charge</td>
                                    <td class="text-right"><span
                                            class="text-120 text-secondary-d1">{{ getFormattedAmount($order->packaging_cost) }}</span>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="4" class="text-right">Delivery Charge</td>
                                    <td class="text-right"><span
                                            class="text-120 text-secondary-d1">{{ getFormattedAmount($order->shipping_cost) }}</span>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="4" class="text-right">Discount</td>
                                    <td class="text-right"><span
                                            class="text-120 text-secondary-d1">{{ getFormattedAmount($order->discount_amount) }}</span>
                                    </td>
                                </tr>

                                <tr>
                                    <th colspan="4" class="text-right text-150">Total <small>({{ numberToWord($order->total_amount) }})</small></th>
                                    <td class="text-right"><span class="text-150 text-success-d3 opacity-2">
                                            {{formatPrice($order->total_amount)}}</span></td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="row border-b-2 brc-default-l2"></div>
                        <hr />
                        <div>
                            <span class="text-secondary-d1 text-105">Thank you for business with us.</span>
                            @if(Helper::hasAuthRolePermission('user_delete'))
                            <a class="btn mb-2 mr-2 btn-success px-4 float-right mt-3 mt-lg-0"
                                href="{{ route('admin.quotation.show', $order->id) }}">
                                <i class="fa-solid fa-angle-left"></i>
                                Back On Quotation
                            </a>
                            @endif
                            <!-- <a href="#" class="btn btn2-primary btn-bold px-4 float-right mt-3 mt-lg-0">Pay Now</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">

    </script>
</body>

</html>
