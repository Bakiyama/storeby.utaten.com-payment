<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class OrderStatus extends Enum
{
    const OPEN = 'open';
    const SUCCESS = 'success';
    const PROCESSING = 'processing';
    const SHIPPED = 'shipped';
    const CANCELED = 'canceled';
    const FAILED = 'failed';
}
