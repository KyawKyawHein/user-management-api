<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            'name'=>$this->name,
            'username'=>$this->username,
            'email'=>$this->email,
            'address'=>$this->address,
            'role'=>$this->role->name,
            'birthdate'=>$this->birthdate,
            'gender'=>$this->gender,
            'phone'=>$this->phone,
            'facebook_link'=>$this->facebook_link,
            'isActive'=>$this->isActive,
            'photo'=>$this->photo,
        ];
    }
}
