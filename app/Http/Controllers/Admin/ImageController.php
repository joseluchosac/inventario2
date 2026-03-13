<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function destroy(Image $image)
    {
        // Eliminando el archivo de la imagen
        Storage::delete($image->path);
        // Eliminando el registro de la imagen de la bd
        $image->delete();
    }
}
