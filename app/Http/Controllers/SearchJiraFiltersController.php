<?php

namespace App\Http\Controllers;

use App\JiraFilter;
use App\Services\JiraProvider;
use Illuminate\Http\Request;

class SearchJiraFiltersController extends Controller
{
    //

    public function index()
    {
        $jiraFilters = (new JiraProvider())->listFilters();

        return view('filters', compact('jiraFilters'));
    }

    public function store(Request $request)
    {
        $base = new JiraFilter($request->all());

        $base->save();
    }
}
