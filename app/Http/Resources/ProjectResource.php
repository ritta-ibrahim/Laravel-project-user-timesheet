<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Constants\ProjectConstants;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => Str::title(ProjectConstants::getStatusLable()[$this->status]),
            'attributes' => AttributeValueResource::collection( $this->attributeValues)
        ];
    }
}
