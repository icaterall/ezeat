<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    /**
     * @param Request $request
     */

    public function uploadFoodImage(Request $request)
    {
          if($_FILES["file"]["name"] != '')
{
 $test = explode('.', $_FILES["file"]["name"]);
 $ext = end($test);
 $name = rand(100, 999) . '.' . $ext;
 $location = './uploads/productimages/' . $name;  
 move_uploaded_file($_FILES["file"]["tmp_name"], $location);
 echo '<img src="'.$location.'" height="150" width="225" class="img-thumbnail" />';
}
    }

    public function uploadlogoFile(Request $request)
    {
        // Set the uplaod directory
        $uploadDir = '/uploads/storelogo';

        // Set the allowed file extensions
        $fileTypes = ['jpg', 'jpeg', 'gif', 'png']; // Allowed file extensions

        if (!empty($_FILES)) {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $uploadDir = $_SERVER['DOCUMENT_ROOT'].$uploadDir;
            //$targetFile = $uploadDir . $_FILES['Filedata']['name'];

            $split = explode('.', $_FILES['Filedata']['name']);
            $type = strtolower($split[sizeof($split) - 1]);
            $rname = time().'.'.$type;

            $targetPath = $uploadDir.'/';
            $targetFile = str_replace('//', '/', $targetPath).$rname;

            // Validate the filetype
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            if (in_array(strtolower($fileParts['extension']), $fileTypes)) {
                // Save the file
                move_uploaded_file($tempFile, $targetFile);
                echo $rname;
            } else {
                // The file type wasn't allowed
                echo 'Invalid file type.';
            }
        }
    }

    public function uploadmainFile(Request $request)
    {
        // Set the uplaod directory
        $uploadDir = '/uploads/storemain';

        // Set the allowed file extensions
        $fileTypes = ['jpg', 'jpeg', 'gif', 'png']; // Allowed file extensions

        if (!empty($_FILES)) {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $uploadDir = $_SERVER['DOCUMENT_ROOT'].$uploadDir;
            //$targetFile = $uploadDir . $_FILES['Filedata']['name'];

            $split = explode('.', $_FILES['Filedata']['name']);
            $type = strtolower($split[sizeof($split) - 1]);
            $rname = time().'.'.$type;

            $targetPath = $uploadDir.'/';
            $targetFile = str_replace('//', '/', $targetPath).$rname;

            // Validate the filetype
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            if (in_array(strtolower($fileParts['extension']), $fileTypes)) {
                // Save the file
                move_uploaded_file($tempFile, $targetFile);
                echo $rname;
            } else {
                // The file type wasn't allowed
                echo 'Invalid file type.';
            }
        }
    }

    /**
     * upload multipe files.
     *
     * @param Request $request
     */
    public function uploadMultipleFiles(Request $request)
    {
        // Set the uplaod directory
        $uploadDir = '/uploads/'.$request->input('section').'/large/';

        $fileData = $_FILES['Filedata'];
        if ($fileData) {
            $tempFile = $fileData['tmp_name'];
            $uploadDir = $_SERVER['DOCUMENT_ROOT'].$uploadDir;
            $targetFile = $uploadDir.$fileData['name'];

            // Validate the file type
            $fileTypes = ['jpg', 'jpeg', 'gif', 'png']; // Allowed file extensions
            $fileParts = pathinfo($fileData['name']);

            // Validate the filetype
            if (in_array(strtolower($fileParts['extension']),
                    $fileTypes) && filesize($tempFile) > 0 && $this->isImage($tempFile)) {
                // Save the file
                move_uploaded_file($tempFile, $targetFile);
                $this->resizeImage($_FILES['Filedata']['name'], $request->input('section'));
                echo 1;
            } else {
                // The file type wasn't allowed
                echo 'Invalid file type.';
            }
        }
    }

    /**
     * resize image to produce thumb images.
     *
     * @param $imageName
     */
    public function resizeImage($imageName, $section)
    {
        $image = imagecreatefromjpeg('uploads/'.$section.'/large/'.$imageName);
        $filename = $imageName;

        $thumb_width = 149;
        $thumb_height = 101;

        $width = imagesx($image);
        $height = imagesy($image);

        $original_aspect = $width / $height;
        $thumb_aspect = $thumb_width / $thumb_height;

        if ($original_aspect >= $thumb_aspect) {
            // If image is wider than thumbnail (in aspect ratio sense)
            $new_height = $thumb_height;
            $new_width = $width / ($height / $thumb_height);
        } else {
            // If the thumbnail is wider than the image
            $new_width = $thumb_width;
            $new_height = $height / ($width / $thumb_width);
        }

        $thumb = imagecreatetruecolor($thumb_width, $thumb_height);

        // Resize and crop
        imagecopyresampled($thumb,
            $image,
            0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
            0 - ($new_height - $thumb_height) / 2, // Center the image vertically
            0, 0,
            $new_width, $new_height,
            $width, $height);
        imagejpeg($thumb, 'uploads/'.$section.'/thumb/'.$filename, 90);
    }

    /**
     * @param $errno
     * @param $errstr
     * @param $errfile
     * @param $errline
     * @return bool
     */
    public function errorHandler($errno, $errstr, $errfile, $errline)
    {
        // In this script, the silently suppress any error generated by getimagesize
        // which will throw an error if the "image" isn't an image
        // ie doesn't have a valid width / height

        /* Don't execute PHP internal error handler */
        return true;
    }

    /**
     * Check if the file has a width and height.
     *
     * @param $tempFile
     * @return bool
     */
    public function isImage($tempFile)
    {
        // Get the size of the image
        $size = getimagesize($tempFile);

        if (isset($size) && $size[0] && $size[1] && $size[0] * $size[1] > 0) {
            return true;
        } else {
            return false;
        }
    }
}
