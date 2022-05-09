<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookAboutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $this
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'author' => $this->author,
            'bookimg' =>  $this->bookimg,
            'genre' => $this->getGenre->genre,
            'genrename' => $this->getGenre->genrename,
            'status' => $this->grtStatus->status,
            'reting' => $this->reting,
            'release' => $this->release,
        ];
    }
}
