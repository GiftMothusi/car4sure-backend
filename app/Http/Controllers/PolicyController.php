<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePolicyRequest;
use App\Http\Requests\UpdatePolicyRequest;
use App\Http\Resources\PolicyResource;
use App\Models\Policy;
use App\Services\PolicyPdfService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function __construct(
        private PolicyPdfService $policyPdfService
    ) {
        
    }

    public function index(Request $request): JsonResponse
    {
        $query = Policy::forUser(auth()->id())
            ->with('user')
            ->orderBy('created_at', 'desc');

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('policy_no', 'like', "%{$search}%")
                  ->orWhereRaw("JSON_EXTRACT(policy_holder, '$.firstName') LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("JSON_EXTRACT(policy_holder, '$.lastName') LIKE ?", ["%{$search}%"]);
            });
        }

        if ($request->has('status') && $request->status) {
            $query->where('policy_status', $request->status);
        }

        $policies = $query->paginate($request->per_page ?? 15);

        return response()->json([
            'data' => PolicyResource::collection($policies->items()),
            'meta' => [
                'current_page' => $policies->currentPage(),
                'last_page' => $policies->lastPage(),
                'per_page' => $policies->perPage(),
                'total' => $policies->total(),
                'from' => $policies->firstItem(),
                'to' => $policies->lastItem(),
            ]
        ]);
    }

    public function store(StorePolicyRequest $request): JsonResponse
    {
        try {
            $policy = Policy::create([
                'user_id' => auth()->id(),
                ...$request->validated()
            ]);

            return response()->json([
                'message' => 'Policy created successfully',
                'data' => new PolicyResource($policy)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create policy',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Policy $policy): JsonResponse
    {
        if ($policy->user_id !== auth()->id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return response()->json([
            'data' => new PolicyResource($policy)
        ]);
    }

    public function update(UpdatePolicyRequest $request, Policy $policy): JsonResponse
    {
        if ($policy->user_id !== auth()->id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        try {
            $policy->update($request->validated());

            return response()->json([
                'message' => 'Policy updated successfully',
                'data' => new PolicyResource($policy->fresh())
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update policy',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Policy $policy): JsonResponse
    {
        if ($policy->user_id !== auth()->id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        try {
            $policy->delete();

            return response()->json([
                'message' => 'Policy deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete policy',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function generatePdf(Policy $policy): JsonResponse
    {
        if ($policy->user_id !== auth()->id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        try {
            $pdfPath = $this->policyPdfService->generatePolicyPdf($policy);

            return response()->json([
                'message' => 'PDF generated successfully',
                'download_url' => url("storage/{$pdfPath}")
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to generate PDF',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}