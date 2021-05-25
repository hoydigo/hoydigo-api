<?php

namespace App\Exceptions;

use Exception;

/**
 * Class TwitterClientCouldNotGetUserByUsernameException
 *
 * Should be thrown when there is an error getting the twitter user data
 * by username in /Classes/Twitter/Client
 *
 * @package App\Exceptions
 */
class TwitterClientCouldNotGetUserByUsernameException extends Exception {}
