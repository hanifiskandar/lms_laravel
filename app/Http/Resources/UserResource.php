<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'username' => $this->username,
            'nric' => $this->nric,
            'dob' => $this->dob,
            'marital_status' => $this->marital_status,
            'mobile_phone' => $this->mobile_phone,
            'office_phone' => $this->office_phone,
            'designation_id' => $this->designation_id,
            'department_id' => $this->department_id,
            'address_line1' => $this->address_line1,
            'address_line2' => $this->address_line2,
            'address_line3' => $this->address_line3,
            'city' => $this->city,
            'state' => $this->state,
            'postcode' => $this->postcode,
            'country' => $this->country,
            'spouse_name' => $this->spouse_name,
            'spouse_nric' => $this->spouse_nric,
            'spouse_job' => $this->spouse_job,
            'spouse_employer' => $this->spouse_employer,
            'role' => $this->role,
            'is_active' => $this->is_active,
            
            // Relationships
            'leave_limits' => LeaveLimitResource::collection($this->whenLoaded('leaveLimits')),
            'children' => ChildrenResource::collection($this->whenLoaded('children')),
            'family_members' => FamilyMemberResource::collection($this->whenLoaded('familyMembers')),
            'emergency_contacts' => EmergencyContactResource::collection($this->whenLoaded('emergencyContacts')),
            'leave_requests' => LeaveRequestResource::collection($this->whenLoaded('leaveRequests')),
        ];
    }
}
