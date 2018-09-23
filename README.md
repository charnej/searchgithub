This project searches GitHub for repositories and displays the first 10 results, and allows the user to add them to their favorites. It was completed as part of the Shopify Web developer intern challenge.

In order to run this project, the following instructions need to be followed:

1. Import the database named githubfavorites.sql.
2. Open the php file name ConnectionClass.php and change the database settings if necessary.
3. Go to the php file named ApiFunctions.php
4. In the ApiFunctions file be sure to replace the '$token' variable with your personal access token, in the getRepos() function as well as in the getLatestTag() function.
5. In the getRepos() function, replace 'charnej' in the 'User-Agent:charnej' to your GitHub profile name.
6. In the getLatestTag() function, replace 'charnej' in the 'User-Agent:charnej' to your GitHub profile name.

**NOTE** The access token that is currently in the $token variable is not a valid access token and will not work. You need to replace it with a valid token in order for the application
