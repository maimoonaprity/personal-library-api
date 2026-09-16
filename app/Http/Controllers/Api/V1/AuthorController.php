<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Author\StoreAuthorRequest;
use App\Http\Requests\Api\V1\Author\UpdateAuthorRequest;
use App\Http\Resources\Api\V1\AuthorResource;
use App\Models\Author;
use App\Support\ApiResponse;


class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::all();

        return ApiResponse::success(
            AuthorResource::collection($authors),
            'Authors retrieved successfully.'
        );
    }


    
    public function store(StoreAuthorRequest $request)
    {
        $author = Author::create(
            $request->validated()
        );


        return ApiResponse::success(
            new AuthorResource($author),
            'Author created successfully.',
            201
        );
    }


    
    public function show(Author $author)
    {
        return ApiResponse::success(
            new AuthorResource($author),
            'Author retrieved successfully.'
        );
    }


    
    public function update(
        UpdateAuthorRequest $request,
        Author $author
    ) {
        $author->update(
            $request->validated()
        );


        return ApiResponse::success(
            new AuthorResource($author),
            'Author updated successfully.'
        );
    }


    
    public function destroy(Author $author)
    {
        $author->delete();


        return ApiResponse::success(
            null,
            'Author deleted successfully.'
        );
    }
}