<?php
namespace NethServer\Module\Awstats;
use Nethgui\System\PlatformInterface as Validate;
/**
 * Implement gui module for awstats
 */
class  Settings extends \Nethgui\Controller\AbstractController
{
    public function initialize()
    {
    $this->declareParameter('status', Validate::SERVICESTATUS, array('configuration', 'awstats', 'status'));
    $this->declareParameter('Minute', $this->createValidator()->integer()->greatThan(0)->lessThan(60), array('configuration', 'awstats', 'Minute'));
    $this->declareParameter('access', $this->createValidator()->memberOf('private','public'), array('configuration', 'awstats', 'access'));
    $this->declareParameter('Users', Validate::ANYTHING, array('configuration', 'awstats', 'Users'));
    parent::initialize();
    }

    public static function splitLines($text)
    {
        return array_filter(preg_split("/[,;\s]+/", $text));
    }
    public function readUsers($dbList)
    {
        return implode("\r\n", explode(',' ,$dbList));
    }
    public function writeUsers($viewText)
    {
        return array(implode(',', self::splitLines($viewText)));
    }
    public function validate(\Nethgui\Controller\ValidationReportInterface $report)
    {
        parent::validate($report);
        $itemValidator = $this->getPlatform()->createValidator(\Nethgui\System\PlatformInterface::USERNAME);
        foreach (self::splitLines($this->parameters['Users']) as $v) {
            if ( ! $itemValidator->evaluate($v)) {
                $report->addValidationErrorMessage($this, 'Users', 'Must be a user name', array($v));
                break;
            }
        }
    }

    protected function onParametersSaved($changedParameters)
    {
        parent::onParametersSaved($changedParameters);
        $this->getPlatform()->signalEvent('nethserver-awstats-update');
    }
}
