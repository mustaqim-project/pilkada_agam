<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = ['created_by', 'assigned_to', 'report_content', 'period'];

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function assignee()
    {
        return $this->belongsTo(Admin::class, 'assigned_to');
    }
}
