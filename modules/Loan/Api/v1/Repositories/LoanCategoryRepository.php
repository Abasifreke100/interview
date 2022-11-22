<?php


namespace LoanHistory\Modules\Loan\Api\v1\Repositories;


use LoanHistory\Modules\BaseRepository;
use LoanHistory\Modules\Loan\Models\LoanCategory;

class LoanCategoryRepository extends BaseRepository
{

    protected $category;

    public function __construct(LoanCategory $category)
    {
        $this->category = $category;
    }

    public function add($request){

        $category = $this->category->create([
            "id" => $this->generateUuid(),
            "name" => ucfirst($request->name),
            "slug" => strtolower($request->slug)
        ]);
        if (!$category){
            return $this->failResponse("Unable to add category",422);
        }

        return $category;
    }

    public function index(){
        return $this->category->orderBy("name","ASC")
                              ->paginate(10);
    }

    public function show($id){
        $category = $this->category->find($id);
        if (!$category){
            return [
                "status_code"=>404,
                "message"=>"Category not found"
            ];
        }
        return $category;
    }

    public function update($request, $id){
        $category = $this->category->find($id);

        if (!$category){
            return $this->failResponse("Category not found", 404);
        }
        $category->update([
            "name" => ucfirst($request->name),
            "slug" =>strtolower($request->slug)
        ]);

        return $category;
    }

    public function delete($id){
        $category = $this->category->find($id);
        $category->delete();
    }


}
