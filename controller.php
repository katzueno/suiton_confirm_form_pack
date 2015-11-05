<?php
namespace Concrete\Package\SuitonConfirmFormPack;

use Package;
use BlockType;
use Loader;
use SinglePage;
use Core;
use User;
use Page;
use UserInfo;
use Exception;
use Concrete\Core\Block\BlockController;
use Route;
use Router;

defined('C5_EXECUTE') or die("Access Denied.");

class Controller extends Package
{

    protected $pkgDescription = "Form block with confirm flow";
    protected $pkgName = "Suiton Confirm Form";
    protected $pkgHandle = 'suiton_confirm_form_pack';
    protected $appVersionRequired = '5.7.3.1';
    protected $pkgVersion = '1.0.0';

     public function on_start()
    {
        $al = \Concrete\Core\Asset\AssetList::getInstance();
        $al->register('css', 'validationEngine_css', 'css/validationEngine.jquery.css', array(), $this);
        $al->register('css', 'form_support_css', 'css/form_support.css', array(), $this);

        $al->register('javascript', 'validationEngine-ja', 'js/jquery.validationEngine-ja.js', array(), $this);
        $al->register('javascript', 'validationEngine', 'js/jquery.validationEngine.js', array(), $this);
        $al->register('javascript', 'form_support_js', 'js/form_support.js', array(), $this);

        $al->registerGroup('suitosha', array(
            array('javascript', 'validationEngine-ja'),
            array('javascript', 'validationEngine'),
            array('javascript', 'form_support_js'),
            array('css', 'validationEngine_css'),
            array('css', 'form_support_css')
        ));
    }

    public function install()
    {
        // Run default install process
        $pkg = parent::install();
        $bt = BlockType::getByHandle('suiton_confirm_form');
        if (!is_object($bt)) {
            $bt = BlockType::installBlockType('stform', $pkg);
        }
    }

    public function upgrade()
    {
        $pkg = $this->getByID($this->getPackageID());
        parent::upgrade();
        Installer::upgrade($pkg);
    }

    public function uninstall() {
        parent::uninstall();
        $db = Loader::db();
        $db->Execute('DROP TABLE btFormSuitonForm');
    }
}
