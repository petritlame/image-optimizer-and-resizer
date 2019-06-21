<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 6/20/2019
 * Time: 4:13 PM
 */

namespace titi23\ImageOptimizer;


class ImageResizer
{
    private $percent;
    private $_uploadDir;
    private $_supportedFormat;
    private $url;

    /**
     *  Initialize form patent class ImageCompress
     */

    protected function init(){
        $this->percent = config('image-optimizer.resize_percent');
        $this->_uploadDir = public_path('/').config('image-optimizer.upload_dir');
        $this->_supportedFormat = config('image-optimizer.supportedFormat');
        $this->url = config('image-optimizer.upload_dir');
    }

    /**
     * @param $number
     * @param $percent
     * @return float|int
     */

    private function getPercentOfNumber($number, $percent){
        return ($percent / 100) * $number;
    }

    /**
     * @param $imageResourceId
     * @param $width
     * @param $height
     * @param $newWidth
     * @param $newHeight
     * @return resource
     */

    private function imageResize($imageResourceId,$width,$height, $newWidth, $newHeight) {
        $imgLayer=imagecreatetruecolor($newWidth,$newHeight);
        imagecopyresampled($imgLayer,$imageResourceId,0,0,0,0,$newWidth,$newHeight, $width,$height);
        return $imgLayer;
    }

    /**
     * @param $source
     * @param null $percent
     * @param bool $saveOriginal
     * @return bool
     * @throws \Exception
     */

    public function ResizeAspectRatio($source, $percent = null, $saveOriginal = false){

        // Initialize @var
        $folderPath = $this->_uploadDir;
        $supportedFormat = $this->_supportedFormat;
        $return_url = '';

        if (file_exists($source)) {


            $imgData = getimagesize($source);
            $width = $imgData[0];
            $height = $imgData[1];
            $fileSource = pathinfo($source);
            $ext = $fileSource['extension'];
            $imgData = getimagesize($source);

            if(in_array($imgData['mime'],$supportedFormat)) {

                if ($saveOriginal) {
                    if (!file_exists($folderPath . '/thumbnails')) {
                        mkdir($folderPath . '/thumbnails', 0777, true);
                    }
                    $fileNewName = $fileSource['filename'] . '_thump.' . $ext;
                    $folderPath = $this->_uploadDir . 'thumbnails/';
                    $return_url = $this->url.'thumbnails/'.$fileNewName;
                } else {
                    $fileNewName = $fileSource['filename'] . '.' . $ext;
                    $folderPath = $this->_uploadDir;
                    $return_url = $this->url.$fileNewName;
                }

                // Calculate new width and height of image saving original AspectRatio
                $percent ? $resizePercent = $percent : $resizePercent = $this->percent;
                $newWidth = $this->getPercentOfNumber($width, $resizePercent);
                $newHeight = $this->getPercentOfNumber($height, $resizePercent);

                // Resizing the original image
                switch ($imgData['mime']) {
                    case 'image/jpeg':
                        $src = imagecreatefromjpeg($source);
                        break;
                    case 'image/gif';
                        $src = imagecreatefromgif($source);
                        break;
                    default:
                        $src = imagecreatefrompng($source);
                }
                $imgLayer = $this->imageResize($src, $width, $height, $newWidth, $newHeight);
                $save = imagepng($imgLayer, $folderPath . $fileNewName);
                if ($save){
                    return $return_url;
                }else {
                    throw new \Exception('An Error Has Occurred','500');
                }
            }else{
                unlink($source);
                throw new \Exception('File is not in supported format','500');
            }
        }else{
            throw new \Exception('This File Does not Exist','500');
        }

    }

    /**
     * @param $source
     * @param $width
     * @param bool $saveOriginal
     */

    public function ResizeWidth($source, $newWidth, $saveOriginal = false){
        // Initialize @var
        $folderPath = $this->_uploadDir;
        $supportedFormat = $this->_supportedFormat;
        $return_url = '';
        if (file_exists($source)) {

            $imgData = getimagesize($source);
            $fileSource = pathinfo($source);
            $ext = $fileSource['extension'];
            $width = $imgData[0];
            $height = $imgData[1];
            $originalAspectRatio = $width / $height;
            $newHeight = $newWidth / $originalAspectRatio;
            if(in_array($imgData['mime'],$supportedFormat)) {

                if ($saveOriginal) {
                    if (!file_exists($folderPath . '/thumbnails')) {
                        mkdir($folderPath . '/thumbnails', 0777, true);
                    }
                    $fileNewName = $fileSource['filename'] . '_thump.' . $ext;
                    $folderPath = $this->_uploadDir . 'thumbnails/';
                    $return_url = $this->url.'thumbnails/'.$fileNewName;
                } else {
                    $fileNewName = $fileSource['filename'] . '.' . $ext;
                    $folderPath = $this->_uploadDir;
                    $return_url = $this->url.$fileNewName;
                }

                switch ($imgData['mime']) {
                    case 'image/jpeg':
                        $src = imagecreatefromjpeg($source);
                        break;
                    case 'image/gif';
                        $src = imagecreatefromgif($source);
                        break;
                    default:
                        $src = imagecreatefrompng($source);
                }
                $imgLayer = $this->imageResize($src, $width, $height, $newWidth, $newHeight);
                $save = imagepng($imgLayer, $folderPath . $fileNewName);

                if ($save){
                    return $return_url;
                }else {
                    throw new \Exception('An Error Has Occurred','500');
                }

            }else{
                unlink($source);
                throw new \Exception('File is not in supported format','500');
            }
        }else{
            throw new \Exception('This File Does not Exist','500');
        }

    }

}
