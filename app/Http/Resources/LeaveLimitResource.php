<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeaveLimitResource extends JsonResource
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
            'year' => $this->year,
            'limit_days' => $this->limit_days,
            'user' => new UserResource($this->whenLoaded('user')), // Eager load user data
            'leave_type' => new LeaveTypeResource($this->whenLoaded('leaveType')), // Eager load leave type data
        ];
    }
}
