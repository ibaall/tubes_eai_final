<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\DeliveryResource;
use App\Http\Resources\DeliveryCollection;

class DeliveryController extends Controller
{
    /**
     * Menampilkan semua data pengiriman.
     */
    public function index()
    {
        $deliveries = Delivery::all();
        return new DeliveryCollection($deliveries, 'Success', 'Daftar semua data pengiriman.');
    }

    /**
     * Membuat data pengiriman baru.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|integer|unique:deliveries,order_id',
            'kurir' => 'required|string|in:JNE,J&T,Sicepat,Anteraja', // Pilihan kurir
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $orderId = $request->input('order_id');

        // Panggil Order Service untuk mendapatkan detail pesanan
        try {
            $response = Http::get(env('ORDER_SERVICE_URL') . '/api/orders/' . $orderId);

            if ($response->failed() || $response->json()['status'] !== 'Success') {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'Order dengan ID ' . $orderId . ' tidak ditemukan di Order Service.'
                ], 404);
            }

            $orderData = $response->json()['data'];

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Tidak dapat menghubungi Order Service.',
                'error_details' => $e->getMessage()
            ], 500);
        }

        // Buat data pengiriman baru
        $delivery = Delivery::create([
            'order_id' => $orderId,
            'nama_pelanggan' => $orderData['Nama Pelanggan'],
            'alamat_pengiriman' => $orderData['Alamat'],
            'kurir' => $request->input('kurir'),
            'status_pengiriman' => 'Pending', // Status awal
        ]);

        return new DeliveryResource($delivery, 'Success', 'Data pengiriman berhasil dibuat.');
    }

    /**
     * Menampilkan satu data pengiriman.
     */
    public function show(Delivery $delivery)
    {
        return new DeliveryResource($delivery, 'Success', 'Data pengiriman ditemukan.');
    }

    /**
     * Memperbarui data pengiriman (misal: update status atau nomor resi).
     */
    public function update(Request $request, Delivery $delivery)
    {
        $validator = Validator::make($request->all(), [
            'status_pengiriman' => 'sometimes|required|string|in:Pending,Dikirim,Tiba,Batal',
            'nomor_resi' => 'nullable|string',
            'estimasi_tiba' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'Error', 'message' => 'Validasi Gagal', 'errors' => $validator->errors()], 422);
        }

        $delivery->update($request->only(['status_pengiriman', 'nomor_resi', 'estimasi_tiba']));

        return new DeliveryResource($delivery, 'Success', 'Data pengiriman berhasil diperbarui.');
    }

    /**
     * Menghapus data pengiriman.
     */
    public function destroy(Delivery $delivery)
    {
        $delivery->delete();

        return response()->json([
            'status' => 'Success',
            'message' => 'Data pengiriman berhasil dihapus.'
        ], 200);
    }
}
