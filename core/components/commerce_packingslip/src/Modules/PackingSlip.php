<?php
namespace modmore\Commerce\PackingSlip\Modules;
use modmore\Commerce\Modules\BaseModule;
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
        return 'Your Name Here';
    }

    public function getDescription()
    {
        return $this->adapter->lexicon('commerce_packingslip.description');
    }

    public function initialize(EventDispatcher $dispatcher)
    {
        // Load our lexicon
        $this->adapter->loadLexicon('commerce_packingslip:default');

        // Add the xPDO package, so Commerce can detect the derivative classes
//        $root = dirname(dirname(__DIR__));
//        $path = $root . '/model/';
//        $this->adapter->loadPackage('commerce_packingslip', $path);

        // Add template path to twig
//        /** @var ChainLoader $loader */
//        $root = dirname(dirname(__DIR__));
//        $loader = $this->commerce->twig->getLoader();
//        $loader->addLoader(new FilesystemLoader($root . '/templates/'));
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
