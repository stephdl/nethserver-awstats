<?php
echo $view->header()->setAttribute('template', $T('AwstatsStatistics_Title'));
$dbConf = $view->getModule()->getPlatform()->getDatabase('configuration');
$dbVhosts = $view->getModule()->getPlatform()->getDatabase('vhosts');

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
        $host = explode(':',$_SERVER['HTTP_HOST']);
        $url = "https://".$host[0]."/awstats/awstats.pl?config=".$Name.'.vhost';
        echo '<tr>';
        echo "<td><b>$vhost</b></td>";
        echo "<td><a href='$url' target='_blank'><font color='blue'> $Name</font></a></td>";
        echo '</tr>';
    }
}
echo "</table>";
