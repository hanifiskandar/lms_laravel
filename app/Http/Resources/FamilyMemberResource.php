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
            'mobile_phone' => $this->mobile_phone,
            'relation' => $this->relation,
            'martial_status' => $this->martial_status,
            'activity' => $this->activity,
            'organization' => $this->organization,
            'user' => new UserResource($this->whenLoaded('user')), // Eager load the user data
        ];
    }
}
