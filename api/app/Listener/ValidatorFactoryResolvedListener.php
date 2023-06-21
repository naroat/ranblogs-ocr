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
namespace App\Listener;

use App\Traits\Util;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Validation\Event\ValidatorFactoryResolved;

/**
 * @Listener
 */
class ValidatorFactoryResolvedListener implements ListenerInterface
{

    public function listen(): array
    {
        return [
            ValidatorFactoryResolved::class
        ];
    }

    public function process(object $event)
    {
        $validatorFactory = $event->validatorFactory;

        $validatorFactory->extend('phone', function ($attribute, $value) {
            return Util::isPhone($value);
        });
    }
}
