<?php
namespace NethServer\Module;
/**
 * Implementation of web statistic by awstats
 * 2017 stephane de Labrusse <stephdl@de-labrusse.fr>
 */
class Awstats extends \Nethgui\Controller\TabsController
{
    protected function initializeAttributes(\Nethgui\Module\ModuleAttributesInterface $base)
    {
        return \Nethgui\Module\SimpleModuleAttributesProvider::extendModuleAttributes($base, 'Configuration', 50);
    }
    public function initialize()
    {
        parent::initialize();
        $this->loadChildrenDirectory();
    }
}
