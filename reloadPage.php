<?php
require 'ConnectionClass.php';
//$conObj->Display();
?>
<?php
$favArray = $conObj->Display();
if (empty($favArray)) {
    
} else {
    ?>
    <table id="favRepos">
        <tr>
            <th>Name</th>
            <th>Language</th>
            <th>Latest Tag</th>
        </tr>
        <?php
        foreach ($favArray as $value) {
            ?> 
            <tr>
                <td><a href="https://github.com/<?php echo "$value[FullName]" ?>" target="_blank"><?php echo "$value[FullName]" ?></a></td>
                <td><?php echo "$value[Language]" ?></td>
                <td><?php echo "$value[LatestTag]" ?></td>                                  
                <td><a href="#" onclick="removeFav('<?php echo $value['FullName'] ?>');" id="refresh">Remove</a></td>
            </tr>

            <?php
        }
    }
    ?>
</table>

