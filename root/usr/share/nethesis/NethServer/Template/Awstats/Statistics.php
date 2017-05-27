<?php
echo $view->header()->setAttribute('template', $T('AwstatsStatistics_Title'));

$awstatsStatus = $view->getModule()->getPlatform()->getDatabase('configuration')->getProp('awstats','status');

if ( $awstatsStatus !== 'enabled') {
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

$servername = $view->getModule()->getPlatform()->getDatabase('vhosts')->getAll();
foreach ($servername as $key=>$props) {

    $status = $view->getModule()->getPlatform()->getDatabase('vhosts')->getProp("$key",'status');
    if ($status  !== 'enabled') {
        continue;
    }

    $sn = $view->getModule()->getPlatform()->getDatabase('vhosts')->getProp("$key",'ServerNames');
    foreach (explode(',', $sn) as $sn2) {
        $host = explode(':',$_SERVER['HTTP_HOST']);
        $url = "https://".$host[0]."/awstats/awstats.pl?config=".$sn2;
        echo '<tr>';
        echo "<td><b>$key</b></td>";
        echo "<td><a href='$url' target='_blank'><font color='blue'> $sn2</font></a></td>";
    }
}

echo '</tr>';
echo "</table>";
