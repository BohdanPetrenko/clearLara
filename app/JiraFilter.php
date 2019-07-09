<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

class JiraFilter extends Model
{
    protected $table = 'jira_filters';

    protected $fillable = ['filter_id', 'schedule', 'query', 'max_total_items'];
}
