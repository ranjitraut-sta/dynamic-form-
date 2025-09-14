<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait ExtractsFillableData
{
    /**
     * Extract only fillable data from the request using the repository's model.
     */
    public function extractFillableData(Request $request, $repo)
    {
        return $request->only($repo->getModel()->getFillable());
    }
}
