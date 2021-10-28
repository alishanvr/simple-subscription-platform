<?php

/**
 * Any issue like data not inserted or updated form Server Side
 */
if (!defined('STATUS_SERVER_SIDE_ISSUE'))
    define('STATUS_SERVER_SIDE_ISSUE', 502);

/**
 * General - All types of Fail
 */
if (!defined('STATUS_GENERAL_FAIL'))
    define('STATUS_GENERAL_FAIL', 400);

/**
 * Like X-Authorization token not Found or Wrong auth token
 */
if (!defined('STATUS_AUTHENTICATION_FAILED'))
    define('STATUS_AUTHENTICATION_FAILED', 401);

/**
 * Any permission - Role issue
 */
if (!defined('STATUS_PERMISSION_DENIED'))
    define('STATUS_PERMISSION_DENIED', 403);

/**
 * Not Found
 */
if (!defined('STATUS_NOT_FOUND'))
    define('STATUS_NOT_FOUND', 404);

/**
 * Already Exists
 */
if (!defined('STATUS_ALREADY_EXISTS'))
    define('STATUS_ALREADY_EXISTS', 409);

/**
 * OK - Response
 */
if (!defined('STATUS_OK'))
    define('STATUS_OK', 200);

/**
 * OK - Already Exist
 */
if (!defined('STATUS_EXIST'))
    define('STATUS_EXIST', 300);
