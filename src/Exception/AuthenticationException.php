<?php


namespace SchierProducts\SchierProductApi\Exception;

/**
 * AuthenticationException is thrown when invalid credentials are used to
 * connect to Schier's servers.
 */
class AuthenticationException extends ApiErrorException
{
    public ?int $httpStatus = 403;
}