<?php
namespace Craft;

class WordItUpPlugin extends BasePlugin
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
        return 'http://mavrx.io';
    }

    public function hasCpSection()
    {
        return false;
    }

    public function addTwigExtension()
    {
        Craft::import('plugins.worditup.twigextensions.WordItUpTwigExtension');

        return new WordItUpTwigExtension();
    }
}
