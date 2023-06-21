<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\Controller;

use App\Exception\ServiceException;

class IndexController extends AbstractController
{
    public function index()
    {
        var_dump('api------');
    }

    public function openapi()
    {
        var_dump('openapi---------');
    }
}
