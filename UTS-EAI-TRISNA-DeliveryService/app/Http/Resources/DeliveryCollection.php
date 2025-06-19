<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DeliveryCollection extends ResourceCollection
{
    public $status;
    public $message;

    public function __construct($resource, $status = 'Success', $message = '')
    {
        parent::__construct($resource);
        $this->status = $status;
        $this->message = $message;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status'  => $this->status,
            'message' => $this->message,
            'data'    => $this->collection,
        ];
    }
}
