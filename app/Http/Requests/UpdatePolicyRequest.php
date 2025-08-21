<?php 

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePolicyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'policy_status' => 'sometimes|in:Active,Inactive,Cancelled,Expired,Pending',
            'policy_type' => 'sometimes|string|max:50',
            'policy_effective_date' => 'sometimes|date',
            'policy_expiration_date' => 'sometimes|date|after:policy_effective_date',
            
            'policy_holder' => 'sometimes|array',
            'policy_holder.firstName' => 'required_with:policy_holder|string|max:100',
            'policy_holder.lastName' => 'required_with:policy_holder|string|max:100',
            'policy_holder.address' => 'required_with:policy_holder|array',
            'policy_holder.address.street' => 'required_with:policy_holder.address|string|max:255',
            'policy_holder.address.city' => 'required_with:policy_holder.address|string|max:100',
            'policy_holder.address.state' => 'required_with:policy_holder.address|string|max:50',
            'policy_holder.address.zip' => 'required_with:policy_holder.address|string|max:10',
            
            'drivers' => 'sometimes|array|min:1',
            'drivers.*.firstName' => 'required_with:drivers|string|max:100',
            'drivers.*.lastName' => 'required_with:drivers|string|max:100',
            'drivers.*.age' => 'required_with:drivers|integer|min:16|max:100',
            'drivers.*.gender' => 'required_with:drivers|in:Male,Female',
            'drivers.*.maritalStatus' => 'required_with:drivers|in:Single,Married,Divorced,Widowed',
            'drivers.*.licenseNumber' => 'required_with:drivers|string|max:50',
            'drivers.*.licenseState' => 'required_with:drivers|string|max:10',
            'drivers.*.licenseStatus' => 'required_with:drivers|in:Valid,Expired,Suspended,Revoked',
            'drivers.*.licenseEffectiveDate' => 'required_with:drivers|date',
            'drivers.*.licenseExpirationDate' => 'required_with:drivers|date|after:drivers.*.licenseEffectiveDate',
            'drivers.*.licenseClass' => 'required_with:drivers|string|max:10',
            
            'vehicles' => 'sometimes|array|min:1',
            'vehicles.*.year' => 'required_with:vehicles|integer|min:1900|max:' . (date('Y') + 1),
            'vehicles.*.make' => 'required_with:vehicles|string|max:50',
            'vehicles.*.model' => 'required_with:vehicles|string|max:50',
            'vehicles.*.vin' => 'required_with:vehicles|string|size:17',
            'vehicles.*.usage' => 'required_with:vehicles|in:Pleasure,Commuting,Business,Farm',
            'vehicles.*.primaryUse' => 'required_with:vehicles|string|max:100',
            'vehicles.*.annualMileage' => 'required_with:vehicles|integer|min:0|max:200000',
            'vehicles.*.ownership' => 'required_with:vehicles|in:Owned,Leased,Financed',
            
            'vehicles.*.garagingAddress' => 'required_with:vehicles|array',
            'vehicles.*.garagingAddress.street' => 'required_with:vehicles.*.garagingAddress|string|max:255',
            'vehicles.*.garagingAddress.city' => 'required_with:vehicles.*.garagingAddress|string|max:100',
            'vehicles.*.garagingAddress.state' => 'required_with:vehicles.*.garagingAddress|string|max:50',
            'vehicles.*.garagingAddress.zip' => 'required_with:vehicles.*.garagingAddress|string|max:10',
            
            'vehicles.*.coverages' => 'required_with:vehicles|array|min:1',
            'vehicles.*.coverages.*.type' => 'required_with:vehicles.*.coverages|in:Liability,Collision,Comprehensive',
            'vehicles.*.coverages.*.limit' => 'required_with:vehicles.*.coverages|numeric|min:0',
            'vehicles.*.coverages.*.deductible' => 'required_with:vehicles.*.coverages|numeric|min:0',
        ];
    }
}