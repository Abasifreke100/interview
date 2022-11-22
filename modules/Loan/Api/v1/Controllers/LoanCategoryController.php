<?php


namespace LoanHistory\Modules\Loan\Api\v1\Controllers;


use Illuminate\Http\Request;
use LoanHistory\Modules\BaseController;
use LoanHistory\Modules\Loan\Api\v1\Repositories\LoanCategoryRepository;
use LoanHistory\Modules\Loan\Api\v1\Transformers\LoanCategoryTransformer;

class LoanCategoryController extends BaseController
{

    protected $loanCategoryRepository;

    protected $loanCategoryTransformer;

    public function __construct(LoanCategoryRepository $loanCategoryRepository,
                                LoanCategoryTransformer $loanCategoryTransformer)
    {
        $this->loanCategoryRepository = $loanCategoryRepository;

        $this->loanCategoryTransformer = $loanCategoryTransformer;
    }

    public function add(Request $request){

        $this->validate($request, [
            "name"=>"required",
            "slug"=>"required"
        ]);

        $category = $this->loanCategoryRepository->add($request);

        if (!isset($category['status_code'])){
            return $this->transform($category, $this->loanCategoryTransformer);
        }

        return $this->handleErrorResponse($category);
    }

    public function index(){
        $loanCategory = $this->loanCategoryRepository->index();
        return $this->successWithPages($loanCategory, $this->loanCategoryTransformer,'loan_categories');
    }


    public function show($id){
        $data = $this->loanCategoryRepository->show($id);

        if (!isset($data['status_code'])){
            return $this->transform($data, $this->loanCategoryTransformer);
        }

        return $this->handleErrorResponse($data);
    }

    public function update(Request $request, $id){

        $this->validate($request, [
            "name" => "required",
            "slug" => "required"
        ]);
        $category = $this->loanCategoryRepository->update($request, $id);

        if (!isset($category['status_code'])){
            return $this->transform($category, $this->loanCategoryTransformer);
        }

        return $this->handleErrorResponse($category);
    }

    public function delete($id){
        $this->loanCategoryRepository->delete($id);

        return response()->json(["Category deleted successfully", 200]);
    }
}
