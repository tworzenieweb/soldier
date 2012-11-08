<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Sonata Project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\MediaBundle\Resizer;

use Imagine\Image\ImagineInterface;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Gaufrette\File;
use Sonata\MediaBundle\Model\MediaInterface;
use Sonata\MediaBundle\Resizer\ResizerInterface;


class CropResizer implements ResizerInterface
{
    /**
     * ImagineInterface
     */
    protected $adapter;

    /**
     * string
     */
    protected $mode;

    /**
     * @param ImagineInterface $adapter
     * @param string           $mode
     */
    public function __construct(ImagineInterface $adapter, $mode)
    {
        $this->adapter = $adapter;
        $this->mode    = $mode;
    }
    
    /**
     * if ($srcBox->getWidth() > $srcBox->getHeight()) {
            $width  = $srcBox->getWidth()*($this->box->getHeight()/$srcBox->getHeight());
            $height =  $this->box->getHeight();
            //we center the crop in relation to the width
            $cropPoint = new Point((max($width - $this->box->getWidth(), 0))/2, 0);
        } else {
            $width  = $this->box->getWidth();
            $height =  $srcBox->getHeight()*($this->box->getWidth()/$srcBox->getWidth());
            //we center the crop in relation to the height
            $cropPoint = new Point(0, (max($height-$this->box->getHeight(),0))/2);
        }
 
        $box = new Box($width, $height);
        //we scale the image to make the smaller dimension fit our resize box
        $image = $image->thumbnail($box, \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND);
         
        //and crop exactly to the box
        $image->crop($cropPoint, $this->box)
     */

    /**
     * {@inheritdoc}
     */
    public function resize(MediaInterface $media, File $in, File $out, $format, array $settings)
    {
        if (!isset($settings['width'])) {
            throw new \RuntimeException(sprintf('Width parameter is missing in context "%s" for provider "%s"', $media->getContext(), $media->getProviderName()));
        }

        
        
        $image = $this->adapter->load($in->getContent());
        $size  = $media->getBox();

        
        
        
        if(!$settings['height']) {
          $settings['height'] =  $size->getHeight()*($settings['width']/$size->getWidth());
        }
        
        if(!$settings['width']) {
          $settings['width'] =  $size->getWidth()*($settings['height']/$size->getHeight());
        }
        
        if ($size->getWidth() > $size->getHeight()) {
          
          
            $p = $settings['height'] > $settings['width'] ? $settings['height'] : $settings['width'];
          
            
          
            $width  = $size->getWidth()*($p/$size->getHeight());
            $height =  $settings['height'];
            
            $point = new Point((max($width - $settings['width'], 0)) / 2, 0);
          
            
        } else {
            $width  = $settings['width'];
            
            $p = $settings['height'] > $settings['width'] ? $settings['width'] : $settings['height'];
            
            $height =  $size->getHeight()*($p/$size->getWidth());
            //we center the crop in relation to the height
            $point = new Point(0, (max($height-$settings['height'],0))/2);
        }
        


        $image = $image->thumbnail(new Box($width, $height), \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND);


        $image->crop($point, new Box($settings['width'], $settings['height']));

        $content = $image->get($format, array('quality' => $settings['quality']));
          

        $out->setContent($content);
    }

    /**
     * {@inheritdoc}
     */
    public function getBox(MediaInterface $media, array $settings)
    {
        $aW = $settings['width'] ? $settings['width'] : $size->getWidth()*($settings['height']/$size->getHeight());
        $aH = $settings['height'] ? $settings['height'] : $size->getHeight()*($settings['width']/$size->getWidth());

        return new Box($settings['width'] ? $settings['width'] : $aW, $settings['height'] ? $settings['height'] : $aH);
    }
}