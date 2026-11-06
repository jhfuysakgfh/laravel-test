<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'roll_no' => $this->roll_no,
            'class' => $this->class,
            'section' => $this->section,
            'email' => $this->email,
            'image' => $this->image,
        ];
    }
}
