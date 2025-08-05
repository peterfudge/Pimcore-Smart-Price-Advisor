<?php
namespace SmartPriceAdvisorBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;

class SmartPriceAdvisorBundle extends AbstractPimcoreBundle
{
    public function getJsPaths(): array
    {
        return [
            '/bundles/smartpriceadvisor/js/admin.js',
        ];
    }

    public function getContainerExtension(): ?\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new DependencyInjection\SmartPriceAdvisorExtension();
    }
}
