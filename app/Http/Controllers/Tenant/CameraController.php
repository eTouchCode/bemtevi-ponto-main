<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Camera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;

class CameraController extends Controller
{
    public function index()
    {
        $cameras = Camera::paginate(20);
        return view('pages/tenant/camera/index', ['cameras' => $cameras]);
    }

    public function new()
    {
        return view('pages/tenant/camera/new');
    }

    public function create(Request $request)
    {
        $attributes = $request->validate([
            'status' => 'nullable',
            'name' => 'required|alpha_num',
            'user' => 'required|alpha_num',
            'password' => 'required|alpha_num',
            'ip' => 'required|ip',
            'port' => 'required|numeric',
            'location' => 'required',
            'path' => 'required',
            'address' => [
                'required',
                'regex:/(rtsp):\/\/([^\s@\/]+)@([^\s\/:]+)(?::([0-9]+))?(\/.*)/'
            ],
        ]);

        $camera = new Camera($attributes);

        try {
            $camera->status = isset($attributes['status']) ? true : false;
            $camera->save();
            return redirect("/cameras/edit/{$camera->id}")->with('status', 'Camera Added!');
        } catch (\Throwable $th) {
            Log::info($th);
            redirect()->back()->with('error', 'Error Saving');
        }
    }

    public function edit(Request $request, $id)
    {
        $camera = Camera::findOrFail($id);

        return view(
            'pages/tenant/camera/edit',
            [
                'camera' => $camera
            ]
        );
    }

    public function postEdit(Request $request, $id)
    {
        $attributes = $request->validate([
            'status' => 'nullable',
            'name' => 'required|alpha_num',
            'user' => 'required|alpha_num',
            'password' => 'required|alpha_num',
            'ip' => 'required|ip',
            'port' => 'required|numeric',
            'location' => 'required',
            'path' => 'required',
            'address' => [
                'required',
                'regex:/(rtsp):\/\/([^\s@\/]+)@([^\s\/:]+)(?::([0-9]+))?(\/.*)/'
            ],
        ]);

        try {

            $camera = Camera::findOrFail($id)->fill($attributes);
            $camera->status = isset($attributes['status']) ? true : false;

            $camera->save();
            return redirect()->back()->with('status', 'Edit Sucessful!');
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            return redirect()->back()->with('error', "Edit Failed!");
        }
    }

    public function url(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'camera' => 'required|exists:cameras,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => 'Camera Not Found',
            ]);
        }

        $attributes = $validator->safe()->all();

        $camera = Camera::find($attributes['camera']);

        return response()->json([
            'error' => false,
            'cameraName' =>  $camera->name,
            'url' => $camera->getCameraUrl(),
        ]);
    }

    public function destroy($id)
    {
        $employee = Camera::find($id);
        $employee->delete();

        return redirect()->back()->with('status', 'Camera deleted');
    }
}
