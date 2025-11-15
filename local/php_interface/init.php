<?php
$eventManager = \Bitrix\Main\EventManager::getInstance();

$eventManager->addEventHandler(
    'iblock',
    'OnBeforeIBlockElementAdd',
    'transliterateElementName'
);

/**
 * @param array &$arFields
 * @return bool
 */
function transliterateElementName(&$arFields)
{
    $TARGET_IBLOCK_ID = 1;

    if (isset($arFields['IBLOCK_ID']) && $arFields['IBLOCK_ID'] == $TARGET_IBLOCK_ID && !empty($arFields['NAME'])) {

        $params = [
            "max_len" => 100,
            "change_case" => "L",
            "replace_space" => "_",
            "replace_other" => "_",
            "delete_repeat_replace" => true,
            "use_google" => false,
        ];

        $arFields['CODE'] = CUtil::translit($arFields['NAME'], "ru", $params);
    }

    return true;
}