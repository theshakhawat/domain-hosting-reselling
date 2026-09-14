<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_no',
        'name',
        'email',
        'phone',
        'subject',
        'issue_type',
        'description',
        'screenshot',
        'status',
        'ip_address',
    ];

    /**
     * Scope for unread/new messages.
     */
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }
}
