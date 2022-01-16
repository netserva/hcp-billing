<?php

declare(strict_types=1);

namespace Stripe\Exception;

/**
 * PermissionException is thrown in cases where access was attempted on a
 * resource that wasn't allowed.
 */
class PermissionException extends ApiErrorException
{
}
