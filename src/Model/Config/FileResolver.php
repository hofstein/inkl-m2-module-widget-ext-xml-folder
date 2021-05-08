<?php

declare(strict_types=1);

namespace Inkl\WidgetExtXmlFolder\Model\Config;

use Magento\Framework\Component\ComponentRegistrar;
use Magento\Framework\Component\DirSearch;
use Magento\Framework\Config\FileIteratorFactory;
use Magento\Framework\Config\FileResolverInterface;
use Magento\Framework\Module\Dir\Reader as ModuleReader;

class FileResolver extends \Magento\Widget\Model\Config\FileResolver implements FileResolverInterface
{
    private DirSearch $componentDirSearch;

    public function __construct(
        ModuleReader $moduleReader,
        FileIteratorFactory $iteratorFactory,
        DirSearch $componentDirSearch
    ) {
        parent::__construct($moduleReader, $iteratorFactory, $componentDirSearch);
        $this->componentDirSearch = $componentDirSearch;
    }

    public function get($filename, $scope)
    {
        $iterator = parent::get($filename, $scope);
        $widgetFolderFiles = $this->componentDirSearch->collectFiles(ComponentRegistrar::MODULE, 'etc/widget/*.xml');

        return $this->iteratorFactory->create(
            array_merge(
                array_keys($iterator->toArray()),
                $widgetFolderFiles
            )
        );
    }
}
