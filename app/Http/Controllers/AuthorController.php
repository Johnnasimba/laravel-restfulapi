<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Author::all();

        return response()->json([
            'total' => $authors->count(),
            'data' => $authors
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'author_name' => 'required',
                'author_contact_no' => 'required',
                'author_country' => 'required'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $th->errors()
            ], 422);
        }

        try {
            $author = new Author();
            $author->author_name = $request->author_name;
            $author->author_contact_no = $request->author_contact_no;
            $author->author_country = $request->author_country;
            $author->created_at = Carbon::now();
            $author->updated_at = Carbon::now();
            $author->save();
            return response()->json([
                'message' => 'Author created successfully',
                'data' => $author
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed to create author',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        $current_author = Author::find($author->id);
        return response()->json([
            'data' => $current_author
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        try {
            $this->validate($request, [
                'author_name' => 'required',
                'author_contact_no' => 'required',
                'author_country' => 'required'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $th->errors()
            ], 422);
        }

        try {
            $current_author = Author::find($author->id);
            $current_author->author_name = $request->author_name;
            $current_author->author_contact_no = $request->author_contact_no;
            $current_author->author_country = $request->author_country;
            $current_author->updated_at = Carbon::now();
            $current_author->save();
            return response()->json([
                'message' => 'Author updated successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed to update author',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        try {
            $current_author = Author::find($author->id);
            $current_author->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Author deleted successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed to delete author',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Search the specified resource from storage.
     */
    public function search(Request $request)
    {
        try {
            $term = $request->term;
            $authors = Author::where('author_name', 'LIKE', "%{$term}%")
                ->orWhere('author_country', 'LIKE', "%{$term}%")
                ->orWhere('author_contact_no', 'LIKE', "%{$term}%")
                ->get();
            return response()->json([
                'total' => $authors->count(),
                'data' => $authors
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed to search author',
                'errors' => $th->getMessage()
            ], 500);
        }
    }
}
