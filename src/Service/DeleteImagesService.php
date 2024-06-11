<?php

namespace App\Service;

class DeleteImagesService
{
    public function deleteImages($imageSingleName, $directory)
    {
              
              $images =[ $imageSingleName, '600-'.$imageSingleName, '400-'.$imageSingleName, '200-'.$imageSingleName];
            
        foreach ($images as $image) {
            $file = $directory . '/' . $image;
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }
}