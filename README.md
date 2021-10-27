# training_project
This is a training project which consists of a simple form submission page.
The project's purpose is to showcase my object oriented programming skills.
The form fields are separated into different class files and the form itself is built by initializing instances (objects) of those classes. 
The data from the forms is validated and saved into separate JSON and IMG files on a local file system.
The other part of the project is an api, consisting of a cron job, which communicates with the main application and makes GET requests for each file.
It then decodes the JSON files and saves them on a MySQL database. It also saves the Img files on a local file system.
After that it makes a delete request for each file on the main application.
