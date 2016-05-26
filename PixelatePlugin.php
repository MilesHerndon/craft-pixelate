<?php
namespace Craft;

class PixelatePlugin extends BasePlugin
{
    public function getName()
    {
         return Craft::t('Pixelate');
    }

    public function getVersion()
    {
        return '1.0.0';
    }

    public function getDeveloper()
    {
        return 'MilesHerndon';
    }

    public function getDeveloperUrl()
    {
        return 'http://milesherndon.com';
    }

    public function hasCpSection()
    {
        return false;
    }

    public function addTwigExtension()
    {
        Craft::import('plugins.pixelate.twigextensions.PixelateTwigExtension');

        return new PixelateTwigExtension();
    }
}
