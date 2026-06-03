<?php

namespace App\Library\Services\Admin\Product;

use DB;
use Exception;
use Carbon\Carbon;
use App\Library\Enum;
use App\Library\Helper;
use App\Models\Product;
use App\Models\Attachment;
use Illuminate\Support\Str;
use App\Models\ProductStock;
use App\Models\ProductReview;
use App\Models\ProductDetails;
use App\Models\ProductLanguage;
use App\Models\ProductQuestion;
use App\Models\ProductServiceLanguage;
use Yajra\DataTables\Facades\DataTables;
use App\Library\Services\Admin\BaseService;
use App\Models\ProductService as ModelsProductService;

class ProductService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';
        //$route = route('public.product.show', $row->slug);
        $route = url(config('app.url') . '/products/show/' . $row->slug);

        if ($row->id) {
            if (Helper::hasAuthRolePermission('product_show')) {
                $actionHtml .= '<a class="dropdown-item" href="' . $route . '" target="_blank" ><i class="far fa-eye"></i> Show </a>';
            }

            if (Helper::hasAuthRolePermission('product_update')) {
                $actionHtml .= '<a class="dropdown-item" href="' . route('admin.product.edit', $row->id) . '" ><i class="far fa-edit"></i> Edit </a>';
            }

            if (Helper::hasAuthRolePermission('review_index')) {
                $review = ProductReview::where('product_id', $row->id)->get();
                
                $actionHtml .= count($review) > 0 ? '<a class="dropdown-item" href="' . route('admin.product.reviews', $row->id) . '" ><i class="far fa-star"></i> Review </a>' : '<a class="dropdown-item"><i class="far fa-star"></i> Review</a>';
            }

            if (Helper::hasAuthRolePermission('product_question_index')) {
                $answer = ProductQuestion::getProductQuestion($row->id);

                $actionHtml .= count($answer) > 0 ? '<a class="dropdown-item" href="' . route('admin.product.question.index', $row->id) . '" ><i class="fa-regular fa-comment-dots"></i> Answer </a>' : '<a class="dropdown-item"><i class="fa-regular fa-comment-dots"></i> Answer</a>';
            }

            // if (Helper::hasAuthRolePermission('seller_product_create_clone')) {
            //     $actionHtml .= '<a class="dropdown-item" href="' . route('admin.product.clone', $row->id) . '" ><i class="fa-regular fa-clone"></i> Clone </a>';
            // }

            if (Helper::hasAuthRolePermission('product_delete')) {
                $actionHtml .= '<a style="cursor: pointer" class="dropdown-item text-danger" onclick="confirmFormModal(\'' . route('admin.product.delete', $row->id) . '\', \'Confirmation\', \'Are you sure to delete operation?\')" ><i class="fas fa-trash-alt"></i> Delete</a>';
            }
        }

        $actionField = '';

        if (isset($row->deleted_at)) {
            $actionField .= "N/A";
        }else{
            $actionField .= '<div class="action dropdown">
                <button class="btn btn2-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-tools"></i> Action
                </button>
                <div class="dropdown-menu">
                    ' . $actionHtml . '
                </div>
            </div>';
        }

        return $actionField;
    }

    private function getImage($row)
    {
        $image = $row->getThumbnailImage();

        return '<div class="text-center pb-2 d-inline-block">
            <img src="' . $image . '" alt="image" class="img-fluid"
            onclick="clickImage(\'' . $image . '\')">
            </div>';
    }


    private function filter(array $params)
    {
        $query = Product::with('category', 'brand', 'operator', 'productLanguages', 'productStock', 'productStocks');

        if (isset($params['status']) && $params['status'] != null) {
            $status = $params['status'];

            $query->when($status == 'trash', function ($q) {
                $q->onlyTrashed();
            });

            $query->when($status != 'all' && $status != 'trash' && $status != 'pending', function ($q) use ($status) {
                $q->where('status', $status)->where('approved', true);
            });

            $query->when($status == 'pending', function ($q) {
                $q->where('approved', false);
            });
        }

        $query->when(isset($params['category_id']) && $params['category_id'] != null, function ($q) use ($params) {
            $q->where('category_id', $params['category_id']);
        });

        if (isset($params['sorting']) && $params['sorting'] != null) {
            $sorting = $params['sorting'];

            switch ($sorting) {
                case 'latest_on_top':
                    $query->orderByDesc('id');

                    break;
                case 'oldest_on_top':
                    $query->orderBy('id');

                    break;
                case 'price_high':
                    $query->orderByDesc('unit_price');

                    break;
                case 'price_low':
                    $query->orderBy('unit_price');

                    break;
                case 'sale_high':
                    $query->orderByDesc('total_sale');

                    break;
                case 'sale_low':
                    $query->orderBy('total_sale');

                    break;
                case 'rating_high':
                    $query->orderByDesc('rating');

                    break;
                case 'rating_low':
                    $query->orderBy('rating');

                    break;
                default:
                    $query->orderBy('id', 'desc');

                    break;
            }
        }

        return $query->get();
    }

    public function dataTable($filter_params)
    {
        $data = $this->filter($filter_params);

        return Datatables::of($data)
                ->addIndexColumn()

                ->editColumn('title', function ($row) {
                    $name = Str::limit($row?->getTranslation('title'), 30);

                    $route = '';
                    if (Helper::hasAuthRolePermission('product_show')) {
                        $route = url(config('app.url') . '/products/show/' . $row->slug);
                    } else {
                        $route = '#';
                    }

                    return $row->deleted_at ? $this->getImage($row) . $name : $this->getImage($row) . '<a href="' . $route . '" class="text-primary pl-2" target="_blank">' . $name . '</a>';
                })
                ->editColumn('category_id', function ($row) {
                    return $row->category ? $row->category->getTranslation('title') : 'N/A';
                })
                ->editColumn('details', function ($row) {
                    return $this->getDetails($row);
                })
                ->editColumn('current_stock', function ($row) {
                    return $this->getCurrentStock($row);
                })
                ->editColumn('featured', function ($row) {
                    return $this->getFeatureSwitch($row);
                })
                ->editColumn('status', function ($row) {
                    return $this->getStatus($row);
                })
                ->editColumn('refundable', function ($row) {
                    $route = "'" . route('admin.product.refundable', $row->id) . "'";
                    $is_check = $row->refundable ? "checked" : "";

                    if ($row->status != Enum::PRODUCT_STATUS_TRASH && $row->deleted_at == null) {
                        return $this->getSwitch($row, $route, $is_check, 'refundable');
                    }

                    return $this->getDisabledSwitch($row, 'refundable');
                })
                ->editColumn('operator_id', function ($row) {
                    return $row?->operator?->full_name;
                })
                ->addColumn('action', function ($row) {
                    return $this->actionHtml($row);
                })
                ->rawColumns(['title', 'details', 'current_stock', 'status', 'featured', 'refundable', 'showHomePage', 'action', 'approved'])
                ->make(true);
    }

    public function getDetails($row)
    {
        $unit = $row->unit ? '/' . $row->unit . '' : '';
        $detailsHtml = '';
        $detailsHtml .= '<span class="custom_span">Price: ' . getFormattedAmount($row->unit_price) . $unit . '</span> <br />';
        $detailsHtml .= '<span class="custom_span">Total Sale: ' . $row->total_sale . '</span> <br />';
        $detailsHtml .= '<span class="custom_span">Rating: ' . $row->rating . '</span> <br />';
        $detailsHtml .= '<span class="custom_span">Current Stock: ' . $row->current_stock . '</span>';

        return $detailsHtml;
    }

    public function getCurrentStock($row)
    {
        $currentStock = '';

        foreach ($row->productStocks as $stock) {
            $separator = $stock->name ? ': ' : '';
            $currentStock .= '<span class="custom_span">' . $stock->name . $separator . $stock->current_stock . '</span> <br />';
        }

        return $currentStock;
    }

    public function findStock($variant_ids, $product_id)
    {
        return ProductStock::with('product', 'attachment')->where('variant_ids', $variant_ids)->where('product_id', $product_id)->first();
    }

    private function getStatus($row)
    {
        if ($row->status != Enum::PRODUCT_STATUS_TRASH && $row->deleted_at == null) {
            $route = "'" . route('admin.product.change_status', $row->id) . "'";

            $is_check = $row->status == Enum::PRODUCT_STATUS_PUBLISHED ? "checked" : "";

            return $this->getSwitch($row, $route, $is_check, 'status');
        }

        return $this->getDisabledSwitch();
    }

    private function getSwitch($row, $route, $is_check, $column)
    {
        return '<label class="custom-switch" for="primarySwitch_' . $column . $row->id . '">
                    <input type="checkbox" class="custom-switch-input"
                        id="primarySwitch_' . $column . $row->id . '" ' . $is_check . '
                        onchange="changeStatus(event, ' . $route . ')">
                    <span class="custom-switch-indicator"></span>
                </label>';
    }

    private function getDisabledSwitch()
    {
        return '<label class="cursor-not-allowed custom-switch" >
                    <input type="checkbox" name="refundable" class="custom-switch-input" disabled>
                    <span class="custom-switch-indicator"></span>
                </label>';
    }

    // private function getSwitch($row)
    // {
    //     $is_check = $row->is_active ? "checked" : "";
    //     $route = "'" . route('admin.product.change_status', $row->id) . "'";

    //     return '<div class="custom-control custom-switch">
    //                 <input type="checkbox"
    //                     onchange="changeStatus(event, ' . $route . ')"
    //                     class="custom-control-input"
    //                     id="primarySwitch_' . $row->id . '" ' . $is_check . ' >
    //                 <label class="custom-control-label" for="primarySwitch_' . $row->id . '"></label>
    //             </div>';
    // }

    // private function getImage($row)
    // {
    //     $image = $row->getThumbnailImage();

    //     return '<div class="text-center pb-2">
    //         <img src="' . $image . '" alt="image" class="img-fluid"
    //         onclick="clickImage(\'' . $image . '\')">
    //         </div>';
    // }

    private function getActiveSwitch($row)
    {
        $is_check = "";
        $confirmation_msg = "'Are you sure !! You Active It?'";

        if ($row->is_active) {
            $is_check = "checked";
            $confirmation_msg = "'Are you sure !! You Inactive It?'";
        }

        $route = "'" . route('admin.product.change_status', $row->id) . "'";
        $isDisable = Helper::hasAuthRolePermission('product_status') ? "" : "disabled";

        return '<div class="custom-control custom-switch">
                    <input type="checkbox" ' . $isDisable . '
                        onchange="changeStatus(event, ' . $route . ', ' . $confirmation_msg . ')"
                        class="custom-control-input"
                        id="primarySwitch_' . $row->id . '" ' . $is_check . ' >
                    <label class="custom-control-label" for="primarySwitch_' . $row->id . '"></label>
                </div>';
    }

    private function getFeatureSwitch($row)
    {
        $is_check = "";
        $confirmation_msg = "'Are you sure !! You Active It?'";

        if ($row->featured) {
            $is_check = "checked";
            $confirmation_msg = "'Are you sure !! You Inactive It?'";
        }

        $route = "'" . route('admin.product.change_feature', $row->id) . "'";
        $isDisable = Helper::hasAuthRolePermission('product_status') ? "" : "disabled";

        return '<label class="custom-switch" for="primaryFeatureSwitch_' . $row->id . '">
                    <input type="checkbox" ' . $isDisable . '
                        onchange="changeStatus(event, ' . $route . ', ' . $confirmation_msg . ')"
                        class="custom-switch-input"
                        id="primaryFeatureSwitch_' . $row->id . '" ' . $is_check . ' >
                        <span class="custom-switch-indicator"></span>
                </label>';
    }

    public function store(array $data): bool
    {
        DB::BeginTransaction();

        try {
            $requestData = request()->all();
            $data['operator_id'] = auth()->id();
            $titleSlug = generateUniqueSlug($data['title'], Product::class);

            // Product Table
            $productTblData = [];
            $productTblData['category_id'] = $data['category_id'];
            $productTblData['brand_id'] = $data['brand_id'];
            $productTblData['slug'] = $titleSlug . '-' . Str::uuid()->toString();
            $productTblData['type'] = isset($data['has_variant']) ? Enum::PRODUCT_TYPE_VARIANT : Enum::PRODUCT_TYPE_SIMPLE;
            $productTblData['unit'] = $data['unit'];
            $productTblData['unit_price'] = $data['unit_price'];
            $productTblData['purchase_price'] = $data['purchase_price'];
            $productTblData['weight'] = $data['weight'];
            $productTblData['barcode'] = $data['barcode'];
            $productTblData['has_variant'] = isset($data['has_variant']) ? $data['has_variant'] : null;

            if (isset($data['attribute_sets']) && count($data['attribute_sets']) > 0) {
                foreach($data['attribute_sets'] as $attributeSet) {
                    $setOfAttributes[] = $attributeSet;
                }

                $attributes = json_encode($setOfAttributes);
            } else {
                $attributes = json_encode([]);
            }

            $productTblData['attribute_sets'] = $attributes;
            $productTblData['current_stock'] = $data['current_stock'] ?? 0;
            $productTblData['minimum_order_quantity'] = $data['minimum_order_quantity'];
            $productTblData['stock_notification'] = $data['stock_notification'] ?? false;
            $productTblData['low_stock_to_notify'] = $data['low_stock_to_notify'];
            $productTblData['stock_visibility'] = $data['stock_visibility'];
            $productTblData['featured'] = isset($data['featured']) ? $data['featured'] : false;
            $productTblData['refundable'] = isset($data['refundable']) ? $data['refundable'] : false;
            
            $productTblData['has_product_base_shipping'] = isset($data['has_product_base_shipping']) ? $data['has_product_base_shipping'] : false;
            $productTblData['has_discount'] = isset($data['has_discount']) ? $data['has_discount'] : false;
            // $productTblData['cash_on_delivery'] = $data['cash_on_delivery'] ?? false;
            $productTblData['operator_id'] = $data['operator_id'];

            $product = Product::create($productTblData);

            // Product language Table
            $productLanTblData['product_id'] = $product->id;
            $productLanTblData['local'] = 'en';
            $productLanTblData['title'] = $data['title'];
            $productLanTblData['short_description'] = $data['short_description'];
            $productLanTblData['description'] = $data['description'];
            $productLanTblData['shipping_note'] = $data['shipping_note'] ?? '';
            $productLanTblData['meta_title'] = $data['meta_title'];
            $productLanTblData['meta_description'] = $data['meta_description'];

            if (isset($data['meta_keywords'][0]) && count($data['meta_keywords']) != 0) {
                $meta_keywords = explode(", ", $data['meta_keywords'][0]);

                foreach ($meta_keywords as $keyword) {
                    $key[] = $keyword;
                }

                $productLanTblData['meta_keywords'] = json_encode($key);
            }

            if (isset($data['tags'][0]) && count($data['tags']) != 0) {
                $tags = explode(", ", $data['tags'][0]);

                foreach ($tags as $keyword) {
                    $tag[] = $keyword;
                }

                $productLanTblData['tags'] = json_encode($tag);
            }

            ProductLanguage::create($productLanTblData);

            // Product Details Table
            $productDetailsTblData['product_id'] = $product->id;
            // $productDetailsTblData['shipping_type'] = $data['shipping_type'];
            // $productDetailsTblData['shipping_fee'] = $data['shipping_fee'] ?? 0;
            // $productDetailsTblData['shipping_fee_depend_on_quantity'] = $data['shipping_fee_depend_on_quantity'] ?? false;
            // $productDetailsTblData['shipping_fee_depend_on_weight'] = $data['shipping_fee_depend_on_weight'] ?? false;
            $productDetailsTblData['estimated_shipping_days'] = $data['estimated_shipping_days'];

            if (isset($data['has_discount'])) {
                $productDetailsTblData['discount'] = $data['discount'];
                $productDetailsTblData['discount_type'] = $data['discount_type'];
                $productDetailsTblData['discount_start'] = $data['discount_start'];
                $productDetailsTblData['discount_end'] = $data['discount_end'];
            }

            $dimension = [
                'length' => $data['length'],
                'width'  => $data['width'],
                'height' => $data['height'],
            ];
            $productDetailsTblData['dimension'] = json_encode($dimension);

            ProductDetails::create($productDetailsTblData);

            // Product Stocks & Update Product Table
            if (isset($data['has_variant']) && count($data['variant_name']) > 0) {
                $total_stock = 0;

                foreach ($data['variant_name'] as $key => $variant) {
                    if ($data['variant_name'][$key]) {
                        $product_stock['product_id'] = $product->id;
                        $product_stock['variant_ids'] = $data['variant_ids'][$key];
                        $product_stock['name'] = $data['variant_name'][$key];
                        $product_stock['sku'] = $data['variant_sku'][$key];
                        $product_stock['current_stock'] = $data['variant_stock'][$key];
                        $product_stock['unit_price'] = $data['variant_price'][$key];

                        $productStock = ProductStock::create($product_stock);

                        // variant image insert into attachment table
                        if (isset($data['variant_image'][$key]) && $data['variant_image'][$key] != '') {
                            attachmentStore($data['variant_image'][$key], $productStock, Enum::PRODUCT_VARIANT_IMAGE_DIR, Enum::ATTACHMENT_TYPE_VARIANT);
                        }

                        $total_stock += $productStock->current_stock;
                    }

                    $selected_variants = [];
                    $selected_variants_ids = [];

                    if (isset($data['attribute_sets']) && count($data['attribute_sets']) > 0) {
                        foreach ($data['attribute_sets'] as $attributes_set) {
                            $attribute_values = 'attribute_values_' . $attributes_set;
                            $values = [];

                            if ($attribute_values) {
                                foreach ($requestData[$attribute_values] as $value) {
                                    array_push($values, $value);
                                    array_push($selected_variants_ids, $value);
                                }

                                $selected_variants[$attributes_set] = $values;
                            }
                        }
                    }

                    $product->selected_variants = $selected_variants;
                    $product->selected_variants_ids = $selected_variants_ids;
                }

                $product->current_stock = $total_stock;
                $product->save();
            } else {
                $productStockTblData['product_id'] = $product->id;
                $productStockTblData['sku'] = $data['sku'];
                $productStockTblData['current_stock'] = $data['current_stock'];
                $productStockTblData['unit_price'] = $data['unit_price'];

                $productStock = ProductStock::create($productStockTblData);
            }

            if (isset($data['colors']) && $data['colors'] != '') {
                $product->colors()->attach($data['colors']);
            }

            // Product Service
            if (isset($data['product_service_title']) && count($data['product_service_title']) > 0) {
                foreach ($data['product_service_title'] as $key => $serviceValue) {

                    if ($data['product_service_title'][$key]) {
                        $product_service['order'] = $data['product_service_order'][$key];
                        $product_service['product_id'] = $product->id;
                        $product_service['operator_id'] = auth()->id();
                        $productService = ModelsProductService::create($product_service);

                        $product_service_lang['product_service_id'] = $productService->id;
                        $product_service_lang['local'] = 'en';
                        $product_service_lang['title'] = $data['product_service_title'][$key];
                        $product_service_lang['sub_title'] = $data['product_service_sub_title'][$key];
                        ProductServiceLanguage::create($product_service_lang);
                    }
                }
            }

            // Product Thumbnail
            if (isset($data['product_thumbnail']) && $data['product_thumbnail'] != '') {
                attachmentStore($data['product_thumbnail'], $product, Enum::PRODUCT_THUMBNAIL_IMAGE_DIR, Enum::ATTACHMENT_TYPE_THUMBNAIL);
            }

            // Gallery Image
            if (isset($data['images']) && $data['images'] != '') {
                foreach ($data['images'] as $image) {
                    attachmentStore($image, $product, Enum::PRODUCT_GALLERY_IMAGE_DIR, Enum::ATTACHMENT_TYPE_GALLERY);
                }
            }

            // Descriptions Image
            if (isset($data['description_image']) && $data['description_image'] != '') {
                attachmentStore($data['description_image'], $product, Enum::PRODUCT_DESCRIPTION_IMAGE_DIR, Enum::ATTACHMENT_TYPE_DESCRIPTION);
            }

            // Meta Image
            if (isset($data['meta_image']) && $data['meta_image'] != '') {
                attachmentStore($data['meta_image'], $product, Enum::PRODUCT_META_IMAGE_DIR, Enum::ATTACHMENT_TYPE_META);
            }

            DB::commit();

            return $this->handleSuccess('Successfully created');
        } catch (Exception $e) {
            DB::rollback();
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function update(Product $product, array $data): bool
    {
        DB::BeginTransaction();

        try {
            $requestData = request()->all();

            $data['operator_id'] = auth()->id();
            // $titleSlug = generateUniqueSlug($data['title'], Product::class);

            // Product Table
            $productTblData = [];
            $productTblData['category_id'] = $data['category_id'];
            $productTblData['brand_id'] = $data['brand_id'];
            // $productTblData['slug'] = $titleSlug . '-' . Str::uuid()->toString();
            $productTblData['type'] = isset($data['has_variant']) ? Enum::PRODUCT_TYPE_VARIANT : Enum::PRODUCT_TYPE_SIMPLE;
            $productTblData['unit'] = $data['unit'];
            $productTblData['unit_price'] = $data['unit_price'];
            $productTblData['purchase_price'] = $data['purchase_price'];
            $productTblData['weight'] = $data['weight'];
            $productTblData['barcode'] = $data['barcode'];
            $productTblData['has_variant'] = isset($data['has_variant']) ? $data['has_variant'] : null;

            if (isset($data['attribute_sets']) && count($data['attribute_sets']) > 0) {
                foreach($data['attribute_sets'] as $attributeSet) {
                    $setOfAttributes[] = $attributeSet;
                }

                $attributes = json_encode($setOfAttributes);
            } else {
                $attributes = json_encode([]);
            }

            $productTblData['attribute_sets'] = $attributes;
            $productTblData['current_stock'] = $data['current_stock'] ?? 0;
            $productTblData['minimum_order_quantity'] = $data['minimum_order_quantity'];
            $productTblData['stock_notification'] = $data['stock_notification'] ?? false;
            $productTblData['low_stock_to_notify'] = $data['low_stock_to_notify'];
            $productTblData['stock_visibility'] = $data['stock_visibility'];
            $productTblData['featured'] = isset($data['featured']) ? $data['featured'] : false;
            $productTblData['refundable'] = isset($data['refundable']) ? $data['refundable'] : false;
            
            $productTblData['has_product_base_shipping'] = isset($data['has_product_base_shipping']) ? $data['has_product_base_shipping'] : false;
            $productTblData['has_discount'] = isset($data['has_discount']) ? $data['has_discount'] : false;
            // $productTblData['cash_on_delivery'] = $data['cash_on_delivery'] ?? false;
            $productTblData['operator_id'] = $data['operator_id'];

            $product->update($productTblData);

            // Product language Table
            $productLanTblData['local'] = 'en';
            $productLanTblData['title'] = $data['title'];
            $productLanTblData['short_description'] = $data['short_description'];
            $productLanTblData['description'] = $data['description'];
            $productLanTblData['shipping_note'] = $data['shipping_note'] ?? '';
            $productLanTblData['meta_title'] = $data['meta_title'];
            $productLanTblData['meta_description'] = $data['meta_description'];

            if (isset($data['meta_keywords'][0]) && count($data['meta_keywords']) != 0) {
                $meta_keywords = explode(", ", $data['meta_keywords'][0]);

                foreach ($meta_keywords as $keyword) {
                    $key[] = $keyword;
                }

                $productLanTblData['meta_keywords'] = json_encode($key);
            }

            if (isset($data['tags'][0]) && count($data['tags']) != 0) {
                $tags = explode(", ", $data['tags'][0]);

                foreach ($tags as $keyword) {
                    $tag[] = $keyword;
                }

                $productLanTblData['tags'] = json_encode($tag);
            }

            $product->productLanguages->where('local', Enum::LANGUAGE_TYPE_ENGLISH)->first()->update($productLanTblData);

            // Product Details Table
            // $productDetailsTblData['shipping_type'] = $data['shipping_type'];
            // $productDetailsTblData['shipping_fee'] = $data['shipping_fee'] ?? 0;
            // $productDetailsTblData['shipping_fee_depend_on_quantity'] = $data['shipping_fee_depend_on_quantity'] ?? false;
            // $productDetailsTblData['shipping_fee_depend_on_weight'] = $data['shipping_fee_depend_on_weight'] ?? false;
            $productDetailsTblData['estimated_shipping_days'] = $data['estimated_shipping_days'];

            if (isset($data['has_discount'])) {
                $productDetailsTblData['discount'] = $data['discount'];
                $productDetailsTblData['discount_type'] = $data['discount_type'];
                $productDetailsTblData['discount_start'] = $data['discount_start'];
                $productDetailsTblData['discount_end'] = $data['discount_end'];
            } else {
                $productDetailsTblData['discount'] = null;
                $productDetailsTblData['discount_type'] = null;
                $productDetailsTblData['discount_start'] = null;
                $productDetailsTblData['discount_end'] = null;
            }

            $dimension = [
                'length' => $data['length'],
                'width'  => $data['width'],
                'height' => $data['height'],
            ];
            $productDetailsTblData['dimension'] = json_encode($dimension);
            $product->productDetails()->update($productDetailsTblData);

            // Product Stocks & Update Product Table
            if (isset($data['has_variant']) && count($data['variant_name']) > 0) {
                // Insert Product stock with new data
                $total_stock = 0;

                $reqStocks = $requestData['stock_id'];
                $dbStocks = $product->productStocks()->pluck('id');

                foreach ($dbStocks as $oldStockId) {
                    if (! in_array($oldStockId, $reqStocks)) {
                        $oldStock = ProductStock::with('attachment')->where('id', $oldStockId)->first();

                        if (isset($oldStock->attachment)) {
                            deleteFile($oldStock->getVariantImageAttribute());

                            $oldStock->attachment()->delete();
                        }

                        $oldStock->delete();
                    }
                }

                foreach ($requestData['stock_id'] as $key => $stockID) {

                    $product_stock = ProductStock::where('id', $stockID)->where('product_id', $product->id)->first();

                    if ($product_stock == '') {
                        $product_stock = new ProductStock();
                    }

                    if (isset($data['variant_image'])) {
                        $variantImage = array_keys($data['variant_image']);

                        if (in_array($key, $variantImage)) {

                            $stock = ProductStock::find($stockID);

                            if (isset($stock->attachment)) {
                                deleteFile($stock->getVariantImageAttribute());

                                $stock->attachment()->delete();
                            }
                        }
                    }

                    if ($data['variant_name'][$key]) {
                        $product_stock['product_id'] = $product->id;
                        $product_stock['variant_ids'] = $data['variant_ids'][$key];
                        $product_stock['name'] = $data['variant_name'][$key];
                        $product_stock['sku'] = $data['variant_sku'][$key];
                        $product_stock['current_stock'] = $data['variant_stock'][$key];
                        $product_stock['unit_price'] = $data['variant_price'][$key];

                        $product_stock->save();

                        // variant image insert into attachment table
                        if (isset($data['variant_image'][$key]) && $data['variant_image'][$key] != '') {
                            attachmentStore($data['variant_image'][$key], $product_stock, Enum::PRODUCT_VARIANT_IMAGE_DIR, Enum::ATTACHMENT_TYPE_VARIANT);
                        }

                        $total_stock += $product_stock->current_stock;
                    }

                    $selected_variants = [];
                    $selected_variants_ids = [];

                    if (isset($data['attribute_sets']) && count($data['attribute_sets']) > 0) {
                        foreach ($data['attribute_sets'] as $attributes_set) {
                            $attribute_values = 'attribute_values_' . $attributes_set;
                            $values = [];

                            if ($attribute_values) {
                                foreach ($requestData[$attribute_values] as $value) {
                                    array_push($values, $value);
                                    array_push($selected_variants_ids, $value);
                                }

                                $selected_variants[$attributes_set] = $values;
                            }
                        }
                    }

                    $product->selected_variants = $selected_variants;
                    $product->selected_variants_ids = $selected_variants_ids;
                }

                $product->current_stock = $total_stock;
                $product->save();
            } else {
                $productStocks = ProductStock::where('product_id', $product->id)->get();

                foreach ($productStocks as $stock) {
                    $stock->delete();
                }

                $product_stock = new ProductStock();
                $product_stock['variant_ids'] = null;
                $product_stock['product_id'] = $product->id;
                $product_stock['name'] = null;
                $product_stock['sku'] = $data['sku'];
                $product_stock['current_stock'] = $data['current_stock'];
                $product_stock['unit_price'] = $data['unit_price'];

                $product_stock->save();
            }

            if (isset($data['colors']) && $data['colors'] != '') {
                $product->colors()->sync($data['colors']);
            }

            // Product Service
            if (isset($data['product_service_title']) && count($data['product_service_title']) > 0) {

                $product->productServices->each(function ($productService) {
                    $productService->productServiceLanguages()->delete();

                    $productService->delete();
                });

                foreach ($data['product_service_title'] as $key => $serviceValue) {

                    if ($data['product_service_title'][$key]) {
                        $product_service['order'] = $data['product_service_order'][$key];
                        $product_service['product_id'] = $product->id;
                        $product_service['operator_id'] = auth()->id();
                        $productService = ModelsProductService::create($product_service);

                        $product_service_lang['product_service_id'] = $productService->id;
                        $product_service_lang['local'] = 'en';
                        $product_service_lang['title'] = $data['product_service_title'][$key];
                        $product_service_lang['sub_title'] = $data['product_service_sub_title'][$key];
                        ProductServiceLanguage::create($product_service_lang);
                    }
                }
            }

            // Product Thumbnail
            if (isset($data['product_thumbnail']) && $data['product_thumbnail'] != '') {
                $attachment = Attachment::where('attachable_type', Product::class)->where('attachable_id', $product->id)->where('for', Enum::ATTACHMENT_TYPE_THUMBNAIL)->first();

                deleteFile($product->getThumbnailAttribute());
                isset($attachment) ? $attachment->delete() : '';

                attachmentStore($data['product_thumbnail'], $product, Enum::PRODUCT_THUMBNAIL_IMAGE_DIR, Enum::ATTACHMENT_TYPE_THUMBNAIL);
            }

            // Gallery Image
            if (isset($requestData['old_images'])) {
                $oldImages = $requestData['old_images'];
                $attachments = Attachment::where('attachable_type', Product::class)->where('attachable_id', $product->id)->where('for', Enum::ATTACHMENT_TYPE_GALLERY)->get();

                foreach ($attachments as $attachment) {
                    if (! in_array($attachment->id, $oldImages)) {
                        deleteFile($attachment->attachment);

                        $attachment->delete();
                    }
                }
            }

            if (isset($data['images']) && $data['images'] != '') {
                foreach ($data['images'] as $image) {
                    attachmentStore($image, $product, Enum::PRODUCT_GALLERY_IMAGE_DIR, Enum::ATTACHMENT_TYPE_GALLERY);
                }
            }

            // Descriptions Image
            if (isset($data['description_image']) && $data['description_image'] != '') {
                $attachment = Attachment::where('attachable_type', Product::class)->where('attachable_id', $product->id)->where('for', Enum::ATTACHMENT_TYPE_DESCRIPTION)->first();

                deleteFile($product->getDescriptionAttribute());
                isset($attachment) ? $attachment->delete() : '';

                attachmentStore($data['description_image'], $product, Enum::PRODUCT_DESCRIPTION_IMAGE_DIR, Enum::ATTACHMENT_TYPE_DESCRIPTION);
            }

            // Meta Image
            if (isset($data['meta_image']) && $data['meta_image'] != '') {
                $attachment = Attachment::where('attachable_type', Product::class)->where('attachable_id', $product->id)->where('for', Enum::ATTACHMENT_TYPE_META)->first();

                deleteFile($product->getMetaImageAttribute());
                isset($attachment) ? $attachment->delete() : '';

                attachmentStore($data['meta_image'], $product, Enum::PRODUCT_META_IMAGE_DIR, Enum::ATTACHMENT_TYPE_META);
            }

            DB::commit();

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            DB::rollback();
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function isRefundable(Product $product): bool
    {
        try {
            $this->data = $product->update(['refundable' => !$product->refundable]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function changeStatus(Product $product): bool
    {
        $status = $product->status == Enum::PRODUCT_STATUS_PUBLISHED ? Enum::PRODUCT_STATUS_UNPUBLISHED : Enum::PRODUCT_STATUS_PUBLISHED;

        try {
            $this->data = $product->update(['status' => $status]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function changeFeature(Product $product): bool
    {
        try {
            $this->data = $product->update(['featured' => !$product->featured]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function changeApproveStatus(Product $product): bool
    {
        try {
            $this->data = $product->update(['approved' => !$product->approved]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function changeTodayDeal(Product $product): bool
    {
        try {
            $this->data = $product->update(['todays_deal' => !$product->todays_deal]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function changeRefundStatus(Product $product): bool
    {
        try {
            $this->data = $product->update(['refundable' => !$product->refundable]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function alertDataTable()
    {
        $data = Product::with('productStock', 'productStocks')->get()->filter(function($product) {
            return $product->low_stock_to_notify >= $product->productStock->current_stock;
        });

        return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('title', function ($row) {
                    $name = Str::limit($row?->getTranslation('title'), 30);
                    $route = url(config('app.url') . '/products/show/' . $row->slug);

                    return $row->deleted_at ? $this->getImage($row) . $name : $this->getImage($row) . '<a href="' . $route . '" class="text-primary pl-2" target="_blank">' . $name . '</a>';
                })
                ->editColumn('sku', function ($row) {
                    return $row->productStock->sku;
                })
                ->editColumn('alert_qty', function ($row) {
                    return $row->low_stock_to_notify;
                })
                ->editColumn('current_stock', function ($row) {
                    return $this->getCurrentStock($row);
                })
                ->rawColumns(['title', 'current_stock'])
                ->make(true);
    }

    //=====================  Seller  =====================//
    public function sellerProductDataTable($seller_id = null)
    {
        $query = Product::with('category', 'brand', 'operator', 'productLanguages', 'productStock', 'productStocks', 'ezzicoDiscount');

        if ($seller_id) {
            $query->where('seller_id', $seller_id);
        }
        $data = $query->get();

        return Datatables::of($data)
            ->addIndexColumn()

            ->editColumn('title', function ($row) {
                $name = $row->getTranslation('short_title');
                $url = url(config('app.url') . '/products/show/' . $row->slug);

                return $row->deleted_at ? $this->getImage($row) . $name : $this->getImage($row) . '<a target="_blank" href="' . $url . '" class="text-primary pl-2">' . $name . '</a>';
            })

            ->editColumn('category_id', function ($row) {
                return $row->category->getTranslation('title');
            })
            ->editColumn('brand', function ($row) {
                return $row->brand ? $row->brand->getTranslation('title') : 'N/A';
            })
            ->editColumn('unit', function ($row) {
                return $row->unit ? $row->unit : 'N/A';
            })
            ->editColumn('model', function ($row) {
                return $row->model ? $row->model : 'N/A';
            })
            ->editColumn('featured_image', function ($row) {
                return $this->getImage($row);
            })
            ->editColumn('operator_id', function ($row) {
                return $row?->operator?->full_name;
            })
            ->editColumn('is_active', function ($row) {
                return $this->getStatus($row);
            })
            ->editColumn('is_featured', function ($row) {
                $route = "'" . route('admin.product.change_feature', $row->id) . "'";
                $is_check = $row->featured ? "checked" : "";

                if ($row->status != Enum::PRODUCT_STATUS_TRASH && $row->deleted_at == null) {
                    return $this->getSwitch($row, $route, $is_check, 'featured');
                }

                return $this->getDisabledSwitch();
            })
            ->addColumn('action', function ($row) {
                return $this->actionHtml($row);
            })
            ->rawColumns(['action', 'is_active', 'is_featured', 'category_id', 'title', 'featured_image'])
            ->make(true);
    }

    // Product Review
    public function productReviewDataTable($data)
    {
        return Datatables::of($data)
            ->addIndexColumn()

            ->editColumn('customer_id', function ($row) {
                return  $row?->customer?->full_name;
            })
            ->editColumn('product_id', function ($row) {
                $name = $row?->product?->getTranslation('short_title');
                $url = url(config('app.url') . '/products/show/' . $row?->product?->slug);

                return '<a target="_blank" href="' . $url . '" class="text-primary pl-2">' . $name . '</a>';
            })
            ->editColumn('rating', function ($row) {
                return $row->rating;
            })
            ->editColumn('active', function ($row) {
                return $this->getStatusSwitch($row);
            })
            ->editColumn('comment', function ($row) {
                return $this->getComment($row);
            })
            ->rawColumns(['product_id', 'comment', 'active'])
            ->make(true);
    }

    public function reviewChangeStatus($review)
    {
        $status = $review->active == Enum::REVIEW_STATUS ? 1 : Enum::REVIEW_STATUS;

        try {
            $this->data = $review->update(['active' => $status]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function getComment($row)
    {
        $comment = substr($row->comment, 0, 60);
        $html = '';
        $html .= "<span> $comment </span>";

        if (Helper::hasAuthRolePermission('review_message')) {
            $html .= '.....<button type="button" class="btn p-0 text-success" onClick=(showComment((\'' . $row->id . '\')))> <i class="fa-solid fa-eye"></i> </button>';
        }

        return $html;
    }

    private function getStatusSwitch($row)
    {
        $is_check = $row->active ? "checked" : "";
        $route1 = "'" . route('admin.product.review_change_status', $row->id) . "'";

        $disabled = '';
        if (! Helper::hasAuthRolePermission('review_status')) {
            $disabled = 'disabled';
        }

        return '<div class="custom-control custom-switch">
                    <input type="checkbox" ' . $disabled . '
                        onchange="changeReviewStatus(event, ' . $route1 . ')"
                        class="custom-control-input"
                        id="reviewSwitch_' . $row->id . '" ' . $is_check . ' >
                    <label class="custom-control-label" for="reviewSwitch_' . $row->id . '"></label>
                </div>';
    }
}
