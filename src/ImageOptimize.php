<?php

namespace titi23\ImageOptimizer;


class ImageOptimize extends ImageResizer
{
    private $_supportedFormat;
    private $_quality;
    private $_uploadDir;
    private $url;

    public function __construct()
    {
        $this->_supportedFormat = config('image-compress.supportedFormat');
        $this->_quality = config('image-compress.compressRate');
        $this->_uploadDir = public_path('/').config('image-compress.upload_dir');
        $this->url = config('image-compress.upload_dir');
    }

    public function ImageOptimized($source, $saveOriginal = false){
        $formats = $this->_supportedFormat;
        $quality = $this->_quality;
        $uploadDir = $this->_uploadDir;
//        $destination = '';

        //make dir to save optimized images if saveOriginal true.
        if (file_exists($source)) {
            if ($saveOriginal) {
                if (!file_exists($uploadDir . '/optimized')) {
                    mkdir($uploadDir . '/optimized', 0777, true);
                }
            }
            $imgData = getimagesize($source);
            $imgExtension = $imgData['mime'];
            if(in_array($imgExtension,$formats)) {
                switch ($imgExtension) {
                    case 'image/jpeg':
                        $image = imagecreatefromjpeg($source);
                        break;
                    case 'image/gif';
                        $image = imagecreatefromgif($source);
                        break;
                    default:
                        $image = imagecreatefrompng($source);
                }
                $return_url = '';
                if($saveOriginal) {
                    $baseName = pathinfo($source);
                    imagejpeg($image,$uploadDir.'optimized/compressed-'.$baseName['basename'], $quality);
                    $return_url = $this->url.'optimized/compressed-'.$baseName['basename'];
                }else{
                    $baseName = pathinfo($source);
                    imagejpeg($image,$uploadDir.'/'.$baseName['basename'], $quality);
                    $return_url = $this->url.$baseName['basename'];
                }
                return $return_url;

            }else{
                unlink($source);
                throw new \Exception('File is not in supported format','500');
            }
        }else{
            throw new \Exception('This File Does not Exist','500');
        }
    }

}
