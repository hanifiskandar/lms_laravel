<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DesignationResource extends JsonResource
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
            'name' => $this->name,
            'level' => $this->level,
            'annual_leave' => $this->annual_leave,
            'sick_leave' => $this->sick_leave,
            'maternity_leave' => $this->maternity_leave,
            'paternity_leave' => $this->paternity_leave,
            'emergency_leave' => $this->emergency_leave,
            'unpaid_leave' => $this->unpaid_leave,
            'compassionate_leave' => $this->compassionate_leave,
            'study_leave' => $this->study_leave,
            'hospitalization_leave' => $this->hospitalization_leave,
            'marriage_leave' => $this->marriage_leave,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
