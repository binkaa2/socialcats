<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TellUsMore extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
         return [
            'tum_code' => $this->tum_code,
            'tum_name' => $this->tum_name,
            'user_id' => $this->user_id
            //'secret' => $this->when(Auth::user()->isAdmin(), 'secret-value'),
        ];
    }
}
