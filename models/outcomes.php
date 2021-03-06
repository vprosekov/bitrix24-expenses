<?php
require_once "include/utils.php"; //подключение бд

// function to get all outcomes with deal_id
function get_outcomes($deal_id)
{

    $query = "SELECT * FROM outcomes WHERE deal_id = ?";
    $result = queryDB($query, $deal_id);
    if($result){
        // return result as json
        return $result;
    }
    else{
        return [];
    }
}

// заходит на страницу, видит все затраты в виде списка(карточек или таблицы)
// при нажатии на кнопку "Добавить затрату", появляется форма для ввода данных о новой затрате
// Дальше при нажатии на кнопку подтвердить, все данные введенные в форму отправляются через ajax на utils.php с request="add_outcome" с прикрепленным id сделки
// При открытии затраты, открывается форма с возможностью изменения данных о затрате а также кнопка "удалить".
// При нажатии кнопки "Удалить", отправляется ajax на utils.php с request="delete_outcome" с прикрепленным id затраты
// В качестве возвращаемого значения через ajax возвращается полный список затрат сделки в виде json объекта
// При получении ajax ответа выводится полученный список затрат сделки