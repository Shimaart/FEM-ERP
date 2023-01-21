<?php

namespace App\Http\Controllers;

use App\Models\Lead;

final class LeadController extends Controller
{
    public function index()
    {
        return view('leads.index');
    }

    public function create()
    {
        $lead = Lead::query()->create([
            'status' => Lead::STATUS_NEW,
            'name' => ''
        ]);

        return redirect()->route('leads.show', ['lead' => $lead->id]);
    }

    public function show(Lead $lead)
    {
        return view('leads.show', compact('lead'));
    }
}
