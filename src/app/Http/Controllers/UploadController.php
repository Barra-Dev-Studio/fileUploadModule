<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UploadService;

class UploadController extends Controller
{
    public function store(Request $request, UploadService $uploadService)
    {
        if ($request->hasFile('file')) {
            return $uploadService->store($request);
        }

        return '';
    }

    public function revert($id, UploadService $uploadService)
    {
        $uploadService->revert($id);
    }
}
