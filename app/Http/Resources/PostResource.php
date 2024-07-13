<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
   public function toArray($request)
   {
    return[
        'id'=> $this->id,
        'titre'=>$this->titre,
        'contenu'=>$this->contenu,
        //'user_id'=> $this->user_id,
        'user' => $this->user->name

    ];

   }
}