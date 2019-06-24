<?php
namespace modmore\Commerce\PackingSlip\Modules;
use modmore\Commerce\Admin\Util\Action;
use modmore\Commerce\Events\Admin\GeneratorEvent;
use modmore\Commerce\Events\Admin\ShipmentActions;
use modmore\Commerce\Modules\BaseModule;
use modmore\Commerce\PackingSlip\Admin\PrintSlip;
use Symfony\Component\EventDispatcher\EventDispatcher;

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

        // Add template path to the view
        $root = dirname(__DIR__, 2);
        $this->commerce->view()->addTemplatesPath($root . '/templates/');

        $dispatcher->addListener(\Commerce::EVENT_DASHBOARD_ORDERSHIPMENT_ACTIONS, [$this, 'addShipmentAction']);
        $dispatcher->addListener(\Commerce::EVENT_DASHBOARD_INIT_GENERATOR, [$this, 'initGenerator']);
    }

    public function addShipmentAction(ShipmentActions $event)
    {
        $shipment = $event->getOrderShipment();
        $event->addAction((new Action)
            ->setTitle('Print Packing Slip')
            ->setUrl($this->adapter->makeAdminUrl('packingslip/print', ['shipment' => $shipment->get('id')]))
            ->setModal(false)
            ->setNewWindow(true)
        );
    }

    public function initGenerator(GeneratorEvent $event)
    {
        $generator = $event->getGenerator();
        $generator->addPage('packingslip/print', PrintSlip::class);
    }
}
