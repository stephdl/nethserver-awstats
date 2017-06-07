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
    $this->declareParameter('skipPrivateIp', Validate::SERVICESTATUS, array('configuration', 'awstats', 'skipPrivateIp'));
    $this->declareParameter('MaxNbOfDomain', Validate::POSITIVE_INTEGER, array('configuration', 'awstats', 'MaxNbOfDomain'));
    $this->declareParameter('MinHitDomain', Validate::POSITIVE_INTEGER, array('configuration', 'awstats', 'MinHitDomain'));
    $this->declareParameter('MaxNbOfHostsShown', Validate::POSITIVE_INTEGER, array('configuration', 'awstats', 'MaxNbOfHostsShown'));
    $this->declareParameter('MinHitHost', Validate::POSITIVE_INTEGER, array('configuration', 'awstats', 'MinHitHost'));
    $this->declareParameter('MaxNbOfLoginShown', Validate::POSITIVE_INTEGER, array('configuration', 'awstats', 'MaxNbOfLoginShown'));
    $this->declareParameter('MinHitLogin', Validate::POSITIVE_INTEGER, array('configuration', 'awstats', 'MinHitLogin'));
    $this->declareParameter('MaxNbOfRobotShown', Validate::POSITIVE_INTEGER, array('configuration', 'awstats', 'MaxNbOfRobotShown'));
    $this->declareParameter('MinHitRobot', Validate::POSITIVE_INTEGER, array('configuration', 'awstats', 'MinHitRobot'));
    $this->declareParameter('MaxNbOfDownloadsShown', Validate::POSITIVE_INTEGER, array('configuration', 'awstats', 'MaxNbOfDownloadsShown'));
    $this->declareParameter('MinHitDownloads', Validate::POSITIVE_INTEGER, array('configuration', 'awstats', 'MinHitDownloads'));
    $this->declareParameter('MaxNbOfPageShown', Validate::POSITIVE_INTEGER, array('configuration', 'awstats', 'MaxNbOfPageShown'));
    $this->declareParameter('MinHitFile', Validate::POSITIVE_INTEGER, array('configuration', 'awstats', 'MinHitFile'));
    $this->declareParameter('MaxNbOfOsShown', Validate::POSITIVE_INTEGER, array('configuration', 'awstats', 'MaxNbOfOsShown'));
    $this->declareParameter('MinHitOs', Validate::POSITIVE_INTEGER, array('configuration', 'awstats', 'MinHitOs'));
    $this->declareParameter('MaxNbOfBrowsersShown', Validate::POSITIVE_INTEGER, array('configuration', 'awstats', 'MaxNbOfBrowsersShown'));
    $this->declareParameter('MinHitBrowser', Validate::POSITIVE_INTEGER, array('configuration', 'awstats', 'MinHitBrowser'));
    $this->declareParameter('MaxNbOfScreenSizesShown', Validate::POSITIVE_INTEGER, array('configuration', 'awstats', 'MaxNbOfScreenSizesShown'));
    $this->declareParameter('MinHitScreenSize', Validate::POSITIVE_INTEGER, array('configuration', 'awstats', 'MinHitScreenSize'));
    $this->declareParameter('MaxNbOfRefererShown', Validate::POSITIVE_INTEGER, array('configuration', 'awstats', 'MaxNbOfRefererShown'));
    $this->declareParameter('MinHitRefer', Validate::POSITIVE_INTEGER, array('configuration', 'awstats', 'MinHitRefer'));
    $this->declareParameter('MaxNbOfKeyphrasesShown', Validate::POSITIVE_INTEGER, array('configuration', 'awstats', 'MaxNbOfKeyphrasesShown'));
    $this->declareParameter('MinHitKeyphrase', Validate::POSITIVE_INTEGER, array('configuration', 'awstats', 'MinHitKeyphrase'));
    $this->declareParameter('MaxNbOfKeywordsShown', Validate::POSITIVE_INTEGER, array('configuration', 'awstats', 'MaxNbOfKeywordsShown'));
    $this->declareParameter('MinHitKeyword', Validate::POSITIVE_INTEGER, array('configuration', 'awstats', 'MinHitKeyword'));

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
