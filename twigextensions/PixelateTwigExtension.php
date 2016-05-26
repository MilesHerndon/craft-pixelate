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

    private function _roundDownToAny($n,$x) {
      return (ceil($n)%$x === 0) ? ceil($n) : ceil(($n+$x/2)/$x)*$x;
    }

    public function pixelate($pic_url, $pixel_block_size)
    {
      if (!filter_var($pic_url, FILTER_VALIDATE_URL)){
        // die silently and alone
        return false;
      }
      else{
        // pixelate that shit

        // grab filetype
        $type = pathinfo($pic_url, PATHINFO_EXTENSION);
        $type = $type == 'jpg' ? 'jpeg' : $type;
        // dynamically create image resource based on type
        $image_create_function = 'imagecreatefrom'.$type;
        $original_image = $image_create_function($pic_url);
        // round image size based on pixel block size to avoid black bars in image
        $round_width = $this->_roundDownToAny(imagesx($original_image), $pixel_block_size);
        $round_height = $this->_roundDownToAny(imagesy($original_image), $pixel_block_size);
        // create image identifier of original size
        $output = imagecreatetruecolor(imagesx($original_image), imagesy($original_image));
        // pixelate it
        imagefilter($original_image, IMG_FILTER_PIXELATE, $pixel_block_size);
        // throw rounded pixelated image onto original sized image reference
        imagecopy($output, $original_image, 0, 0, 0, 0, $round_width, $round_height);
        imagedestroy($original_image);

        ob_start ();
        // dynamically create image resource based on type
        $image_function = 'image'.$type;
        $image_function($output);
        $image_data = ob_get_contents();
        ob_end_clean();
        // return it as base64
        $image_data_base64 = base64_encode($image_data);
        imagedestroy($output);
        return $image_data_base64;
      }
    }
}
