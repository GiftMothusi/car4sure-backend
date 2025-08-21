<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PolicyResource extends JsonResource
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
            'policyNo' => $this->policy_no,
            'policyStatus' => $this->policy_status,
            'policyType' => $this->policy_type,
            'policyEffectiveDate' => $this->policy_effective_date->format('Y-m-d'),
            'policyExpirationDate' => $this->policy_expiration_date->format('Y-m-d'),
            'policyHolder' => $this->policy_holder,
            'drivers' => $this->drivers,
            'vehicles' => $this->vehicles,
            'createdAt' => $this->created_at->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updated_at->format('Y-m-d H:i:s'),
            'policyHolderName' => $this->policy_holder_name,
        ];
    }
}
