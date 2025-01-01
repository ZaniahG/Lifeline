<?php

namespace App\Http\Controllers;

use App\Models\IdolImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class IdolImageController extends Controller
{
    public function index()
    {
        $idolImage = IdolImage::where('user_id', auth()->id())->first();
        return view('gallery', compact('idolImage'));
    }

    public function idolUpload(Request $request)
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
            $path = $file->storeAs('', $filename, 'public');

            // Update the record
            $idol->profile_image = $filename;
            $idol->save();

            return response()->json(['success' => 'Image uploaded successfully!', 'path' => $path]);
        }

        return response()->json(['success' => false, 'message' => 'No file uploaded']);
    }

    public function editIdolName(Request $request)
    {
        $idolImage = IdolImage::where('user_id', auth()->id())->first();
        return view('edit-idol-name', compact('idolImage'));
    }

    public function storeIdolName(Request $request)
    {
        $request->validate([
            'idol_name' => 'required|string',
        ]);

        $idolImage = IdolImage::where('user_id', auth()->id())->first();
        $idolImage->idol_name = $request->idol_name;
        $idolImage->update();

        return back()->with('success', 'Uploaded successfully.');
    }
}
