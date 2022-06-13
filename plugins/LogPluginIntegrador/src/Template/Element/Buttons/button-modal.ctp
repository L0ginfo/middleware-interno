<?php 

$title      = isset($title)      ? $title : '';
$class      = isset($class)      ? $class : '';
$class_icon  = isset($class_icon)  ? $class_icon : '';
$data_target = isset($data_target) ? $data_target : '';

$table    = isset($table)    ? $table : '';
$column   = isset($column)   ? $column : '';
$path     = isset($path)     ? $path : '';
$type     = isset($type)     ? $type : '';
$table_id = isset($table_id) ? $table_id : '';
$show_get_files = isset($show_get_files) ? $show_get_files : ''; 
$callback_on_complete = isset($callback_on_complete) ? $callback_on_complete : '';
$max_files = isset($max_files) ? $max_files : '';

?>

<?= 
    $this->Form->button('<i class="fa '.$class_icon.'" aria-hidden="true"></i> &nbsp;' . $title, [
        'class' => $class,
        'data-toggle' => "modal",
        'data-target' => '#' . $data_target
    ])
?>

<?=
    $this->element('modal', [
        'id' => $data_target,
        'title' => $title,
        'table' => $table,
        'column' => $column,
        'path' => $path,
        'type' => $type,
        'table_id' => $table_id,
        'show_get_files' => $show_get_files,
        'callback_on_complete' => $callback_on_complete,
        'max_files' => $max_files

    ])
?>
