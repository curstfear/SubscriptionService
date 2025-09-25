<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plans = Plan::with('features')->get();
        return view('admin.plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plan $plan)
    {
        // 1. Обновляем основные поля
        $plan->update([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'is_popular' => $request->has('is_popular') ? true : false,
        ]);

        // 2. Обновляем фичи
        if ($request->has('features')) {
            foreach ($request->input('features') as $featureId => $featureData) {
                $feature = $plan->features()->find($featureId);
                if ($feature) {
                    $feature->update([
                        'feature' => $featureData['feature'],
                        'value' => $featureData['value'],
                    ]);
                }
            }
        }

        return redirect()->route('admin.plans.index')
            ->with('success_plan', $plan->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
