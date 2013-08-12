<?php

require_once 'abstract.php';

/**
 * Magento Migrator Shell Script
 *
 * @category    Mage
 * @package     Mage_Shell
 * @author      Andrei.Mocanu <kezek.ma@gmail.com>
 */
class Mage_Shell_Migrator extends Mage_Shell_Abstract
{

    public function run()
    {
        if ($this->getArg('module')) {
            $moduleName = $this->getArg('module');
            $res = $this->getModuleResource($moduleName);
            $res->getConnection()->startSetup();
            if ($this->getArg('reset')) {
                $result = $res->getConnection()
                        ->delete(
                        $res->getTable('core_resource'), "code = '$res->resourceName'"
                );
                if ($result) {
                    echo <<<MESSAGE
$moduleName core_resource db entry deleted.

MESSAGE;
                } else {
                    echo <<<MESSAGE
Unable to delete core_resource db entry for $moduleName.

MESSAGE;
                }
            }
        else if ($this->getArg('to')) {
            $toVer = $this->getArg('to');
            $result = $res->getConnection()
                    ->update(
                        $res->getTable('core_resource'),
                        array('version' => $toVer, 'data_version' => $toVer),
                        "code = '$res->resourceName'"
                    );
            if ($result){
                echo <<<MESSAGE
$moduleName migrated to $toVer succesfully.

MESSAGE;
            } else {
                echo <<<MESSAGE
Unable to migrate $moduleName to $toVer.

MESSAGE;
            }
        }
      }
    }

    public function getModuleResource($moduleName)
    {
        $resources = Mage::getConfig()->getNode('global/resources')->children();
        foreach ($resources as $resName => $resource) {
            if (!$resource->setup) {
                continue;
            }
            if ($resource->setup->module == $moduleName) {
                $class = (string) $resource->setup->class;
                $res = new $class($resName);
                $res->resourceName = $resName;

                return $res;
            }
        }

        return false;
    }

    /**
     * Retrieve Usage Help Message
     *
     */
    public function usageHelp()
    {
        return <<<USAGE
Usage:  php migrator.php -- [options]

  --module <module> --reset             Show current version of <module> (as in core_resource)
  --module <module> --to <version>      Migrate module in database to <version> (in core_resource)
  help                                  This help

USAGE;
    }

}

$shell = new Mage_Shell_Migrator();
$shell->run();