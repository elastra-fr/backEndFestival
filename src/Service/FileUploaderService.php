<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FileUploaderService
{

    private $slugger;

    public function __construct( SluggerInterface $slugger)
    {
 
        $this->slugger = $slugger;
    }

    public function upload(UploadedFile $file, ?string $targetDirectory = null): string
    {
    
        $extension = $this->getExtension($file->getClientMimeType());
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename . '-' . uniqid() . '.' . $extension;

        try {
            $file->move($targetDirectory, $fileName);
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


}
