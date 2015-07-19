<?php

/**
 * Created by PhpStorm.
 * User: marvinscharle
 * Date: 19.07.15
 * Time: 17:20
 */
class ConclurerPageSrcImageObject extends WireData
{

    protected static $defaultConfig = array(
        'sets' => array()
    );
    protected $image;


    public function __construct(Pageimage $pageimage, $config=array()) {
        $this->image = $pageimage;

        // Set default config
        $this->data = self::$defaultConfig;
        foreach ($config as $c => $v) $this->data[$c] = $v;
    }

    public function getSrcSetString() {
        $originalSet = array();

        $width = $this->image->width;

        if (count($this->data['sets']) == 0) {
            // Calculate breakpoints (50%, 400px)
            $originalSet[] = $width/2;
            $originalSet[] = $width*2;
            if ($width/2 > 500) $originalSet[] = 400;
        }
        else {
            foreach ($this->data['sets'] as $x) {
                if (is_int($x)) {
                    // Values in pixels
                    $originalSet[] = $x;
                }
                elseif (is_float($x)) {
                    $originalSet[] = $width*$x;
                }
                else continue;
            }
        }

        $result = array();
        foreach ($originalSet as $widthInfo) {
            $result[] = $this->getImageSrcInformation($this->image->width($widthInfo), $widthInfo);
        }

        // Add original image to result set
        $result[] = $this->getImageSrcInformation($this->image, $width);

        return implode(', ', $result);
    }



    protected function ___getImageSrcInformation (Pageimage $image, $width) {
        return "{$image->url()} {$width}w";
    }
}