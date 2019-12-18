<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')                 OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')                   OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')                  OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')            OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')           OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD')          OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')              OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')                OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')               OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')               OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


const HTTP_CONTINUE = 100;
const HTTP_SWITCHING_PROTOCOLS = 101;
const HTTP_PROCESSING = 102;            // RFC2518
const HTTP_OK = 200;
const HTTP_CREATED = 201;
const HTTP_ACCEPTED = 202;
const HTTP_NON_AUTHORITATIVE_INFORMATION = 203;
const HTTP_NO_CONTENT = 204;
const HTTP_RESET_CONTENT = 205;
const HTTP_PARTIAL_CONTENT = 206;
const HTTP_MULTI_STATUS = 207;          // RFC4918
const HTTP_ALREADY_REPORTED = 208;      // RFC5842
const HTTP_IM_USED = 226;               // RFC3229
const HTTP_MULTIPLE_CHOICES = 300;
const HTTP_MOVED_PERMANENTLY = 301;
const HTTP_FOUND = 302;
const HTTP_SEE_OTHER = 303;
const HTTP_NOT_MODIFIED = 304;
const HTTP_USE_PROXY = 305;
const HTTP_RESERVED = 306;
const HTTP_TEMPORARY_REDIRECT = 307;
const HTTP_PERMANENTLY_REDIRECT = 308;  // RFC7238
const HTTP_BAD_REQUEST = 400;
const HTTP_UNAUTHORIZED = 401;
const HTTP_PAYMENT_REQUIRED = 402;
const HTTP_FORBIDDEN = 403;
const HTTP_NOT_FOUND = 404;
const HTTP_METHOD_NOT_ALLOWED = 405;
const HTTP_NOT_ACCEPTABLE = 406;
const HTTP_PROXY_AUTHENTICATION_REQUIRED = 407;
const HTTP_REQUEST_TIMEOUT = 408;
const HTTP_CONFLICT = 409;
const HTTP_GONE = 410;
const HTTP_LENGTH_REQUIRED = 411;
const HTTP_PRECONDITION_FAILED = 412;
const HTTP_REQUEST_ENTITY_TOO_LARGE = 413;
const HTTP_REQUEST_URI_TOO_LONG = 414;
const HTTP_UNSUPPORTED_MEDIA_TYPE = 415;
const HTTP_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
const HTTP_EXPECTATION_FAILED = 417;
const HTTP_I_AM_A_TEAPOT = 418;                                               // RFC2324
const HTTP_MISDIRECTED_REQUEST = 421;                                         // RFC7540
const HTTP_UNPROCESSABLE_ENTITY = 422;                                        // RFC4918
const HTTP_LOCKED = 423;                                                      // RFC4918
const HTTP_FAILED_DEPENDENCY = 424;                                           // RFC4918
const HTTP_RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL = 425;   // RFC2817
const HTTP_UPGRADE_REQUIRED = 426;                                            // RFC2817
const HTTP_PRECONDITION_REQUIRED = 428;                                       // RFC6585
const HTTP_TOO_MANY_REQUESTS = 429;                                           // RFC6585
const HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;                             // RFC6585
const HTTP_UNAVAILABLE_FOR_LEGAL_REASONS = 451;
const HTTP_INTERNAL_SERVER_ERROR = 500;
const HTTP_NOT_IMPLEMENTED = 501;
const HTTP_BAD_GATEWAY = 502;
const HTTP_SERVICE_UNAVAILABLE = 503;
const HTTP_GATEWAY_TIMEOUT = 504;
const HTTP_VERSION_NOT_SUPPORTED = 505;
const HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL = 506;                        // RFC2295
const HTTP_INSUFFICIENT_STORAGE = 507;                                        // RFC4918
const HTTP_LOOP_DETECTED = 508;                                               // RFC5842
const HTTP_NOT_EXTENDED = 510;                                                // RFC2774
const HTTP_NETWORK_AUTHENTICATION_REQUIRED = 511;                             // RFC6585
