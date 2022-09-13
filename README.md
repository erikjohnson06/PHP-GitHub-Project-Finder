GitHub PHP Project Finder
Author: Erik Johnson

## Instructions for Setting Up 
In order to get this site to work in your local environment, follow these instructions: 

1. In your local environment, create a subfolder in your /htdocs or /www directory named "project_finder". 

2. Copy this repository into your /htdocs/project_finder or /www/project_finder directory. 

3. If you'd prefer for the site to be located at the root directory instead, update the "baseURL" property 
within the app/Config/App.php file, and remove the "project_finder/" segment. 

4. Database setup: this will require importing the .sql file found within the root of the repository. Look for "project_finder.sql". 
Importing this file will create a test database in your local MySQL server named "project_finder_erikjohnson", as well as two tables to manage 
the application's repository data. These tables may include sample data already, but feel free to truncate them and start over. Passwords may 
need to be adjusted to your local MySQL settings. To adjust the credentials, edit the database properties contained in the ".env" settings file, 
located at the root directory. 

5. To successfully call the GitHub API, please ensure that you have the cURL extension enabled in your php.ini file. 

Please contact me if you have questions, or need assistance!
