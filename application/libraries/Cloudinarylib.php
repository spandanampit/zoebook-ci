<?php
/**
 * This is a "dummy" library that just loads the actual library in the construct.
 * This technique prevents issues from CodeIgniter 3 when loading libraries that use PHP namespaces.
 * This file can be used with any PHP library that uses namespaces.  Just copy it, change the name of the class to match your library
 * and configs and go to town.
 */

defined('BASEPATH') OR exit('No direct script access allowed');

// Setup the dummy class for Cloudinary
class Cloudinarylib {

    public function __construct()
    {

        // include the cloudinary library within the dummy class
        require(APPPATH . 'libraries/cloudinary/src/Cloudinary.php');
        require APPPATH . 'libraries/cloudinary/src/Uploader.php';
        require APPPATH . 'libraries/cloudinary/src/Api.php';


        // configure Cloudinary API connection
        \Cloudinary::config(array(
            "cloud_name" => "dmiqh8jar",
            "api_key" => "874313898127652",
            "api_secret" => "MnDZFJxZzgeguXWsUkF6kMfauC8"
        ));

        // $cloudinary = new Cloudinary([
        //     'cloud' => [
        //       'cloud_name' => 'dmiqh8jar',
        //       'api_key'  => '874313898127652',
        //       'api_secret' => 'my_MnDZFJxZzgeguXWsUkF6kMfauC8secret',
        //     'url' => [
        //       'secure' => true]]]);

        // $name = '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/public/upload/compress_video/test.mp4';
        // // // $name = '/var/www/html/thinkerslane/public/upload/compress_video/file_example_MP4_480_1_5MG.mp4';
        // $response = \Cloudinary\Uploader::upload_large($name, [
        //     'resource_type' => 'video',
        //     'chunk_size' => 20000000,
        //     "timeout" => 60000]
        // );

        // print_r($response);die;
    }
}