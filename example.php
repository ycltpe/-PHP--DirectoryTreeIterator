<?php
include 'DirectoryTreeIterator.php';

$DT = new DirectoryTreeIterator('D:\Projects\ZendFramework-1.11.10');
$DT->cumputeSize();
?>

<?php echo $DT->getPath()."[{$DT->getTotalSize()}]"; ?>
<pre>
<?php echo $DT->getDirectoriesListing(); ?>
</pre>
