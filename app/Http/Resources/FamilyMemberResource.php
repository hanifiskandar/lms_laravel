<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FamilyMemberResource extends JsonResource
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
            'name' => $this->name,
            'nric' => $this->nric,
            'gender' => $this->gender,
            'dob' => $this->dob,
            'phone_number' => $this->phone_number,
            'relation' => $this->relation,
            'marital_status' => $this->marital_status,
            'activity' => $this->activity,
            'organization' => $this->organization,
            'user' => new UserResource($this->whenLoaded('user')), // Eager load the user data
        ];
    }
}
