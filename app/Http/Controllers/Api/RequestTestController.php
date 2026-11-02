<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RequestTestController extends Controller
{
    public function test(Request $request)
    {
        return response()->json([
            'content_type' => $request->header('Content-Type'),
            'all_data' => $request->all(),
            'name' => $request->input('name'),
            'has_image' => $request->hasFile('image'),
            'raw_body' => $request->getContent()
        ]);
    }
}