<?php
// app/Models/RepairBooking.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairBooking extends Model
{
    public const STATUSES = [
        'new'         => 'New',
        'contacted'   => 'Contacted',
        'in_progress' => 'In Progress',
        'completed'   => 'Completed',
        'cancelled'   => 'Cancelled',
    ];

    protected $fillable = [
        'ticket_no', 'name', 'mobile', 'device_type', 'brand', 'model',
        'issue', 'service_mode', 'description', 'status',
    ];
}