<?php

namespace App\Http\Resources;

use App\Models\Award;
use App\Models\Task;
use Illuminate\Http\Resources\Json\JsonResource;

class AwardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
 
        return [
            'id' => $this->id,
            'award_users' => Award::where('award_user_id', '=', $this->award_user_id)->get(),
            'award_task_id' => $this->award_task_id,

        ];
    }
}
