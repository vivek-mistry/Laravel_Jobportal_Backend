<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobRS extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $jobs = $this;
        return [
            'id' => $jobs->id,
            'category_id' => $jobs->category_id,
            'title' => $jobs->title,
            'company_name' => $jobs->company_name,
            'job_type' => $jobs->job_type,
            'skills' => ['skill' => explode(',', $jobs->skills)],
            'location' => $jobs->location,
            'description' => $jobs->description,
            'created_at'=> $jobs->created_at,
            'updated_at' => $jobs->updated_at,
            'category' => $jobs->category
        ];
    }
}
