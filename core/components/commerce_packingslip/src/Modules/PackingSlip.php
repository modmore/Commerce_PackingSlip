<?php
namespace modmore\Commerce\PackingSlip\Modules;
use modmore\Commerce\Admin\Util\Action;
use modmore\Commerce\Events\Admin\ShipmentActions;
use modmore\Commerce\Modules\BaseModule;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Twig\Loader\ChainLoader;
use Twig\Loader\FilesystemLoader;

require_once dirname(dirname(__DIR__)) . '/vendor/autoload.php';

class PackingSlip extends BaseModule {

    public function getName()
    {
        $this->adapter->loadLexicon('commerce_packingslip:default');
        return $this->adapter->lexicon('commerce_packingslip');
    }

    public function getAuthor()
    {
        return 'modmore';
    }

    public function getDescription()
    {
        return $this->adapter->lexicon('commerce_packingslip.description');
    }

    public function initialize(EventDispatcher $dispatcher)
    {
        // Load our lexicon
        $this->adapter->loadLexicon('commerce_packingslip:default');

        // Add template path to twig
        /** @var ChainLoader $loader */
        $root = dirname(dirname(__DIR__));
        $loader = $this->commerce->twig->getLoader();
        $loader->addLoader(new FilesystemLoader($root . '/templates/'));

        $dispatcher->addListener(\Commerce::EVENT_DASHBOARD_ORDERSHIPMENT_ACTIONS, [$this, 'addShipmentAction']);
    }

    public function addShipmentAction(ShipmentActions $event)
    {
        $event->addAction((new Action)
            ->setTitle('Print Packing Slip')
            ->setUrl('/foo')
        );
    }

    public function getModuleConfiguration(\comModule $module)
    {
        $fields = [];

//        $fields[] = new DescriptionField($this->commerce, [
//            'description' => $this->adapter->lexicon('commerce_packingslip.module_description'),
//        ]);

        return $fields;
    }
}
