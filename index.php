<?php
require 'ConnectionClass.php';
require 'ApiFunctions.php';
$apiInfo = new ApiClass();
if (isset($_GET['SearchBtn'])) {
    if (empty($_GET['repo'])) {
        
    } else {
        $search_array = $apiInfo->getRepos();
    }
}
?>
<html>

    <head>
        <title>My Github Favorites</title>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="style.css">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js">
            < script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js" ></script>
        
        <script>
            var favorites = [];
            function AddToFav(elemName, id, latestTag) {
                var allItems = <?php echo json_encode($search_array); ?>;
                for (var i = 0; i < allItems.items.length; i++) {
                    if (allItems.items[i].full_name === elemName) {
                        var temp = {};
                        temp.full_name = allItems.items[i].full_name;
                        temp.language = allItems.items[i].language;
                        temp.latest_tag = latestTag;
                        favorites.push(temp);

                        var xmlhttp = new XMLHttpRequest();
                        xmlhttp.open("POST", "insert.php", true);
                        xmlhttp.onreadystatechange = function () {
                            if (this.readyState !== 4)
                                return;
                            if (this.status !== 200)
                                return alert("ERROR " + this.status + " " + this.statusText);
                        };
                        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xmlhttp.send("full_name=" + temp.full_name + "&language=" + temp.language + "&latest_tag=" + temp.latest_tag);
                    }
                }

                document.getElementById(id).style.visibility = "hidden";
                setInterval(function () {
                    $('#favorites').load("reloadPage.php")
                }, 1000);
            }

        </script>  
        <script>
            function removeFav(elemName) {

                var temp = {};
                temp.full_name = elemName;
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("POST", "deleteFavs.php", true);
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState !== 4)
                        return;
                    if (this.status !== 200)
                        return alert("ERROR " + this.status + " " + this.statusText);
                };

                xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xmlhttp.send("FullName=" + temp.full_name);

                var addId = "add_" + elemName.replace("/", "_");
                var addElement = document.getElementById(addId);
                if (addElement) {
                    document.getElementById(addId).style.visibility = "visible";
                }

                setInterval(function () {
                    $('#favorites').load("reloadPage.php")
                }, 1000);
            }
            function clearSearchDiv() {
                var inputText = document.getElementById('repo').value;
                //alert(inputText);
                if (!inputText) {
                    document.getElementById('repos').innerHTML = "";
                    // alert('leeg');
                }
            }
        </script>
    </head>

    <body>
        <section id="header">
            <h1>My Github Favorites</h1>
        </section>
        <section>
            <div id="section1">
                <form action="" id="formsearch">
                    <input id="repo" type="text" name="repo" value="<?php if (isset($_GET['repo'])) echo $_GET['repo']; ?>" onkeydown="clearSearchDiv();"  />
                    <button id="SearchBtn" name="SearchBtn">Search</button>
                </form>

                <?php
                if (isset($_GET['SearchBtn'])) {
                    if (empty($_GET['repo'])) {
                        echo 'Please enter the name of the repositories you want to search for.';
                    } else {
                        ?>
                        <table id="repos" class="results">
                            <tr>
                                <th>Name</th>
                                <th>Language</th>
                                <th>Latest Tag</th>
                            </tr>
                            <?php
                            $checkFavArray = $conObj->Display();
                            foreach ($search_array['items'] as $value) {
                                ?> 
                                <tr>
                                    <td><a href="https://github.com/<?php echo "$value[full_name]" ?>" target="_blank"><?php echo "$value[full_name]"; ?></a></td>
                                    <td><?php echo "$value[language]"; ?></td>
                                    <td><?php
                                        $tag_array = $apiInfo->getLatestTag($value['full_name']);
                                        if (sizeof($tag_array) <= 2) {
                                            echo '-';
                                        } else {
                                            echo "$tag_array[tag_name]";
                                        }
                                        ?></td>
                                        <?php
                                    $found = false;
                                    if (empty($checkFavArray)) {
                                        
                                    } else {
                                        foreach ($checkFavArray as $favs) {
                                            if (in_array($value['full_name'], $favs)) {
                                                $found = true;
                                                break;
                                            }
                                        }
                                    }

                                    if (!$found) {
                                        $addId = 'add_' . str_replace('/', '_', $value['full_name']);
                                        if (sizeof($tag_array) <= 2) {
                                            ?>
                                            <td>
                                                <a href="#" 
                                                   onclick="AddToFav('<?php echo $value['full_name'] ?>', '<?php echo $addId ?>');" 
                                                   id="<?php echo $addId ?>">Add
                                                </a></td>
                                            <?php
                                        } else {
                                            $checkFavArray = $conObj->Display();
                                            ?>
                                            <td>
                                                <a href="#" 
                                                   onclick="AddToFav('<?php echo $value['full_name'] ?>', '<?php echo $addId ?>', '<?php echo $tag_array['tag_name'] ?>');" 
                                                   id="<?php echo $addId ?>">Add
                                                </a>
                                            </td>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <?php
                                }
                                ?>
                            </tr>
                        <?php }
                        ?>
                    </table>
                    <?php
                }
                ?>

            </div>
            <div id="section2">
                <div id="favorites">

                    <?php
                    $favArray = $conObj->Display();

                    if (empty($favArray)) {
                        die();
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
                </div>
            </div>
        </section>

    </body>

</html>