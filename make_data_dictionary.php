<?php
$db_host   = "127.0.0.1";                                    // Хост/IP
$db_user   = "root";                                        // Имя пользователя
$db_pass   = "";                                        // Пароль
$db_name   = "information_schema";                            // Имя БД
$db_target = "library";                                    // Целевая БД для формирования словаря
$db = mysqli_init();


if (!$db->real_connect($db_host, $db_user, $db_pass, $db_name)) {
    die('Ошибка подключения (' . mysqli_connect_errno() . ') '
        . mysqli_connect_error());
}
// if (!$db)
// 	die("Ошибка подключения к базе данных! Причина: " . mysqli_connect_error());

mysqli_query($db, "SET NAMES 'utf8mb4'");                     //Стандартная кодировка - UTF-8

$data = mysqli_query($db, "SELECT `column_key`, `column_name`, `data_type`, `character_maximum_length`, `is_nullable`, `column_comment`, `table_name`
								FROM `columns`
								WHERE `table_schema` = '$db_target'
								ORDER BY `table_name`");

$table_name = "";

echo '<table border="1" style="border-color: #000; border-collapse: collapse;">';
echo '<tr><td colspan="5" align="center"><strong>Словарь данных</strong></td></tr>';

foreach ($data as $row) {
    if (empty($table_name) || $table_name != $row['table_name']) {
        $table_name = $row['table_name'];
        echo '<tr><td colspan="5">' . $table_name . '</td></tr>';
        echo '<tr><td align="center"><strong>Ключ</strong></td><td align="center"><strong>Тип данных</strong></td><td align="center"><strong>Обязательное</strong></td><td align="center"><strong>Примечание</strong></td></tr>';
    }

    $key = $row['column_key'];
    $req = $row['is_nullable'];
    $type = $row['data_type'];
    $length = $row['character_maximum_length'];

    if ($key == "PRI")
        $key = "PK";

    if ($key == "MUL")
        $key = "FK";

    if ($key == "UNI")
        $key = "UK";

    if ($req == "YES")
        $req = "Нет";
    else
        $req = "Да";

    if (!empty($length))
        $type .= "($length)";

    echo '<tr> <td align="center">' . $row['column_name'] . '</td><td align="center">' . $type . '</td> </tr>';
}

echo '</table>';
