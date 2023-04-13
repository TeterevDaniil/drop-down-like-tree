////Функуия переработки массива в правильное расположение для дерева
<?php 
function convert($array, $i = 'telecom_id', $p = 'master_id')
{
if (!is_array($array)) {
return array();
} else {
$ids = array();
foreach ($array as $k => $v) {
if (is_array($v)) {
if ((isset($v[$i]) || ($i === false)) && isset($v[$p])) {
$key = ($i === false) ? $k : $v[$i];
$parent = $v[$p];
$ids[$parent][$key] = $v;
}
}
}
return (isset($ids[0])) ? convert_node($ids, 0, 'children') : false;
}
}

function convert_node($index, $root, $cn)
{
$_ret = array();
foreach ($index[$root] as $k => $v) {
$_ret[$k] = $v;
if (isset($index[$k])) {
$_ret[$k][$cn] = convert_node($index, $k, $cn);
}
}
return $_ret;
}

$emp_telecom_list[0]->telecom_id;
$data1 = json_decode(json_encode($emp_telecom_list[0]->telecom_id), true);

foreach ($data as $key1 => $value1) {
$master_id = $value1->master_id;
$k = false;
foreach ($data as $key => $value) {
if ($master_id == $value->telecom_id) {
$k = true;
}
}
if ($k == false && $value1->master_id != 0) {
$data[$key1]['master_id'] = 2;
}
}

$data = json_decode(json_encode($data), true);
$category = convert($data);

?>

/////////////вывод дерева по подготовленному массиву
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="/js/jquery.treeview.js"></script>
<link rel="stylesheet" href="/css/jquery.treeview.css">



<style type="text/css">
    .treeview label {
        margin: 0;
        display: inline-block;
        font-size: 12px;
        font-weight: normal;
        line-height: 14px;
        vertical-align: top;
        cursor: pointer;
    }

    .treeview input {
        margin: 0;
        padding: 0;
        vertical-align: top;
    }

    .prokrutka {
        max-width: 450px;
        max-height: 500px;
        background: #fff;
        /* цвет фона, белый */
        border: 1px solid #C1C1C1;
        /* размер и цвет границы блока */

        overflow-y: scroll;
        /* прокрутка по вертикали */
    }
</style>
</style>
<div class="row inline-flex prokrutka">
    <label class="col-sm-1" style="width: 100px;">Телеком:</label>
    <?php

    function out_tree_radio($array, $first = true)
    {
        if ($first) {
            $out = '<ul id="tree-radio" style="margin-top: 2px; margin-bottom: -8px;" class="treeview col-sm">';
        } else {
            $out = '<ul>';
        }
        foreach ($array as $row) {
            if ($first) {
                $out .= "<li id='first'>";
                $out .= '<label id="first_lable"><input onclick="collapse(this)" type="radio" name="category" value="' . $row['telecom_id'] . '"> ' . $row['name'] . '</label>';
            } else {
                $out .= '<li>';
                $out .= '<label><input onclick="collapse(this)" type="radio" name="category" value="' . $row['telecom_id'] . '"> ' . $row['name'] . '</label>';
            }
            if (isset($row['children'])) {
                $out .= out_tree_radio($row['children'], false);
            }
            $out .= '</li>';
        }
        $out .= '</ul>';
        return $out;
    }

    $telecoms; ////////////получение подготовленного массива
    echo out_tree_radio($telecoms);


    ?>



    ///////ссылка на библиатеку https://github.com/jzaefferer/jquery-treeview
