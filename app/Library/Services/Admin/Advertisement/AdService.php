<?php

namespace App\Library\Services\Admin\Advertisement;

use Exception;
use App\Library\Enum;
use App\Library\Helper;
use App\Models\Product;
use App\Models\Advertise;
use App\Models\Attachment;
use Yajra\DataTables\Facades\DataTables;
use App\Library\Services\Admin\BaseService;

class AdService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';
        $route = route('admin.ad.delete', $row->id);

        if ($row->id) {
            if (Helper::hasAuthRolePermission('ad_update')) {
                $actionHtml .= '<a class="dropdown-item" href="' . route('admin.ad.edit', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>';
            }

            if (Helper::hasAuthRolePermission('ad_delete')) {
                if ($row->status == Enum::AD_STATUS_INACTIVE) {
                    $actionHtml .= '<button class="dropdown-item text-danger" onclick="confirmFormModal(\'' . $route . '\', \'Confirmation\', \'Are you sure to delete?\');"><i class="fa fa-trash-alt"></i> Delete</button>';
                }
            }
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

    private function statusHtml($row)
    {
        $is_check = $row->status == Enum::AD_STATUS_ACTIVE ? "checked" : "";
        $route = "'" . route('admin.ad.change_status', $row->id) . "'";
        $disabled = '';

        if (! Helper::hasAuthRolePermission('ad_change_status')) {
            $disabled = "disabled";
        }

        return '<label class="custom-switch ' . $disabled . '" for="primarySwitch_'. $row->id . '">
                    <input type="checkbox" class="custom-switch-input" ' . $disabled . '
                        id="primarySwitch_'. $row->id . '" ' . $is_check . '
                        onchange="changeStatus(event, ' . $route . ')">
                    <span class="custom-switch-indicator"></span>
                </label>';
    }

    public function dataTable()
    {
        $data = Advertise::with('adLocation', 'seller', 'attachment')->where('seller_id', sellerId())->get();

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
                        return '<a href="' . $url . '" target="_blank">' . $product->id . '</a>';
                    });

                    return $productInfo->implode(', ');
                })
                ->addColumn('link', function ($row) {
                    return $row->link ? "<a href='$row->link' target='_blank'>Click</a>" : 'N/A';
                })
                ->addColumn('status', function ($row) {
                    return $this->statusHtml($row);
                })
                ->addColumn('action', function ($row) {
                    return $this->actionHtml($row);
                })

                ->rawColumns(['action', 'ad_image', 'product', 'status', 'link'])
                ->make(true);
    }

    public function store(array $data): bool
    {
        try {
            if (isset($data['product_ids'])) {
                $data['product_ids'] = json_encode($data['product_ids']);
            }

            $data['seller_id'] = sellerId();

            $advertise = Advertise::create($data);

            if (isset($data['image']) && $data['image'] != '') {
                // Top Brand Offer
                $width = 785;
                $height = 350;

                // Deals you can't miss
                if ($advertise?->adLocation?->location == Enum::AD_LOCATION_DEAL_YOU_CAN_NOT_MISS) {
                    $width = 530;
                    $height = 500;
                }

                $file_path = storeFile($data['image'], Enum::ADVERTISE_IMAGE_DIR, $width, $height);
                $attachment = new Attachment();
                $attachment->attachment = $file_path;
                $attachment->mime_type = $data['image']->getClientOriginalExtension();
                $attachment->for = Enum::ATTACHMENT_TYPE_THUMBNAIL;

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
            if (isset($data['product_ids'])) {
                $data['product_ids'] = json_encode($data['product_ids']);
            }

            $this->data = $ad->update($data);

            if (isset($data['image']) && $data['image'] != '') {
                $attachment = Attachment::where('attachable_type', Advertise::class)->where('attachable_id', $ad->id)->where('for', Enum::ATTACHMENT_TYPE_THUMBNAIL)->first();

                deleteFile($ad->getImageAttribute());

                isset($attachment) ? $attachment->delete() : '';

                // Top Brand Offer
                $width = 785;
                $height = 350;

                // Deals you can't miss
                if ($ad?->adLocation?->location == Enum::AD_LOCATION_DEAL_YOU_CAN_NOT_MISS) {
                    $width = 530;
                    $height = 500;
                }

                $file_path = storeFile($data['image'], Enum::ADVERTISE_IMAGE_DIR, $width, $height);
                $attachment = new Attachment();
                $attachment->attachment = $file_path;
                $attachment->mime_type = $data['image']->getClientOriginalExtension();
                $attachment->for = Enum::ATTACHMENT_TYPE_THUMBNAIL;

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

    private function getImage($row)
    {
        $image = $row->getImage();

        return '<div class="text-center pb-2 d-inline-block">
            <img src="' . $image . '" alt="image" class="img-fluid"
            onclick="clickImage(\'' . $image . '\')">
            </div>';
    }

    public function changeStatus(Advertise $ad): bool
    {
        try {
            $status = Enum::AD_STATUS_INACTIVE;

            if ($ad->status == Enum::AD_STATUS_INACTIVE) {
                $status = Enum::AD_STATUS_ACTIVE;
            }

            $this->data = $ad->update(['status' => $status]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }
}