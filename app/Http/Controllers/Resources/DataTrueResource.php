<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DataTrueResource extends JsonResource
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
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'message' => $this->message
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
            $statusCode = config('constants.validation_codes.success');

        return parent::toResponse($request)->setStatusCode($statusCode);
    }
}
