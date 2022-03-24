<?php

namespace App\Repositories\User;

interface UserRepositoryInterface {
    public function loadPaginate(array $params = [], $limit = 20);
}
