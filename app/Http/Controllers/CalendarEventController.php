<?php

namespace App\Http\Controllers;

use App\Models\CalendarEvent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalendarEventController
{
    public function view()
    {
        $users = User::select('id', 'login', 'email')->get();
        return view('calendar.index', compact('users'));
    }

    public function index(Request $request)
    {
        $query = CalendarEvent::forUser(auth()->id());

        if ($request->has('type') && $request->type !== 'all') {
            $query->byType($request->type);
        }

        if ($request->has('status') && $request->status !== 'all') {
            $query->byStatus($request->status);
        }

        if ($request->has('start') && $request->has('end')) {
            $query->whereBetween('start_at', [$request->start, $request->end]);
        }

        $events = $query->with('user')->get();

        return $events->map(fn($event) => [
            'id' => $event->id,
            'title' => $event->title,
            'start' => $event->start_at->toIso8601String(),
            'end' => optional($event->end_at)?->toIso8601String(),
            'color' => $this->getColorByStatus($event),
            'allDay' => $event->all_day,
            'extendedProps' => [
                'description' => $event->description,
                'type' => $event->type,
                'status' => $event->status,
                'location' => $event->location,
                'notes' => $event->notes,
                'isShared' => $event->is_shared,
                'sharedWithUsers' => $event->shared_with_users,
                'notificationEnabled' => $event->notification_enabled,
                'notificationMinutesBefore' => $event->notification_minutes_before,
                'recurrenceRule' => $event->recurrence_rule,
                'ownerName' => $event->user->login ?? 'Desconhecido',
                'isOwner' => $event->user_id === auth()->id(),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:event,task,reminder,meeting',
            'start' => 'required|date',
            'end' => 'nullable|date|after:start',
            'allDay' => 'boolean',
            'color' => 'nullable|string|max:20',
            'status' => 'nullable|in:pending,done,canceled',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'notificationEnabled' => 'boolean',
            'notificationMinutesBefore' => 'nullable|integer|min:0',
            'isShared' => 'boolean',
            'sharedWithUsers' => 'nullable|array',
            'sharedWithUsers.*' => 'exists:users,id',
            'recurrenceRule' => 'nullable|string',
        ]);

        $event = CalendarEvent::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'type' => $validated['type'],
            'start_at' => $validated['start'],
            'end_at' => $validated['end'] ?? null,
            'all_day' => $validated['allDay'] ?? false,
            'color' => $validated['color'] ?? $this->getDefaultColorByType($validated['type']),
            'status' => $validated['status'] ?? 'pending',
            'location' => $validated['location'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'notification_enabled' => $validated['notificationEnabled'] ?? false,
            'notification_minutes_before' => $validated['notificationMinutesBefore'] ?? null,
            'is_shared' => $validated['isShared'] ?? false,
            'shared_with_users' => $validated['sharedWithUsers'] ?? null,
            'recurrence_rule' => $validated['recurrenceRule'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Evento criado com sucesso!',
            'event' => $event
        ]);
    }

    public function update(Request $request, CalendarEvent $calendarEvent)
    {
        // Verifica permissão
        if ($calendarEvent->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'type' => 'sometimes|in:event,task,reminder,meeting',
            'start' => 'sometimes|date',
            'end' => 'nullable|date',
            'allDay' => 'boolean',
            'color' => 'nullable|string|max:20',
            'status' => 'nullable|in:pending,done,canceled',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'notificationEnabled' => 'boolean',
            'notificationMinutesBefore' => 'nullable|integer|min:0',
            'isShared' => 'boolean',
            'sharedWithUsers' => 'nullable|array',
            'sharedWithUsers.*' => 'exists:users,id',
            'recurrenceRule' => 'nullable|string',
        ]);

        $updateData = [];
        if (isset($validated['title']))
            $updateData['title'] = $validated['title'];
        if (isset($validated['description']))
            $updateData['description'] = $validated['description'];
        if (isset($validated['type']))
            $updateData['type'] = $validated['type'];
        if (isset($validated['start']))
            $updateData['start_at'] = $validated['start'];
        if (isset($validated['end']))
            $updateData['end_at'] = $validated['end'];
        if (isset($validated['allDay']))
            $updateData['all_day'] = $validated['allDay'];
        if (isset($validated['color']))
            $updateData['color'] = $validated['color'];
        if (isset($validated['status']))
            $updateData['status'] = $validated['status'];
        if (isset($validated['location']))
            $updateData['location'] = $validated['location'];
        if (isset($validated['notes']))
            $updateData['notes'] = $validated['notes'];
        if (isset($validated['notificationEnabled']))
            $updateData['notification_enabled'] = $validated['notificationEnabled'];
        if (isset($validated['notificationMinutesBefore']))
            $updateData['notification_minutes_before'] = $validated['notificationMinutesBefore'];
        if (isset($validated['isShared']))
            $updateData['is_shared'] = $validated['isShared'];
        if (isset($validated['sharedWithUsers']))
            $updateData['shared_with_users'] = $validated['sharedWithUsers'];
        if (isset($validated['recurrenceRule']))
            $updateData['recurrence_rule'] = $validated['recurrenceRule'];

        $calendarEvent->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Evento atualizado com sucesso!',
            'event' => $calendarEvent->fresh()
        ]);
    }

    public function destroy(CalendarEvent $calendarEvent)
    {
        // Verifica permissão
        if ($calendarEvent->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $calendarEvent->delete();
        return response()->json([
            'success' => true,
            'message' => 'Evento excluído com sucesso!'
        ]);
    }

    private function getDefaultColorByType($type)
    {
        return match ($type) {
            'event' => '#3b82f6',      // blue
            'task' => '#10b981',       // green
            'reminder' => '#f59e0b',   // amber
            'meeting' => '#8b5cf6',    // purple
            default => '#6b7280',      // gray
        };
    }

    private function getColorByStatus($event)
    {
        if ($event->status === 'done') {
            return '#10b981'; // green
        } elseif ($event->status === 'canceled') {
            return '#ef4444'; // red
        }
        return $event->color ?? $this->getDefaultColorByType($event->type);
    }
}
