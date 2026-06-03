<?php

namespace App\Library\Services\Seller\Advertise;

use Exception;
use Carbon\Carbon;
use App\Library\Enum;
use App\Library\Helper;
use App\Models\Product;
use App\Models\Advertise;
use App\Models\Attachment;
use App\Models\AdvertiseLocation;
use Yajra\DataTables\Facades\DataTables;
use App\Library\Services\Admin\BaseService;

class AdService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';
        $route = route('seller.ad.delete', $row->id);

        if ($row->id) {
            if (Helper::hasAuthRolePermission('seller_ad_request_update')) {
                if ($row->status == Enum::AD_STATUS_PENDING) {
                    $actionHtml .= '<a class="dropdown-item" href="' . route('seller.ad.edit', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>';
                }
            }

            if (Helper::hasAuthRolePermission('seller_ad_request_delete')) {
                if ($row->status == Enum::AD_STATUS_PENDING) {
                    $actionHtml .= '<button class="dropdown-item text-danger" onclick="confirmFormModal(\'' . $route . '\', \'Confirmation\', \'Are you sure to delete?\');"><i class="fa fa-trash-alt"></i> Delete</button>';
                }
            }
        }

        if ($row->status == Enum::AD_STATUS_ACTIVE || $row->status == Enum::AD_STATUS_REJECTED) {
            return 'N/A';
        }

        return '<div class="action dropdown">
                    <button class="btn btn2-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       <i class="fas fa-tools"></i> Action
                    </button>
                    <div class="dropdown-menu">
                        ' . $actionHtml . '
                    </div>
                </div>';
    }

    private function statusHtml($status)
    {
        $statusClassMapping = [
            Enum::AD_STATUS_ACTIVE => 'badge-success',
            Enum::AD_STATUS_REJECTED => 'badge-danger',
            Enum::AD_STATUS_PENDING  => 'badge-info',
        ];

        $class = $statusClassMapping[$status] ?? 'badge-secondary';
        $statusText = Enum::getAdStatusType($status);

        return '<div class="badge ' . $class . '">' . $statusText . '</div>';
    }

    private function paymentStatusHtml($status)
    {
        $statusClassMapping = [
            Enum::AD_PAYMENT_STATUS_PAID => 'badge-success',
            Enum::AD_PAYMENT_STATUS_UNPAID => 'badge-warning',
        ];

        $class = $statusClassMapping[$status] ?? 'badge-secondary';
        $statusText = Enum::getAdPaymentStatusType($status);

        return '<div class="badge ' . $class . '">' . $statusText . '</div>';
    }


    public function dataTable()
    {
        $data = Advertise::with('adLocation', 'seller', 'attachment')->where('seller_id', authSellerId())->get();

        return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('location', function ($row) {
                    return ucwords(str_replace('_', ' ', $row->adLocation->location));
                })
                ->editColumn('ad_image', function ($row) {
                    if ($row->product_ids) {
                        return 'N/A';
                    }
                    return $this->getImage($row);
                })
                ->editColumn('seller', function ($row) {
                    return $row?->seller?->full_name;
                })
                ->editColumn('amount', function ($row) {
                    return getFormattedAmount($row->amount);
                })
                ->editColumn('status', function ($row) {
                    return $this->statusHtml($row->status);
                })
                ->editColumn('payment_status', function ($row) {
                    return $this->paymentStatusHtml($row->payment_status);
                })
                ->editColumn('start_date', function ($row) {
                    return getFormattedDate($row->start_date);
                })
                ->editColumn('end_date', function ($row) {
                    return getFormattedDate($row->end_date);
                })
                ->addColumn('product', function ($row) {
                    if (!$row->product_ids) {
                        return 'N/A';
                    }

                    $productIds = json_decode($row->product_ids);
                    $products = Product::whereIn('id', $productIds)->get();

                    $productInfo = $products->map(function ($product) {
                        $url = route('public.product.show', $product->slug);
                        return '<a href="' . $url . '">' . $product->id . '</a>';
                    });

                    return $productInfo->implode(', ');
                })
                ->addColumn('link', function ($row) {
                    return $row->link ?? 'N/A';
                })
                ->addColumn('action', function ($row) {
                    return $this->actionHtml($row);
                })

                ->rawColumns(['action', 'ad_image', 'product', 'payment_status', 'status'])
                ->make(true);
    }

    public function changeStatus(AdvertiseLocation $ad_location): bool
    {
        try {
            $this->data = $ad_location->update(['active' => !$ad_location->active]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function store(array $data): bool
    {
        try {
            $days = Carbon::parse($data['start_date'])->diffInDays($data['end_date']) + 1;

            $adCostPerDay = AdvertiseLocation::find($data['advertise_location_id']);

            if ($adCostPerDay->location == Enum::AD_LOCATION_FLASH_SALE) {
                $productIds = Attachment::where('attachable_type', 'App\Models\Product')
                                                    ->whereIn('attachment', $data['product_ids'])
                                                    ->pluck('attachable_id');

                $amount = $days * $adCostPerDay->amount * count($productIds);
                $data['product_ids'] = json_encode($productIds);
            } else {
                $amount = $days * $adCostPerDay->amount;
            }

            $data['seller_id'] = authSellerId();
            $data['amount'] = $amount;
            $advertise = Advertise::create($data);

            if (request()->file('image')) {
                $filePath = $this->getAttachment(request()->file('image'));

                $attachment = new Attachment();
                $attachment->attachment = $filePath;
                $attachment->mime_type = request()->file('image')->getClientOriginalExtension();

                $advertise->attachment()->save($attachment);
            }

            return $this->handleSuccess('Successfully created');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function update(Advertise $ad, array $data): bool
    {
        try {
            $days = Carbon::parse($data['start_date'])->diffInDays($data['end_date']) + 1;

            $adCostPerDay = AdvertiseLocation::find($data['advertise_location_id']);

            if ($adCostPerDay->location == Enum::AD_LOCATION_FLASH_SALE) {
                $productIds = Attachment::where('attachable_type', 'App\Models\Product')
                                                    ->whereIn('attachment', $data['product_ids'])
                                                    ->pluck('attachable_id');

                $amount = $days * $adCostPerDay->amount * count($productIds);
                $data['product_ids'] = json_encode($productIds);
            } else {
                $amount = $days * $adCostPerDay->amount;
            }

            $ad->seller_id = authSellerId();
            $ad->amount = $amount;

            $this->data = $ad->update($data);

            if (request()->file('image')) {
                deleteFile($ad->attachment?->attachment);

                $filePath = $this->getAttachment(request()->file('image'));

                $attachment = new Attachment();
                $attachment->attachment = $filePath;
                $attachment->mime_type = request()->file('image')->getClientOriginalExtension();

                $ad->attachment()->save($attachment);
            }

            return $this->handleSuccess('Successfully Updated');
         } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function delete(Advertise $ad): bool
    {
        try {
            deleteFile($ad->attachment?->attachment);

            $ad->delete();

            $this->message = __('Successfully deleted');

            return true;
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public static function getAttachment($attachment): string
    {
        $file_extension = $attachment->getMimeType();

        if ($file_extension == 'image/*') {
            return Helper::uploadImage($attachment, Enum::ATTACHMENT_FILE_DIR, 600, 300);
        }

        return Helper::uploadFile($attachment, Enum::ATTACHMENT_FILE_DIR);
    }

    private function getImage($row)
    {
        $image = $row->getImageAttribute();

        return '<div class="text-center pb-2 d-inline-block">
            <img src="' . $image . '" alt="image" class="img-fluid"
            onclick="clickImage(\'' . $image . '\')">
            </div>';
    }
}
