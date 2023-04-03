<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    public function index()
    {
        $data = Blog::get();

        return response()->json([
            "success"   => true,
            "data"      => $data,
        ]);
    }

    public function store(Request $request)
    {
        $data = Blog::create($request->all());
        if ( $data )
        {
            $result = response()->json([
                "success"   => true,
                "data"      => $data,
                "msg"       => "Data inserted successfully"
            ]);
        } else {
            $result = response()->json([
                "success"   => false,
                "msg"       => "Can't inserted data"
            ], 500);
        }

        return $result;
    }

    public function edit($id)
    {
        $data = Blog::where('id', $id)->first();

        return response()->json([
            "success"   => true,
            "data"      => $data,
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = Blog::where('id', $id)->update($request->all());

        if ( $data )
        {
            $result = response()->json([
                "success"   => true,
                "msg"       => "Data updated successfully"
            ]);
        } else {
            $result = response()->json([
                "success"   => false,
                "msg"       => "Can't updated data"
            ], 500);
        }

        return $result;
    }

    public function destroy($id)
    {
        $data = Blog::where('id', $id)->delete();

        if ( $data )
        {
            $result = response()->json([
                "success"   => true,
                "msg"       => "Data deleted successfully"
            ]);
        } else {
            $result = response()->json([
                "success"   => false,
                "msg"       => "Can't deleted data"
            ], 500);
        }

        return $result;
    }
}
