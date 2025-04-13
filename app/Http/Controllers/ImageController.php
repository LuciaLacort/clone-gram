<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use League\CommonMark\Node\Block\Document;

class ImageController extends Controller
{
    public function store(Request $request){
        try {
            if(!$request->hasFile('file')) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se ha seleccionado ninguna imagen'
                ], 400);
            }
    
            $image = $request->file('file');
            
            // Validar tamaño máximo (2MB)
            if ($image->getSize() > 2048 * 1024) {
                return response()->json([
                    'success' => false,
                    'message' => 'La imagen no debe pesar más de 2MB'
                ], 422);
            }
            
            // Validate image
            if (!$image->isValid() || !in_array($image->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'gif'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'El archivo debe ser una imagen válida (jpg, jpeg, png, gif)'
                ], 422);
            }
            
            $imageName = Str::uuid() . '.' . $image->extension(); 
    
            $uploadPath = public_path('uploads');
            if(!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
    
            $serverImage = Image::read($image)
                ->cover(1080, 1350)
                ->encode();
    
            $imagePath = public_path('uploads') . '/' . $imageName;
            file_put_contents($imagePath, $serverImage);
                
            return response()->json([
                'success' => true,
                'message' => 'La imagen se ha subido correctamente',
                'image' => $imageName
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al subir la imagen: ' . $e->getMessage()
            ], 500);
        }



    }
}