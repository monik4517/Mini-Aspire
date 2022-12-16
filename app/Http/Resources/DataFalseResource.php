<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DataFalseResource extends JsonResource
{
    public static $wrap = null;

    private $message;
    private $statusCode;

    public function __construct($message = '',$statusCode = '')
    {
        parent::__construct($message);
        $this->message = $message;
        $this->statusCode = $statusCode;
    }
    /**
     * response for message for error
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'error' => [$this->message]
        ];
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toResponse($request)
    {
        $statusCode = $this->statusCode;
        if ($this->statusCode == '')
            $statusCode = config('constants.validation_codes.unprocessable_entity');

        return parent::toResponse($request)->setStatusCode($statusCode);
    }
}
