<?php

namespace App\Http\Controllers;

use App\Match;
use Illuminate\Http\Request;

use App\Http\Requests;

class UpdateController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function update(Request $request)
    {

        $content = $request->getContent();
        return response('Content received', 200);
    }
}
