<?php

namespace Base\Rest;

class HttpStatus 
{

    // Note: Only the widely used HTTP status codes are documented

    // Informational
    const CONTINUE = 100;
    const SWITCHING_PROTOCOLS = 101;
    const PROCESSING = 102;            // RFC2518

    // Success
    /**
     * The request has succeeded
     */
    const OK = 200;

    /**
     * The server successfully created a new resource
     */
    const CREATED = 201;
    const ACCEPTED = 202;
    const NON_AUTHORITATIVE_INFORMATION = 203;

    /**
     * The server successfully processed the request, though no content is returned
     */
    const NO_CONTENT = 204;
    const RESET_CONTENT = 205;
    const PARTIAL_CONTENT = 206;
    const MULTI_STATUS = 207;          // RFC4918
    const ALREADY_REPORTED = 208;      // RFC5842
    const IM_USED = 226;               // RFC3229

    // Redirection

    const MULTIPLE_CHOICES = 300;
    const MOVED_PERMANENTLY = 301;
    const FOUND = 302;
    const SEE_OTHER = 303;

    /**
     * The resource has not been modified since the last request
     */
    const NOT_MODIFIED = 304;
    const USE_PROXY = 305;
    const RESERVED = 306;
    const TEMPORARY_REDIRECT = 307;
    const PERMANENTLY_REDIRECT = 308;  // RFC7238

    // Client Error

    /**
     * The request cannot be fulfilled due to multiple errors
     */
    const BAD_REQUEST = 400;

    /**
     * The user is unauthorized to access the requested resource
     */
    const UNAUTHORIZED = 401;
    const PAYMENT_REQUIRED = 402;

    /**
     * The requested resource is unavailable at this present time
     */
    const FORBIDDEN = 403;

    /**
     * The requested resource could not be found
     *
     * Note: This is sometimes used to mask if there was an UNAUTHORIZED (401) or
     * FORBIDDEN (403) error, for security reasons
     */
    const NOT_FOUND = 404;

    /**
     * The request method is not supported by the following resource
     */
    const METHOD_NOT_ALLOWED = 405;

    /**
     * The request was not acceptable
     */
    const NOT_ACCEPTABLE = 406;
    const PROXY_AUTHENTICATION_REQUIRED = 407;
    const REQUEST_TIMEOUT = 408;

    /**
     * The request could not be completed due to a conflict with the current state
     * of the resource
     */
    const CONFLICT = 409;
    const GONE = 410;
    const LENGTH_REQUIRED = 411;
    const PRECONDITION_FAILED = 412;
    const REQUEST_ENTITY_TOO_LARGE = 413;
    const REQUEST_URI_TOO_LONG = 414;
    const UNSUPPORTED_MEDIA_TYPE = 415;
    const REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    const EXPECTATION_FAILED = 417;
    const I_AM_A_TEAPOT = 418;                                               // RFC2324
    const UNPROCESSABLE_ENTITY = 422;                                        // RFC4918
    const LOCKED = 423;                                                      // RFC4918
    const FAILED_DEPENDENCY = 424;                                           // RFC4918
    const RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL = 425;   // RFC2817
    const UPGRADE_REQUIRED = 426;                                            // RFC2817
    const PRECONDITION_REQUIRED = 428;                                       // RFC6585
    const TOO_MANY_REQUESTS = 429;                                           // RFC6585
    const REQUEST_HEADER_FIELDS_TOO_LARGE = 431;                             // RFC6585

    // Server Error

    /**
     * The server encountered an unexpected error
     *
     * Note: This is a generic error message when no specific message
     * is suitable
     */
    const INTERNAL_SERVER_ERROR = 500;

    /**
     * The server does not recognise the request method
     */
    const NOT_IMPLEMENTED = 501;
    const BAD_GATEWAY = 502;
    const SERVICE_UNAVAILABLE = 503;
    const GATEWAY_TIMEOUT = 504;
    const VERSION_NOT_SUPPORTED = 505;
    const VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL = 506;                        // RFC2295
    const INSUFFICIENT_STORAGE = 507;                                        // RFC4918
    const LOOP_DETECTED = 508;                                               // RFC5842
    const NOT_EXTENDED = 510;                                                // RFC2774
    const NETWORK_AUTHENTICATION_REQUIRED = 511;
}