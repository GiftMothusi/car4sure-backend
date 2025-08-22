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
        
        return $pdf->output();
    }
}