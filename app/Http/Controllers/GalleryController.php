<?php

namespace App\Http\Controllers;

use App\Models\IdolImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function upload(Request $request)
    {

        // Fetch the idol entry
        $idol = IdolImage::where("user_id", Auth::user()->id)->first();

        if (!$idol) {
            return response()->json(['error' => 'Idol not found'], 404);
        }

        if ($request->hasFile('photocard')) {

            $file = $request->file('photocard');
            $extension = $file->getClientOriginalExtension();
            $filename = uniqid() . '_' . time() . '.' . $extension;
            $path = $file->storeAs('photocards', $filename, 'public');

            // Get existing gallery images (JSON field)
            $existingImages = $idol->gallery_images ?? [];

            // Append the new image path to the gallery_images array
            $existingImages[$request->photocard_id] = $path;

            // Update the record
            $idol->gallery_images = $existingImages;
            $idol->save();

            return response()->json(['success' => 'Image uploaded successfully!', 'path' => $path]);
        }

        return response()->json(['success' => false, 'message' => 'No file uploaded']);
    }

    public function delete($id)
    {

        $idolImage = IdolImage::where('user_id', Auth::user()->id)->first();

        if (isset($idolImage->gallery_images)) {
            $images = $idolImage->gallery_images;
            Storage::delete("storage/app/public/{$images[$id]}");
            unset($images[$id]);
            // $images = array_diff($idolImage->gallery_images, [$imagePath]);
            $idolImage->update(['gallery_images' => $images]);
        }
        return back()->with('success', 'Image deleted.');
    }
}
