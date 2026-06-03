<?php

namespace App\Library\Services\Seller;

use Exception;
use App\Library\Helper;
use App\Models\Product;
use App\Models\ProductQuestion;
use Yajra\DataTables\Facades\DataTables;
use App\Library\Services\Admin\BaseService;

class QuestionAnswerService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';
        $route = route('seller.product.question.delete', [$row->product_id, $row->id]);

        if ($row->id) {
            $answer = ProductQuestion::where('parent_id', $row->id)->first();

            if (Helper::hasAuthRolePermission('seller_product_question_answer') && !$answer) {
                $actionHtml .= '<a class="dropdown-item text-secondary" href="javascript:void(0)" onclick="clickAnswerModal(' . $row->id . ')" ><i class="far fa-edit"></i> Answer </a>';
            }

            if (Helper::hasAuthRolePermission('seller_product_question_delete')) {
                $actionHtml .= '<button class="dropdown-item text-danger" onclick="confirmFormModal(\'' . $route . '\', \'Confirmation\', \'Are you sure to delete?\');"><i class="fa fa-trash-alt"></i> Delete</button>';
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

    public function dataTable(Product $product)
    {
        $data = ProductQuestion::getProductQuestion($product->id);

        return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('customer_id', function ($row) {
                    return $row?->customer?->full_name ?? 'Anonymous';
                })
                ->editColumn('answer', function ($row) {
                    return $this->getAnswer($row);
                })
                ->addColumn('active', function ($row) {
                    return $this->getSwitch($row);
                })
                ->addColumn('action', function ($row) {
                    return $this->actionHtml($row);
                })

                ->rawColumns(['answer', 'active', 'action'])
                ->make(true);
    }

    public function getAnswer($row)
    {
        $answer = ProductQuestion::where('parent_id', $row->id)->first();
        
        if ($answer) {
            $html = '';
            $answerSubStr = substr($answer->comment, 0, 30);
            $html .= "<span>$answerSubStr</span>";

            $answerLength = strlen($answer->comment);

            if ($answerLength > 30) {
                $html .= '...<button type="button" class="btn p-0 text-primary" onClick="readMore(\''.$answer->comment.'\')">Read More</button>';
            }

            return $html;
        }
        
        return '<span class="text-danger">No answer yet</span>';
    }

    private function getSwitch($row)
    {
        $route = "";
        $disabled = 'disabled';
        $is_check = $row->active ? "checked" : "";

        $permission = Helper::hasAuthRolePermission('seller_product_question_change_status');

        if ($permission) {
            $disabled = '';
            $route = "'" . route('seller.product.question.change_status', [$row->product_id, $row->id]) . "'";
        }

        return '<label class="custom-switch" for="primarySwitch_' . $row->id . '">
                    <input type="checkbox" class="custom-switch-input"
                        id="primarySwitch_' . $row->id . '" ' . $is_check . '
                        onchange="changeStatus(event, ' . $route . ')"
                        ' . $disabled . '>
                    <span class="custom-switch-indicator"></span>
                </label>';
    }

    public function storeAnswer(Product $product, ProductQuestion $productQuestion, array $data): bool
    {
        try {
            $data['comment'] = $data['answer'];
            $data['customer_id'] = $productQuestion->customer_id;
            $data['seller_id'] = authSellerId();
            $data['product_id'] = $product->id;
            $data['parent_id'] = $productQuestion->id;

            unset($data['id'], $data['question'], $data['answer']);

            $this->data = ProductQuestion::create($data);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function changeStatus(ProductQuestion $productQuestion): bool
    {
        try {
            $this->data = $productQuestion->update(['active' => !$productQuestion->active]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function delete(ProductQuestion $productQuestion): bool
    {
        try {
            $productQuestion->delete();

            $this->message = __('Successfully deleted');

            return true;
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }
}
