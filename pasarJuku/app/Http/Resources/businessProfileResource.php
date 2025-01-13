<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class businessProfileResource extends JsonResource
{
    public $status;
    public $message;
    
    public function __construct($status, $message, $resource)
    {
        parent::__construct($resource);
        $this->status = $status;
        $this->message = $message;
    }

    public function toArray($request)
    {
        return [
            'success' => $this->status,
            'message' => $this->message,
            'data' => [
                'businessProfileID' => $this->businessProfileID,
                'userID' => $this->userID,
                'business_name' => $this->business_name,
                'business_address' => $this->business_address,
                'SIUP' => $this->SIUP, // Ini akan memanggil accessor SIUP dari model
                'bank_account' => $this->bank_account,
                'verified_status' => $this->verified_status,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ]
        ];
    }
}