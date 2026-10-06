<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactEnquiry extends Model
{
    // stored value => label shown in the dropdown
    public const TYPES = [
        'Product Availability' => 'Product Inquiry / Bulk Order',
        'Laptop/Mobile Repair' => 'Repair Service Inquiry',
        'Device Exchange' => 'Device Exchange / Upgrade',
        'Order Tracking' => 'Order Status / Shipping',
        'Warranty Claim' => 'Warranty Claim Assistance',
        'Other' => 'Other Query',
    ];

    public const STATUSES = [
        'new' => 'New',
        'read' => 'Read',
        'replied' => 'Replied',
    ];

    protected $fillable = [
        'name',
        'email',
        'mobile',
        'company',
        'inquiry_type',
        'message',
        'status',
    ];
}