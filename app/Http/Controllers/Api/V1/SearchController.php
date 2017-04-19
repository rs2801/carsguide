<?php

namespace App\Http\Controllers\Api\V1;

use App\Handlers\Twitter\Search;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function index(Search $Search, Request $request)
    {
        if (!$request->has('term') || $request->term == "") {
            return response()->json('Missing Term', 400);
        }

        $response = $Search->setTerm($request->term)
            ->setNextPage($request->next_page)
            ->setResultType('recent')
            ->process()
            ->output();

        return response()->json($response);
    }

}
