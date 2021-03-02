<?php
/**
 * Created by PhpStorm.
 * User: abdullah
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Pagination\Paginator;

class ApiController extends Controller
{
    /**
     * @var int
     */
    protected $statusCode = 200;

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * The request was invalid or cannot be otherwise served.
     * @param string $message
     * @return \Response
     */
    public function respondCreated($message = 'This Resource Has Been Created!')
    {
        return $this->setStatusCode(201)->respond($message);
    }

    /**
     * The request was invalid or cannot be otherwise served.
     * @param string $message
     * @return \Response
     */
    public function respondBadRequest($message = 'The Request Was Invalid Or Cannot Be Otherwise Served!')
    {
        return $this->setStatusCode(400)->respondWithError($message);
    }

    /**
     * Missing or incorrect authentication credentials. Also returned in other circumstances
     * @param string $message
     * @return \Response
     */
    public function respondNotUnauthorized($message = 'Missing Or Incorrect Authentication Credentials!')
    {
        return $this->setStatusCode(401)->respondWithError($message);
    }

    /**
     * The request is understood, but it has been refused or access is not allowed.
     * @param string $message
     * @return \Response
     */
    public function respondForbidden($message = 'The Request Is Understood, But It Has Been Refused Or Access Is Not Allowed!')
    {
        return $this->setStatusCode(403)->respondWithError($message);
    }

    /**
     * The URI requested is invalid or the resource requested, such as a user, does not exists.
     * Also returned when the requested format is not supported by the requested method.
     * @param string $message
     * @return \Response
     */
    public function respondNotFound($message = 'Not Found!')
    {
        return $this->setStatusCode(404)->respondWithError($message);
    }

    /**
     * Returned by the Search API when an invalid format is specified in the request.
     * @param string $message
     * @return \Response
     */
    public function respondNotAcceptable($message = 'Invalid Format Is Specified In The Request!')
    {
        return $this->setStatusCode(406)->respondWithError($message);
    }

    /**
     * This resource is gone. Used to indicate that an API endpoint has been turned off.
     * @param string $message
     * @return \Response
     */
    public function respondGone($message = 'This Resource Is Gone!')
    {
        return $this->setStatusCode(410)->respondWithError($message);
    }

    /**
     * Returned when you are being rate limited .
     * @param string $message
     * @return \Response
     */
    public function respondEnhanceYourCalm($message = 'Enhance Your Calm!')
    {
        return $this->setStatusCode(420)->respondWithError($message);
    }

    /**
     * Returned when a request parameters is unable to be processed.
     * @param string $message
     * @param array $errors
     * @return \Response
     */
    public function respondUnProcessableEntity($message = 'The given data was invalid.', $errors = [])
    {
        return $this->setStatusCode(422)->respondWithError($message, $errors);
    }

    /**
     * Returned in when a request cannot be served due to the application’s rate limit having been exhausted for the resource.
     * @param string $message
     * @return \Response
     */
    public function respondTooManyRequests($message = 'Application’s Rate Limit Having Been Exhausted For The Resource')
    {
        return $this->setStatusCode(429)->respondWithError($message);
    }

    /**
     * Something is broken
     * @param string $message
     * @return \Response
     */
    public function respondInternalServerError($message = 'Something is broken!')
    {
        return $this->setStatusCode(500)->respondWithError($message);
    }

    /**
     * Application Is Down Or Being Upgraded.
     * @param string $message
     * @return \Response
     */
    public function respondBadGateway($message = 'Application Is Down Or Being Upgraded!')
    {
        return $this->setStatusCode(502)->respondWithError($message);
    }

    /**
     * The Application servers are up, but overloaded with requests. Try again later.
     * @param string $message
     * @return \Response
     */
    public function respondServiceUnavailable($message = 'Try Again Later!')
    {
        return $this->setStatusCode(503)->respondWithError($message);
    }

    /**
     * The Application servers are up, but the request couldn’t be serviced due to some failure within our stack. Try again later.
     * @param string $message
     * @return \Response
     */
    public function respondGatewayTimeOut($message = 'Try Again Later!')
    {
        return $this->setStatusCode(504)->respondWithError($message);
    }

    /**
     * @param $data
     * @param array $headers
     * @return \Response
     */
    public function respond($data, $headers = [])
    {
        return response($data, $this->getStatusCode(), $headers);
    }

    /**
     * @param $message
     * @param $errors
     * @return \Response
     */
    public function respondWithError($message, $errors = [])
    {
        return $this->respond([
            'message' => $message,
            'errors' => $errors,
            'status_code' => $this->getStatusCode()
        ]);
    }

    /**
     * @param Paginator $paginator
     * @param $data
     * @return \Response
     */
    public function respondWithPagination(Paginator $paginator, $data)
    {

        $data = array_merge($data, [
            'pagination' => [
                'total_count' => $paginator->total(),
                'total_pages' => ceil($paginator->total() / $paginator->perPage()),
                'current_page' => $paginator->currentPage(),
                'limit' => $paginator->perPage(),
            ]
        ]);
        return $this->respond($data);
    }
}
