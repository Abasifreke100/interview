<?php
namespace LoanHistory\Modules;

use App\Http\Controllers\Controller;
//use Dingo\Api\Routing\Helpers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Serializer\ArraySerializer;
use function is_string;
use function response;



class BaseController extends Controller
{

    use DispatchesJobs, ValidatesRequests, AuthorizesRequests;

    /**
     *
     * Format paginated data from a collection
     *
     * @param $paginator
     * @param $transformer
     * @param null $resourceName
     * @return \Illuminate\Http\JsonResponse [type]                [return description]
     */
    protected function successWithPages($paginator, $transformer, $resourceName = null)
    {
        $collection = $paginator->getCollection();

        if (!$resourceName) {
            $resourceName = 'items';
        }

        $data = fractal()
            ->collection($collection)
            ->transformWith($transformer)
            ->serializeWith(new ArraySerializer())
            ->withResourceName($resourceName)
            ->paginateWith(new IlluminatePaginatorAdapter($paginator))
            ->toArray();

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    protected function transformPages($paginator, $transformer, $resourceName = null)
    {
        $collection = $paginator->getCollection();

        if (!$resourceName) {
            $resourceName = 'items';
        }

        return fractal()
            ->collection($collection)
            ->transformWith($transformer)
            ->serializeWith(new ArraySerializer())
            ->withResourceName($resourceName)
            ->paginateWith(new IlluminatePaginatorAdapter($paginator))
            ->toArray();


    }

    protected function transform($model, $transformer)
    {
        $data = fractal($model, $transformer)->serializeWith(new \Spatie\Fractalistic\ArraySerializer());
        return $this->success($data);
    }

    /**
     * Format successful request response
     *
     * @param   [mixed]  $data  A string or array
     *
     * @return \Illuminate\Http\JsonResponse [object]        JSON object
     */
    protected function success($data)
    {
        return response()->json(
            [
                'status' => 'success',
                'data' => $data,
            ]
        );
    }

    protected function handleErrorResponse($response)
    {
        if (isset($response['error'])) {
            return $this->error($response['message'], $response['status_code']);
        }

        return $this->fail($response['message'], $response['status_code']);
    }

    /**
     * This handle formatted API error responses
     * @param $data
     * @param $code (optional) HTTP Error code
     */
    protected function error($data, $code = null)
    {
        if (!$code || is_string($code)) {
            $code = 422;
        }

        return response()->json([
            'status' => 'error',
            'message' => $data,

        ], $code);
    }

    protected function fail($data, $code = null)
    {
        if (!$code || is_string($code)) {
            $code = 422;
        }

        return response()->json([
            'status' => 'fail',
            'data' => $data,

        ], $code);
    }

}
