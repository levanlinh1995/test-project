<?php
namespace App\Repositories\Product;

use App\Repositories\BaseRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function getModel()
    {
        return Product::class;
    }

    public function loadPaginate(array $params = [], $limit = 10)
    {
        return $this->_model
            ->when($sku = isset($params['sku']) ? $params['sku'] : false,
                function ($q, $sku) {
                    $q->where('sku', 'like', '%'.$sku.'%');
                }
            )
            ->orderBy('id', 'desc')
            ->paginate($limit);
    }

    public function findBySku(string $sku)
    {
        return $this->_model
            ->where('sku', $sku)
            ->first();
    }
}