<?php

namespace App\Http\Controllers\Timesheets;

use App\Models\Timesheet;
use App\Models\ProjectUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\TimesheetResource;

class TimesheetsController extends Controller
{
    public function createTimesheet(Request $request)
    {
        $data = $request->validate([
            'task_name' => 'required|string',
            'hours' => 'required|numeric',
            'user_id' => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,id',
        ]);
        $timesheet = Timesheet::create($data);

        ProjectUser::firstOrCreate([
            'project_id' => $data['project_id'],
            'user_id' => $data['user_id'],
        ]);

        return Response::api(new TimesheetResource($timesheet));
    }

    public function getTimesheets(Request $request)
    {
        $filters = $request->query('filters', []);

        if (!empty($filters)) {
            $timesheets = Timesheet::filter($filters)->get();
        } else {
            $timesheets = Timesheet::all();
        }
        return Response::api(TimesheetResource::collection($timesheets));
    }

    public function getTimesheet(Timesheet $timesheet)
    {
        return Response::api(new TimesheetResource($timesheet));
    }

    public function updateTimesheet(Request $request, Timesheet $timesheet)
    {
        $data = $request->validate([
            'task_name' => 'string',
            'hours' => 'numeric',
            'user_id' => 'exists:users,id',
            'project_id' => 'exists:projects,id'
        ]);

        $timesheet->update($data);
        return Response::api(new TimesheetResource($timesheet));
    }

    public function deleteTimesheet(Timesheet $timesheet)
    {
        $timesheet->delete();
        return Response::api(['message' => __('general.success_delete')]);
    }
}
