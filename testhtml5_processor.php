<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    if (isset($_FILES['uploadedFile']))
    {
        $errors = [];
        $path = '/var/www/htdocs/dap-dbms/stash/';
	    $extensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
        $all_files = count($_FILES['uploadedFile']['tmp_name']);
        $file_name = md5($_FILES['uploadedFile']['name']);
        $file_tmp = $_FILES['uploadedFile']['tmp_name'];
        $file_type = $_FILES['uploadedFile']['type'];
        $file_size = $_FILES['uploadedFile']['size'];
        $file_ext = strtolower(end(explode('.', $_FILES['uploadedFile']['name'])));
        $file = $path . $file_name . "." . $file_ext;
        if (!in_array($file_ext, $extensions))
        {
            $errors[] = 'Extension not allowed: ' . $file_name . ' ' . $file_type;
        }
        if ($file_size > 2097152)
        {
            $errors[] = 'File size exceeds limit: ' . $file_name . ' ' . $file_type;
        }
        if (empty($errors))
        {
            move_uploaded_file($file_tmp, $file);
            //the uploaded file is stored in stash/ folder
            //this will be where we'll connect to a remote file server via SFTP and securely tranfer files            
            echo "File uploaded";
            die();


        }
        if ($errors)
            print_r($errors);
    }
}