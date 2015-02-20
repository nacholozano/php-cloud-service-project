# php-hosting-project

This is a PHP hosting project with learning purpose with PHP in server-side and jQuery in client-side
I have tried to use MVC. The 'index.php' would be the controller.

Status: developing

2015/02/19: Don't try this code, there are some problems I have to solve. 

Try a demo here: http://mycloud-nacholozano.rhcloud.com/

### Installation's notes

- Configure your server name, database user name, password and database name in 'conf-db.php'
- Configure a route in your server for folder's users in 'conf-app.php'
- Create database running 'modelo/create-db.php'

### Known problems

- Activate JavaScript in your browser. The file size check use JavaScript before uploading any file. I know I also have to do the check in the server-side.
- Problem with breadcrumbs when you migrate the project to other server.
- The PDF reports don't add the PDF size.

I know possible solutions for this problems. But I don't have time to fix them. 

### Features

- [x] Create folders 
- [x] Breadcrumbs
- [x] Upload files
- [x] Backup to selected folders or files
- [x] Create PDF with your folder information
- [x] Deleted folder and files
- [x] Rename folder and files
- [X] Add an image to a PDF file and send to your email account
