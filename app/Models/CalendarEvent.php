<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CalendarEvent extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'type',
        'start_at',
        'end_at',
        'all_day',
        'color',
        'status',
        'recurrence_rule',
        'parent_event_id',
        'notification_enabled',
        'notification_minutes_before',
        'is_shared',
        'shared_with_users',
        'location',
        'notes',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'all_day' => 'boolean',
        'notification_enabled' => 'boolean',
        'is_shared' => 'boolean',
        'shared_with_users' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parentEvent(): BelongsTo
    {
        return $this->belongsTo(CalendarEvent::class, 'parent_event_id');
    }

    public function childEvents(): HasMany
    {
        return $this->hasMany(CalendarEvent::class, 'parent_event_id');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where(function ($q) use ($userId) {
            $q->where('user_id', $userId)
                ->orWhere(function ($subQ) use ($userId) {
                    $subQ->where('is_shared', true)
                        ->whereJsonContains('shared_with_users', (string) $userId);
                });
        });
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
