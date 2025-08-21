<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePolicyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'policy_status' => 'required|in:Active,Inactive,Cancelled,Expired,Pending',
            'policy_type' => 'required|string|max:50',
            'policy_effective_date' => 'required|date|after_or_equal:today',
            'policy_expiration_date' => 'required|date|after:policy_effective_date',
            
            'policy_holder' => 'required|array',
            'policy_holder.firstName' => 'required|string|max:100',
            'policy_holder.lastName' => 'required|string|max:100',
            'policy_holder.address' => 'required|array',
            'policy_holder.address.street' => 'required|string|max:255',
            'policy_holder.address.city' => 'required|string|max:100',
            'policy_holder.address.state' => 'required|string|max:50',
            'policy_holder.address.zip' => 'required|string|max:10',
            
            'drivers' => 'required|array|min:1',
            'drivers.*.firstName' => 'required|string|max:100',
            'drivers.*.lastName' => 'required|string|max:100',
            'drivers.*.age' => 'required|integer|min:16|max:100',
            'drivers.*.gender' => 'required|in:Male,Female',
            'drivers.*.maritalStatus' => 'required|in:Single,Married,Divorced,Widowed',
            'drivers.*.licenseNumber' => 'required|string|max:50',
            'drivers.*.licenseState' => 'required|string|max:10',
            'drivers.*.licenseStatus' => 'required|in:Valid,Expired,Suspended,Revoked',
            'drivers.*.licenseEffectiveDate' => 'required|date',
            'drivers.*.licenseExpirationDate' => 'required|date|after:drivers.*.licenseEffectiveDate',
            'drivers.*.licenseClass' => 'required|string|max:10',
            
            'vehicles' => 'required|array|min:1',
            'vehicles.*.year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'vehicles.*.make' => 'required|string|max:50',
            'vehicles.*.model' => 'required|string|max:50',
            'vehicles.*.vin' => 'required|string|size:17',
            'vehicles.*.usage' => 'required|in:Pleasure,Commuting,Business,Farm',
            'vehicles.*.primaryUse' => 'required|string|max:100',
            'vehicles.*.annualMileage' => 'required|integer|min:0|max:200000',
            'vehicles.*.ownership' => 'required|in:Owned,Leased,Financed',
            
            'vehicles.*.garagingAddress' => 'required|array',
            'vehicles.*.garagingAddress.street' => 'required|string|max:255',
            'vehicles.*.garagingAddress.city' => 'required|string|max:100',
            'vehicles.*.garagingAddress.state' => 'required|string|max:50',
            'vehicles.*.garagingAddress.zip' => 'required|string|max:10',
            
            'vehicles.*.coverages' => 'required|array|min:1',
            'vehicles.*.coverages.*.type' => 'required|in:Liability,Collision,Comprehensive',
            'vehicles.*.coverages.*.limit' => 'required|numeric|min:0',
            'vehicles.*.coverages.*.deductible' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'policy_effective_date.after_or_equal' => 'The policy effective date must be today or later.',
            'policy_expiration_date.after' => 'The policy expiration date must be after the effective date.',
            'drivers.*.age.min' => 'Driver must be at least 16 years old.',
            'vehicles.*.vin.size' => 'VIN must be exactly 17 characters.',
            'vehicles.*.year.max' => 'Vehicle year cannot be more than one year in the future.',
        ];
    }
}