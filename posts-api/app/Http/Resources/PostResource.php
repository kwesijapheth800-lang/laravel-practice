<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    // Maps the model attributes to a standard JSON format
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->content, // Example of renaming 'content' database column to 'body' in the API
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}