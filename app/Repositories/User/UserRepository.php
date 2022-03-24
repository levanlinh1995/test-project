<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function getModel()
    {
        return User::class;
    }

    public function loadPaginate(array $params = [], $limit = 20)
    {
        return $this->_model
            ->when($keyword = isset($params['keyword']) ? $params['keyword'] : false,
                function ($q, $keyword) {
                    $q->where(function ($q) use ($keyword) {
                        $q
                            ->where('name', 'like', '%'.$keyword.'%')
                            ->orWhere('email', 'like', '%'.$keyword.'%');
                    });
                }
            )
            ->orderBy('id', 'desc')
            ->paginate($limit);
    }
}
