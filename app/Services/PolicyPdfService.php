<?php

namespace App\Services;

use App\Models\Policy;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PolicyPdfService
{
    public function generatePolicyPdf(Policy $policy): string
    {
        $data = [
            'policy' => $policy,
            'generatedAt' => now()->format('Y-m-d H:i:s'),
        ];

        $pdf = Pdf::loadView('policies.pdf', $data);
        
        $filename = 'policies/policy-' . $policy->policy_no . '.pdf';
        
        if (app()->environment('production')) {
            $fullPath = '/var/www/html/storage/app/persistent/' . $filename;
            if (!file_exists(dirname($fullPath))) {
                mkdir(dirname($fullPath), 0755, true);
            }
            file_put_contents($fullPath, $pdf->output());
        } else {
            Storage::disk('public')->put($filename, $pdf->output());
        }

        
        return $filename;
    }
}