<?php
namespace Craft;

use Twig_Extension;
use Twig_SimpleFunction;

class PixelateTwigExtension extends \Twig_Extension
{

    public function getName()
    {
        return 'Pixelate';
    }

    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('pixelate', array($this, 'pixelate')),
        );
    }

    public function pixelate($pic_url, $pixel_block_size)
    {
      if (!filter_var($pic_url, FILTER_VALIDATE_URL)){
        // die silently and alone
        return false;
      }
      else{
        // pixelate that shit
        $type = pathinfo($pic_url, PATHINFO_EXTENSION);
        $type = $type == 'jpg' ? 'jpeg' : $type;
        $image_create_function = 'imagecreatefrom'.$type;
        $original_image = $image_create_function($pic_url);

        $output = imagecreatetruecolor(imagesx($original_image), imagesy($original_image));

        imagefilter($original_image, IMG_FILTER_PIXELATE, $pixel_block_size);
        imagecopy($output, $original_image, 0, 0, 0, 0, imagesx($original_image) - 1, imagesy($original_image) - 1);
        imagedestroy($original_image);

        ob_start ();
        $image_function = 'image'.$type;
        $image_function($output);
        $image_data = ob_get_contents();
        ob_end_clean();
        $image_data_base64 = base64_encode($image_data);
        imagedestroy($output);
        return $image_data_base64;
      }
    }
}
