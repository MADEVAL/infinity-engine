<?php

require "engine/library/db_orm.php";

$table = array_shift($url);
$column = array_shift($url);
$value = array_shift($url);
$database = new DatabaseStructure();
$database->generate();
$structure = $database->structure;

$database->connection->query("DELETE FROM $table WHERE $column='$value'");

$database->release();

?>

<h4>Deleting record ...</h4>

<script type="text/javascript">
	document.location = "<?=url()?>admin/data-view/<?=$table?>"
</script>