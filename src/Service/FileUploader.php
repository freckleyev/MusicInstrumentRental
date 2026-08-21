<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    public function __construct(
        #[Autowire('%kernel.project_dir%/public/images')]
        private string $targetDirectory,
        private SluggerInterface $slugger,
    ) {
    }

    public function upload(UploadedFile $file, string $subDirectory = ''): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        $destination = $this->targetDirectory;
        if (!empty($subDirectory)) {
            $destination .= '/' . trim($subDirectory, '/');
        }

        try {
            $file->move($destination, $fileName);
        } catch (FileException $e) {
            // handle the error if the move fails
        }

        return $fileName;
    }

    public function getTargetDirectory(string $subDirectory = ''): string
    {
        if (!empty($subDirectory)) {
            return $this->targetDirectory . '/' . trim($subDirectory, '/');
        }

        return $this->targetDirectory;
    }
}