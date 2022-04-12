<?php
namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    private $targetDirectory;

    public function __construct()
    {
        $this->targetDirectory = getcwd() . "/assets/img/product/";
    }

    public function upload(String $var)
    {
        $uploadfile = $this->targetDirectory . basename($_FILES[$var]['name']);
        if (move_uploaded_file($_FILES[$var]['tmp_name'], $uploadfile)) {
            return $_FILES[$var]['name'];
        } else {
            return "erreur";
        }
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}