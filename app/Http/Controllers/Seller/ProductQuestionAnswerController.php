<?php

namespace App\Http\Controllers\Seller;

use App\Models\Product;
use App\Library\Response;
use Illuminate\Http\Request;
use App\Models\ProductQuestion;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Library\Services\Seller\QuestionAnswerService;
use App\Http\Requests\Seller\Product\ProductQuestion\AnswerRequest;

class ProductQuestionAnswerController extends Controller
{
    use ApiResponse;

    private $question_answer_service;

    public function __construct(QuestionAnswerService $question_answer_service)
    {
        $this->question_answer_service = $question_answer_service;
    }

    public function index(Product $product, Request $request)
    {
        if ($request->ajax()) {
            return $this->question_answer_service->dataTable($product);
        }

        return view('seller.pages.product.questions.index', [
            'product' => $product,
        ]);
    }

    public function answer(Product $product, ProductQuestion $productQuestion)
    {
        return $productQuestion;
    }

    public function storeAnswer(Product $product, ProductQuestion $productQuestion, AnswerRequest $request)
    {
        $result = $this->question_answer_service->storeAnswer($product, $productQuestion, $request->validated());

        if ($result) {
            return Response::success(__('Successfully updated'));
        }

        return Response::error(__('Unable to answer'), [], 500);
    }

    public function changeStatus(Request $request, Product $product, ProductQuestion $productQuestion)
    {
        abort_unless($productQuestion, 404);

        $result = $this->question_answer_service->changeStatus($productQuestion);

        if ($result) {
            return redirect()->back()->with('success', $this->question_answer_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->question_answer_service->message);
    }

    public function destroy(Product $product, ProductQuestion $productQuestion): RedirectResponse
    {
        abort_unless($productQuestion, 404);

        $result = $this->question_answer_service->delete($productQuestion);

        if ($result) {
            return redirect()->back()->with('success', "Successfully Delete");
        }

        return back()->with('error', 'Unable to delete now');
    }
}
