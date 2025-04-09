<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Warnings;
use Cache;
use Illuminate\Http\Request;
use Log;

class WarningController extends Controller
{

    const ICONS = [
        'home',
        'star',
        'check',
        'bolt',
        'cake',
        'favorite',
        'person',
        'delete',
        'event',
        'calculate',
    ];

    public function index(Request $request)
    {
        $warnings = Warnings::paginate(10);

        return view('pages.tenant.warning.index', ['warnings' => $warnings]);
    }

    public function new(Request $request)
    {

        return view('pages.tenant.warning.new', ['icons' => self::ICONS]);
    }

    public function createWarning(Request $request)
    {

        $attributes = $request->validate([
            'title' => 'required|max:255',
            'warningType' => 'required',
            'message' => 'required|max:255',
            'icon' => 'required',
            'date' => 'required|date',
        ]);

        $warning = new Warnings($attributes);

        try {
            $warning->saveOrFail();
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            return redirect("/warnings");
        } finally {
            Cache::forget('notifications');
            return redirect("/warnings/edit/{$warning->id}")->with('status', 'Warning Added!');
        }

    }

    public function edit(Request $request, $warningId)
    {

        try {
            $warning = Warnings::findOrFail($warningId);
        } catch (\Throwable $th) {
            return redirect('/warnings')->with('status', 'Warning not found!');
        }

        return view("pages.tenant.warning.edit", ['warning' => $warning, 'icons' => self::ICONS]);
    }

    public function postEdit(Request $request, $warningId)
    {
        $attributes = $request->validate([
            'title' => 'required|max:255',
            'warningType' => 'required',
            'message' => 'required|max:255',
            'icon' => 'required',
            'date' => 'required|date',
        ]);

        try {
            $warning = Warnings::findOrFail($warningId);

            $warning->fill($attributes);
            $warning->save();

            Cache::forget('notifications');
        } catch (\Throwable $th) {
            return redirect('/warnings')->with('status', 'Warning not found!');
        }

        return redirect("/warnings/edit/{$warning->id}")->with('status', 'Warning Edited!');
    }

    public function destroy(Request $request, $warningId)
    {

        try {
            $warning = Warnings::findOrFail($warningId);
            $warning->delete();
        } catch (\Throwable $th) {
            return redirect('/warnings')->with('status', 'Warning not found!');
        }
        Cache::forget('notifications');
        return redirect('/warnings')->with('status', 'Warning deleted');
    }
}
