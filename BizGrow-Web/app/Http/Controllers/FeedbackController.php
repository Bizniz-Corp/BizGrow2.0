<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Exception;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    function getAllFeedback(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $feedback = Feedback::select('feedback_id', 'nama_umkm', 'deskripsi')
            ->orderBy('created_at', 'desc');

        // Pagination
        $feedback = $feedback->paginate($perPage);
        return response()->json([
            'success' => true,
            'data' => $feedback->items(),
            'pagination' => [
                'current_page' => $feedback->currentPage(),
                'last_page' => $feedback->lastPage(),
                'per_page' => $feedback->perPage(),
                'total' => $feedback->total(),
            ],
        ], 200);
    }

    public function postFeedback(Request $request)
    {
        try {
            $request->validate([
                'nama_umkm' => 'required|string|max:255',
                'deskripsi' => 'required|string|max:1000',
            ]);

            $feedback = Feedback::create([
                'nama_umkm' => $request->nama_umkm,
                'deskripsi' => $request->deskripsi,
            ]);

            return response()->json([
                'message' => 'Feedback created successfully',
                'data' => $feedback,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan, Feedback gagal dibuat'
            ], 400);
        }
    }
}
