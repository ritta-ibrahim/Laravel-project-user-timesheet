<?php

namespace App\Http\Controllers\Attributes;

use App\Enums\AttributeTypes;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\AttributeResource;


class AttributesController extends Controller
{
    public function createAttribute(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'type' => ['required', Rule::enum(AttributeTypes::class)]
        ]);
        $attribute = Attribute::create($data);
        return Response::api(new AttributeResource($attribute));
    }

    public function getAttributes(Request $request)
    {
        $filters = $request->query('filters', []);
        
        if (!empty($filters)) {
            $attributes = Attribute::filter($filters)->get();
        } else {
            $attributes = Attribute::all();
        }

        return Response::api(AttributeResource::collection($attributes));
    }

    public function getAttribute(Attribute $attribute)
    {
        return Response::api(new AttributeResource($attribute));
    }

    public function updateAttribute(Request $request, Attribute $attribute)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('attributes', 'name')->ignore($attribute->id)
            ],
            'type' => [
                'required',
                Rule::enum(AttributeTypes::class)
            ]
        ]);

        $attribute->update($data);
        return Response::api(new AttributeResource($attribute));
    }

    public function deleteAttribute(Attribute $attribute)
    {
        $attribute->delete();
        return Response::api(['message' => __('general.success_delete')]);
    }
}
