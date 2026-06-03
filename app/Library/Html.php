<?php

namespace App\Library;

class Html
{
    public static function linkBack(string $route)
    {
        return '<a href="' . $route . '" class="btn btn-sm btn2-secondary btn-back "><i class="fas fa-long-arrow-alt-left"></i> Back</a>';
    }

    public static function linkAdd(string $route, string $label, string $size = 'btn-sm')
    {
        return '<a href="' . $route . '" class="btn btn-sm btn2-secondary ' . $size . '"><i class="fas fa-plus"></i> ' . $label . '</a>';
    }

    public static function btnSubmit($size = '')
    {
        return '<button type="submit" class="btn mr-3 my-3 btn2-secondary submitBtn ' . $size . '"><i class="fas fa-save"></i> Save</button>';
    }

    public static function btnSubmitWithJs($size = '')
    {
        return '<input type="hidden" name="token" value="' . uniqid() . '"/> <button type="submit" onclick="this.disabled=true; this.form.submit();" class="btn mr-3 my-3 btn2-secondary submitBtn ' . $size . '"><i class="fas fa-save"></i> Save</button>';
    }

    public static function btnReset()
    {
        return '<button type="reset" class="btn mr-3 my-3 btn2-light-secondary"><i class="fas fa-sync-alt"></i> Reset</button>';
    }

    public static function btnClose()
    {
        return '<button type="button" class="btn btn2-light-secondary mr-3 btn-close" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>';
    }

    public static function btnSignIN($size = '')
    {
        return '<button type="submit" class="btn mr-3 my-3 btn2-secondary ' . $size . '"><i class="fa-solid fa-right-to-bracket"></i> Sign In </button>';
    }

    public static function btnSignOut($size = '')
    {
        return '<button type="submit" class="btn mr-3 my-3 btn2-danger-active ' . $size . '"><i class="fa-solid fa-right-from-bracket"></i> Sign Out </button>';
    }

    public static function stockStatusBadge($status)
    {
        $class = [
            Enum::STOCK_AVAILABLE => 'btn2-secondary',
            Enum::STOCK_ASSIGNED  => 'btn-primary',
            Enum::STOCK_WARRANTY  => 'btn-secondary',
            Enum::STOCK_DAMAGED   => 'btn-warning',
            Enum::STOCK_MISSING   => 'btn-dark',
            Enum::STOCK_EXPIRED   => 'btn-danger',
            Enum::STOCK_RETURN    => 'btn2-secondary',
            Enum::STOCK_OUT       => 'btn2-secondary',
        ];

        return '<span class="badge ' . $class[$status] . '">' . Enum::getStockStatus($status) . '</span>';
    }

    public static function ReferralStatusBadge($status)
    {
        $class = [
            Enum::REFERRAL_STATUS_ENROLLED  => 'badge-success',
            Enum::REFERRAL_STATUS_DECLINED  => 'badge-danger',
            Enum::REFERRAL_STATUS_DISCHARGE => 'badge-info',
            'Re-refer'                      => 'badge-warning',
        ];

        return '<div class="badge ' . $class[$status] . '">' . ucwords($status) . '</div>';
    }

    public static function ReferralStatusClass($status)
    {
        $class = [
            Enum::REFERRAL_STATUS_ENROLLED  => 'success',
            Enum::REFERRAL_STATUS_DECLINED  => 'danger',
            Enum::REFERRAL_STATUS_DISCHARGE => 'info',
            'Re-refer'                      => 'warning',
        ];

        return $class[$status];
    }

    public static function AcknoledgementStatus($status)
    {
        if($status == 1) {
            $badge = '<div class="badge btn2-secondary"> Accept </div>';
        } else {
            $badge = '<div class="badge badge-danger">Pending</div>';
        }

        return $badge;
    }

    public static function ImmunizationStatus($status)
    {
        if($status == Enum::IMMUNIZATION_STATUS_COMPLETE) {
            $badge = '<div class="badge btn2-secondary"> Complete </div>';
        } elseif($status == Enum::IMMUNIZATION_STATUS_PENDING) {
            $badge = '<div class="badge badge-warning">Pending</div>';
        } else {
            $badge = '<div class="badge badge-danger">Canceled</div>';
        }

        return $badge;
    }

    public static function breadcrumbsSection($name = '', $route_name = '', $route = '', $route_type = '', $modal = '')
    {
        $back_route = '';

        if($route && $route_name) {
            $back_route .= '<li class="breadcrumb-item"><a href="' . $route . '">' . $route_name . '</a></li>';
        }

        if($route_type == 'category' && $modal != '') {
            if($modal?->parent?->parent) {
                $back_route .= '<li class="breadcrumb-item"><a href="' . route('public.product.category_wise', $modal?->parent?->parent->slug) . '">' . $modal?->parent?->parent->getTranslation('title') . '</a></li>';
            }

            if($modal?->parent) {
                $back_route .= '<li class="breadcrumb-item"><a href="' . route('public.product.category_wise', $modal?->parent->slug) . '">' . $modal?->parent->getTranslation('title') . '</a></li>';
            }

            $back_route .= '<li class="breadcrumb-item"><a href="' . route('public.product.category_wise', $modal->slug) . '">' . $modal->getTranslation('title') . '</a></li>';
        }

        if($route_type == 'product' && $modal != '') {
            if($modal?->category?->parent?->parent) {
                $back_route .= '<li class="breadcrumb-item"><a href="' . route('public.product.category_wise', $modal?->category?->parent?->parent->slug) . '">' . $modal?->category?->parent?->parent->getTranslation('title') . '</a></li>';
            }

            if($modal?->category?->parent) {
                $back_route .= '<li class="breadcrumb-item"><a href="' . route('public.product.category_wise', $modal?->category?->parent->slug) . '">' . $modal?->category?->parent->getTranslation('title') . '</a></li>';
            }

            $back_route .= '<li class="breadcrumb-item"><a href="' . route('public.product.category_wise', $modal?->category?->slug) . '">' . $modal?->category?->getTranslation('title') . '</a></li>';
        }

        if($route_type == 'brand' && $modal != '') {
            $back_route .= '<li class="breadcrumb-item">
            <a href="' . route('public.brand.index') . '">Brands</a>
            </li>
            <li class="breadcrumb-item">
            <a href="' . route('public.product.brand_wise', $modal->slug) . '">' . $modal->getTranslation('title') . '</a>
            </li>';
        }

        if($route_type == 'shop' && $modal != '') {
            $back_route .= '<li class="breadcrumb-item">
            <a href="' . route('public.seller.seller_shop', $modal->store->slug) . '">' . $modal->store?->getTranslation('store_name') . '</a>
            </li>';
        }

        return  '<section class="breadcrumb-section pt-1">
                    <div class="container-fluid-lg">
                        <div class="row">
                            <div class="col-12">
                                <div class="breadcrumb-contain">
                                    <nav>
                                        <ol class="breadcrumb mb-0">
                                            <li class="breadcrumb-item">
                                                <a href="' . url('/') . '">
                                                    <i class="fa-solid fa-house"></i>
                                                </a>
                                            </li>
                                            ' . $back_route . '
                                            <li class="breadcrumb-item active">' . ($route_type == 'product' ? $modal->getTranslation('title') : $name) . '</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>';
    }

    public static function StockBadge($stock, $stock_status)
    {
        $badge = '';

        if($stock > 0) {
            if($stock_status != Enum::VISIBILITY_STATUS_HIDE_STOCK) {
                $badge .= '<h6 class="in-stock"><i class="far fa-circle-check"></i> In Stock ';

                if($stock_status == Enum::VISIBILITY_STATUS_VISIBLE_WITH_QUANTITY) {
                    $badge .= '<span> ' . $stock . '</span>';
                }
                $badge .= '</h6>';
            }
        } else {
            $badge .= '<h6 class="outof-stock"><i class="far fa-circle-xmark"></i> Out Of Stock</h6>';
        }

        return $badge;
    }

    public static function rating($rating)
    {
        $star = $half_star = $empty_star = '';

        if (is_numeric($rating)) {
            if(fmod($rating, 1) !== 0.00) {
                for ($i = 1; $i < $rating; $i++) {
                    $star .= '<li class="text-yellow"><i class="fa fa-star"></i></li>';
                }
                $half_star .= '<li class="text-yellow"><i class="fa fa-star-half-o"></i></li>';

                for ($i = 0; $i < 4 - $rating; $i++) {
                    $empty_star .= '<li class="text-yellow"><i class="fa fa-star-o"></i></li>';
                }
            } else {
                for ($i = 0; $i < $rating; $i++) {
                    $star .= '<li class="text-yellow"><i class="fa fa-star"></i></li>';
                }

                for ($i = 0; $i < 5 - $rating; $i++) {
                    $empty_star .= '<li class="text-yellow"><i class="fa fa-star-o"></i></li>';
                }
            }
        } else {
            $empty_star .= '<li class="text-yellow"><i class="fa fa-star-o"></i></li>';
            $empty_star .= '<li class="text-yellow"><i class="fa fa-star-o"></i></li>';
            $empty_star .= '<li class="text-yellow"><i class="fa fa-star-o"></i></li>';
            $empty_star .= '<li class="text-yellow"><i class="fa fa-star-o"></i></li>';
            $empty_star .= '<li class="text-yellow"><i class="fa fa-star-o"></i></li>';
        }

        return '<ul class="rating">' . $star . $half_star . $empty_star . '</ul>';
    }

    public static function ReturnStatus($status)
    {
        $class = '';

        if($status == Enum::RETURN_STATUS_PENDING) {
            $class = 'bg-warning text-dark';
        } elseif($status == Enum::RETURN_STATUS_APPROVED) {
            $class = 'bg-success';
        } elseif($status == Enum::RETURN_STATUS_REJECTED) {
            $class = 'bg-danger';
        } else {
            $class = 'bg-primary';
        }

        return '<label  class="py-1 badge ' . $class . '">' . Enum::getReturnStatusType($status) . '</label>';
    }
}
