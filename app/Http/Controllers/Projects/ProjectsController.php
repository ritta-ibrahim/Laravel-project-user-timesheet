<?php

namespace App\Http\Controllers\Projects;

use App\Models\Project;
use App\Models\Attribute;
use App\Enums\ProjectStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\AttributeValue;
use Illuminate\Validation\Rule;
use App\Rules\AttributeValueRule;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;


class ProjectsController extends Controller
{
    public function createProject(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'status' => ['required', Rule::enum(ProjectStatus::class)],
            'attributes' => 'required|array',
            'attributes.*.id' => 'required|exists:attributes,id',
            'attributes.*.value' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    $attributeId = data_get($request->all(), str_replace('.value', '.id', $attribute));
                    if ($attributeId) {
                        $rule = new AttributeValueRule($attributeId);
                        if (!$rule->passes($attribute, $value)) {
                            $fail($rule->message());
                        }
                    }
                }
            ],
        ]);

        $project = Project::create($data);

        foreach ($data['attributes'] as $attr) {
            $isTypeSelect = Attribute::find($attr['id'])->type == 'select';
            AttributeValue::create([
                'project_id' => $project->id,
                'attribute_id' => $attr['id'],
                'value' => $isTypeSelect ? json_encode($attr['value']) : $attr['value']
            ]);
        }
        return Response::api(new ProjectResource($project));
    }

    public function getProjects(Request $request)
    {
        $filters = $request->query('filters', []);

        if (!empty($filters)) {
            $projects = Project::filter($filters)->get();
        } else {
            $projects = Project::all();
        }
        
        return Response::api(ProjectResource::collection($projects));
    }

    public function getProject(Project $project)
    {
        return Response::api(new ProjectResource($project));
    }

    public function updateProject(Request $request, Project $project)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('projects', 'name')->ignore($project->id)
            ],
            'status' => [
                'nullable',
                Rule::enum(ProjectStatus::class)
            ],
            'attributes' => 'array',
            'attributes.*.id' => 'exists:attributes,id',
            'attributes.*.value' => [
                function ($attribute, $value, $fail) use ($request) {
                    $attributeId = data_get($request->all(), str_replace('.value', '.id', $attribute));
                    if ($attributeId) {
                        $rule = new AttributeValueRule($attributeId);
                        if (!$rule->passes($attribute, $value)) {
                            $fail($rule->message());
                        }
                    }
                }
            ],
        ]);

        $project->update($data);

        foreach ($data['attributes'] as $attr) {
            $isTypeSelect = Attribute::find($attr['id'])->type == 'select';
            AttributeValue::updateOrCreate([
                'project_id' => $project->id,
                'attribute_id' => $attr['id'],
            ], [
                'value' => $isTypeSelect ? json_encode($attr['value']) : $attr['value']
            ]);
        }

        return Response::api(new ProjectResource($project));
    }

    public function deleteProject(Project $project)
    {
        $project->delete();
        return Response::api(['message' => __('general.success_delete')]);
    }
}
