<?
#
#
# Script to update the file checksum for existing files.
# This should be executed once, when checksums do not exist on the resources in the database, e.g. when upgrading from
# version 1.4 (which did not have the checksum feature) to 1.5
#
#
#
include "include/db.php";
include "include/authenticate.php";
include "include/general.php";
include "include/image_processing.php";
include "include/resource_functions.php";

$resources=sql_query("select ref,file_extension from resource where length(file_extension)>0");
for ($n=0;$n<count($resources);$n++)
	{
	generate_file_checksum($resources[$n]["ref"],$resources[$n]["file_extension"]);
	echo "Key for " . $resources[$n]["ref"] . " generated<br />";
	}
?>