<?php

namespace App\Service;

class DeleteImagesService
{

/**
 * Fonction pour supprimer une image sous plusieurs formats
 * 
 * @param string $imageSingleName
 * @param string $directory
 * @return void
 * 
 * 
 */

    public function deleteImages($imageSingleName, $directory)
    {

        $images = [$imageSingleName, '600-' . $imageSingleName, '400-' . $imageSingleName, '200-' . $imageSingleName];

        foreach ($images as $image) {
            $file = $directory . '/' . $image;
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }
}
