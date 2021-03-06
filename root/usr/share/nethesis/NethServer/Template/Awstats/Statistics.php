<?php
echo $view->header()->setAttribute('template', $T('AwstatsStatistics_Title'));
$dbConf = $view->getModule()->getPlatform()->getDatabase('configuration');
$dbVhosts = $view->getModule()->getPlatform()->getDatabase('vhosts');
$systemName = $dbConf->getType('SystemName');
$domainName = $dbConf->getType('DomainName');

$host = explode(':',$_SERVER['HTTP_HOST']);

if ($dbConf->getProp('awstats', 'status') !== 'enabled') {
   echo $view->translate('AwstatDisabledByProp_label');
   return;
}

echo '<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
    padding: 5px;
}
</style>';

#nethserver-virtualhost table
echo '<table style="width:30%">';
echo '<caption>'.$view->translate('VirtualhostsStatistics_label').'</caption>';
echo '<tr>';
echo '<th>'.$view->translate('Virtualhosts_label').'</th>';
echo '<th>'.$view->translate('AwstatsDomainURL_label').'</th>';
echo '</tr>';


foreach ($dbVhosts->getAll() as $vhost=>$props) {

    $status = $dbVhosts->getProp("$vhost",'status');
    if ($status  !== 'enabled') {
        continue;
    }

    $ServerNames = $dbVhosts->getProp("$vhost",'ServerNames');
    foreach (explode(',', $ServerNames) as $Name) {
        $url = "https://".$host[0]."/awstats/awstats.pl?config=".$Name.'.vhost';
        echo '<tr>';
        echo "<td><b>$vhost</b></td>";
        echo "<td><a href='$url' target='_blank'><font color='blue'> $Name</font></a></td>";
        echo '</tr>';
    }
}
echo "</table>";

echo "<br>";

#manual configuration table as /etc/awstats/awstats.domain.com.conf
echo '<table style="width:30%">';
echo '<caption>'.$view->translate('ManualStatistics_label').'</caption>';
echo '<tr>';
echo '<th>'.$view->translate('Configuration_label').'</th>';
echo '<th>'.$view->translate('StatisticsURL_label').'</th>';
echo '</tr>';

$values = array();
$path = '/etc/awstats/';
$values = glob( $path . '*.{conf}', GLOB_BRACE);

# clean name
$values= str_replace($path,"",$values);
$values= str_replace("awstats.","",$values);
$values= str_replace(".conf","",$values);

#we remove some conf
$values= array_diff($values, array ('model','localhost.localdomain','maillog'));

foreach ($values as $Name) {
    if (preg_match ("/vhost/", $Name)) {
        continue;
    }
    $url = "https://".$host[0]."/awstats/awstats.pl?config=".$Name;
    echo '<tr>';
    echo "<td><b>$Name</b></td>";
    echo "<td><a href='$url' target='_blank'><font color='blue'> $Name</font></a></td>";
    echo '</tr>';
}
echo "</table>";

echo '<br>';

#default maillog stat
$urldefault = "https://".$host[0]."/awstats/awstats.pl?config=maillog";
echo '<table style="width:30%">';
echo '<caption>'.$view->translate('MailStatistics_label').'</caption>';
echo '<tr>';
echo "<td><b>".$view->translate('MailStatistics_label')."</b></td>";
echo "<td><a href='$urldefault' target='_blank'><font color='blue'>$systemName.$domainName</font></a></td>";
echo '</tr>';
echo "</table>";
