<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class IdolImage extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'idol_name', 'profile_image', 'gallery_images'];
    protected $casts = ['gallery_images' => 'array'];

    public function getIdolProfileImage()
    {
        return asset('storage/app/public/' . (!empty($this->profile_image) ? $this->profile_image : 'avatar.png') . '');
    }
}
