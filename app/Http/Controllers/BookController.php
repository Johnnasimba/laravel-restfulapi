<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::all();
        return response()->json([
            'total' => $books->count(),
            'data' => $books
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
                'book_title' => 'required',
                'book_isbn' => 'required',
                'book_price' => 'required',
                'book_publish_year' => 'required',
                'author_id' => 'required'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $th->errors()
            ], 422);
        }

        try {
            $book = new Book();
            $book->book_title = $request->book_title;
            $book->book_isbn = $request->book_isbn;
            $book->book_price = $request->book_price;
            $book->book_publish_year = $request->book_publish_year;
            $book->author_id = $request->author_id;
            $book->created_at = Carbon::now();
            $book->updated_at = Carbon::now();
            $book->save();
            return response()->json([
                'message' => 'Book created successfully',
                'data' => $book
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Book creation failed',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $current_book = Book::find($book->id);
        return response()->json([
            'data' => $current_book
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        try {
            $this->validate($request, [
                'book_title' => 'required',
                'book_isbn' => 'required',
                'book_price' => 'required',
                'book_publish_year' => 'required',
                'author_id' => 'required'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $th->errors()
            ], 422);
        }

        try {
            $current_book = Book::find($book->id);
            $current_book->book_title = $request->book_title;
            $current_book->book_isbn = $request->book_isbn;
            $current_book->book_price = $request->book_price;
            $current_book->book_publish_year = $request->book_publish_year;
            $current_book->author_id = $request->author_id;
            $current_book->updated_at = Carbon::now();
            $current_book->save();
            return response()->json([
                'message' => 'Book updated successfully',
                'data' => $current_book
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Book update failed',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        try {
            $current_book = Book::find($book->id);
            $current_book->delete();
            return response()->json([
                'message' => 'Book deleted successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Book deletion failed',
                'error' => $th->getMessage()
            ], 500);
        }
    }

public function search($term)
    {
       try {
            $books = Book::where('book_title', 'LIKE', "%{$term}%")->get();
            return response()->json([
                'total' => $books->count(),
                'data' => $books
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
            'message' => 'Failed to search books',
            'error' => $th->getMessage()
            ], 500);
        }
    }
}
