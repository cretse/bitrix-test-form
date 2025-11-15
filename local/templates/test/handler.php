<?php
header('Content-Type: application/json');

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Неверный метод запроса.');
    }

    if (!\Bitrix\Main\Loader::includeModule('iblock')) {
        throw new Exception('Модуль инфоблоков не подключен.');
    }

    $IBLOCK_ID = 1;

    $rangeFrom = isset($_POST['range_from']) ? intval($_POST['range_from']) : 0;
    $rangeTo = isset($_POST['range_to']) ? intval($_POST['range_to']) : 0;
    $selectValue = isset($_POST['select']) ? htmlspecialcharsbx($_POST['select']) : 'Не выбрано';
    $radioValue = isset($_POST['radio']) ? htmlspecialcharsbx($_POST['radio']) : 'Не выбрано';
    $fullName = isset($_POST['full_name']) ? htmlspecialcharsbx($_POST['full_name']) : 'Без имени';
    $age = isset($_POST['age']) ? intval($_POST['age']) : 0;
    $checkboxes = isset($_POST['checkboxes']) ? htmlspecialcharsbx($_POST['checkboxes']) : 'Не выбрано';

    $el = new CIBlockElement;

    $PROP = [
        'RANGE_FROM' => $rangeFrom,
        'RANGE_TO'   => $rangeTo,
        'SELECT_VAL' => $selectValue,
        'RADIO_VAL'  => $radioValue,
        'FULL_NAME'  => $fullName,
        'AGE'        => $age,
        'CHECKBOXES' => $checkboxes,
    ];

    $arLoadProductArray = [
        "MODIFIED_BY"       => 1,
        "IBLOCK_SECTION_ID" => false,
        "IBLOCK_ID"         => $IBLOCK_ID,
        "PROPERTY_VALUES"   => $PROP,
        "NAME"              => "Заявка от " . $fullName,
        "ACTIVE"            => "Y",
    ];

    $PRODUCT_ID = $el->Add($arLoadProductArray);

    if ($PRODUCT_ID) {
        $data_to_return = [
            'message'    => 'Заявка №'.$PRODUCT_ID.' успешно отправлена!',
            'range'      => "от " . $rangeFrom . " до " . $rangeTo,
            'select'     => $selectValue,
            'radio'      => $radioValue,
            'fullName'   => $fullName,
            'age'        => $age,
            'checkboxes' => $checkboxes
        ];
        echo json_encode(['success' => true, 'data' => $data_to_return]);

    } else {
        throw new Exception('Ошибка при добавлении элемента: ' . $el->LAST_ERROR);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

die();