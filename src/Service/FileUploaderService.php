<?php
namespace App\Service;

use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;


class FileUploaderService
{

    private $slugger;

    public function __construct( SluggerInterface $slugger)
    {
 
        $this->slugger = $slugger;
    }

/**
 * Fonction pour uploader un fichier image et le redimensionner
 *
 * @param UploadedFile $file
 * @param string|null $targetDirectory
 * @return string
 */
    public function upload(UploadedFile $file, 
    ?string $targetDirectory = null): string
    {
    
        $extension = $this->getExtension($file->getClientMimeType());
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename . '-' . uniqid() . '.' . $extension;

        try {
            $file->move($targetDirectory, $fileName);

            $resized600FileName = '600-' . $fileName;
            $resized400FileName = '400-' . $fileName;
            $resized200FileName = '200-' . $fileName;
            
            $resized600FilePath = $targetDirectory . '/' . $resized600FileName;
            $resized400FilePath = $targetDirectory . '/' . $resized400FileName;
            $resized200FilePath = $targetDirectory . '/' . $resized200FileName;

            $filePath = $targetDirectory . '/' . $fileName;

            $this->resizeImage($filePath, $resized600FilePath, 600);
            $this->resizeImage($filePath,  $resized400FilePath, 400);
            $this->resizeImage($filePath, $resized200FilePath, 200);




        } catch (FileException $e) {
            throw new \Exception('File upload failed: ' . $e->getMessage());
        }

        return $fileName;
    }

    private function getExtension(string $mimeType): string
    {
        switch ($mimeType) {
            case 'image/jpeg':
                return 'jpg';
            case 'image/png':
                return 'png';
            case 'image/avif':
                return 'avif';
            case 'image/webp':
                return 'webp';
            case 'image/gif':
                return 'gif';
            case 'image/svg+xml':
                return 'svg';
            default:
                throw new \Exception('Unsupported file type');
        }
    }

/**
 * Fonction pour redimensionner une image
 *
 * @param string $filePath
 * @param string $resizedFilePath
 * @param integer $targetWidth
 * @return void
 */
    private function resizeImage(string $filePath, 
    string $resizedFilePath, 
    int $targetWidth): void
    {
        $imagine = new Imagine();
        $image = $imagine->open($filePath);
        $size = $image->getSize();
        $ratio = $size->getWidth() / $size->getHeight();
        $targetHeight = (int) ($targetWidth / $ratio);

        $image->resize(new Box($targetWidth, $targetHeight), ImageInterface::FILTER_LANCZOS)
              ->save($resizedFilePath);
    }
}



