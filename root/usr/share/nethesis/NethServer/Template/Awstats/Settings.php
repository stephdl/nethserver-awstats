<?php

/* @var $view Nethgui\Renderer\Xhtml */
echo $view->header()->setAttribute('template', $T('AwstatsSettings_header'));
echo $view->panel()
    ->insert($view->fieldsetSwitch('status', 'enabled',$view::FIELDSETSWITCH_CHECKBOX | $view::FIELDSETSWITCH_EXPANDABLE)->setAttribute('uncheckedValue', 'disabled')
->insert($view->radioButton('access', 'private'))
->insert($view->radioButton('access', 'public'))
->insert($view->textInput('Minute'))
->insert($view->textArea('Users', $view::LABEL_ABOVE)->setAttribute('dimensions', '5x30')->setAttribute('placeholder', $view['Users_default']))
->insert($view->fieldset('', $view::FIELDSET_EXPANDABLE)->setAttribute('template', $T('RoutedAdvanced_label')))
->insert($view->checkBox('skipPrivateIp', 'enabled')->setAttribute('uncheckedValue', 'disabled'))

->insert($view->textInput('MaxNbOfDomain'))
->insert($view->textInput('MinHitDomain'))

->insert($view->textInput('MaxNbOfHostsShown'))
->insert($view->textInput('MinHitHost'))

->insert($view->textInput('MaxNbOfLoginShown'))
->insert($view->textInput('MinHitLogin'))

->insert($view->textInput('MaxNbOfRobotShown'))
->insert($view->textInput('MinHitRobot'))

->insert($view->textInput('MaxNbOfDownloadsShown'))
->insert($view->textInput('MinHitDownloads'))

->insert($view->textInput('MaxNbOfPageShown'))
->insert($view->textInput('MinHitFile'))

->insert($view->textInput('MaxNbOfOsShown'))
->insert($view->textInput('MinHitOs'))

->insert($view->textInput('MaxNbOfBrowsersShown'))
->insert($view->textInput('MinHitBrowser'))

->insert($view->textInput('MaxNbOfScreenSizesShown'))
->insert($view->textInput('MinHitScreenSize'))

->insert($view->textInput('MaxNbOfRefererShown'))
->insert($view->textInput('MinHitRefer'))

->insert($view->textInput('MaxNbOfKeyphrasesShown'))
->insert($view->textInput('MinHitKeyphrase'))

->insert($view->textInput('MaxNbOfKeywordsShown'))
->insert($view->textInput('MinHitKeyword'))


);
echo $view->buttonList($view::BUTTON_SUBMIT); # | $view::BUTTON_HELP);
