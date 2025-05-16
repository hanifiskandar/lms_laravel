<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeaveRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'leave_type_id' => $this->leave_type_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'duration' => $this->duration,
            'duration_label' => $this->duration === 'full_day' ? 'Full Day' : 'Half Day',
            'reason' => $this->reason,
            'status' => [
                'id' => $this->status,
                'label' => $this->status_label,
            ],
            'file_original_name' => $this->file_original_name,
            'file_path' => $this->file_path,
            'file_size' => $this->file_size,
            'approved_by_id' => $this->approved_by_id,
            'approved_at' => $this->approved_at,
            'user' => new UserResource($this->whenLoaded('user')), // Eager load user data
            'leave_type' => new LeaveTypeResource($this->whenLoaded('leaveType')), // Eager load leave type data
        ];
    }
}
