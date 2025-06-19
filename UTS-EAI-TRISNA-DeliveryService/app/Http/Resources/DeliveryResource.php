<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryResource extends JsonResource
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
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => [
                'id_pengiriman' => $this->id,
                'id_order' => $this->order_id,
                'nama_pelanggan' => $this->nama_pelanggan,
                'alamat_pengiriman' => $this->alamat_pengiriman,
                'kurir' => $this->kurir,
                'status_pengiriman' => $this->status_pengiriman,
                'nomor_resi' => $this->nomor_resi,
                'estimasi_tiba' => $this->estimasi_tiba,
                'dibuat_pada' => $this->created_at->format('d-m-Y H:i:s'),
            ]
        ];
    }
}
