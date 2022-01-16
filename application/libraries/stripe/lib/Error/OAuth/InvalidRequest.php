<?php

declare(strict_types=1);

namespace Stripe\Error\OAuth;

/**
 * InvalidRequest is raised when a code, refresh token, or grant type
 * parameter is not provided, but was required.
 */
class InvalidRequest extends OAuthBase
{
}
