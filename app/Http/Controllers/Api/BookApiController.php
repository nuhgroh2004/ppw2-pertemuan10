<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Buku;

use App\Http\Resources\BookResource;

class BookApiController extends Controller
{
    public function index()
    {
        $books = Buku::latest()->paginate(5);

        return new BookResource(true, 'list data buku', $books);
    }
}
