<?php
/*
 *
 * Self-editable HTML file using CKeditor
 *
 */

if (isset($_POST['content'])) {
    /* Handling POST of new content */
    $filename = __FILE__;
    $match_comment = "CONTENT";

    $new_content = $_POST['content'];
    // Cleaning new content from wrong newline and matching tag
    $new_content = preg_replace("/<!--$match_comment-->/", "", $new_content);
    $new_content = preg_replace("/\\r\\n/", "\n", $new_content);

    // Read current file and update the content
    $full_content = file_get_contents($filename);
    $full_content = preg_replace(
                        "/<!--$match_comment-->(.*?)<!--$match_comment-->/s",
                        "<!--$match_comment-->$new_content<!--$match_comment-->",
                        $full_content);

/*
    // For debug
    print "<pre>$new_content</pre>";
    print "<pre>$full_content</pre>";
    exit(0);
*/

    // Write to current file and redirect user
    file_put_contents($filename, $full_content);
    $script = basename(__FILE__, '.php');
    header("Location: $script");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Support homepage</title>
        <script src="//cdn.ckeditor.com/4.5.1/full/ckeditor.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    </head>
    <body>
<?php if ( isset($_GET['edit']) ) { ?>
    <form method="post">
        <textarea name="content" id="content" rows="10" cols="80">
<!--CONTENT-->
<h1>Support homepage</h1>
<!--CONTENT-->
        </textarea>
        <script>
            CKEDITOR.replace('content');
        </script>
        <button type="submit">Ok</button>
    </form>
</body>
<?php } else { ?>
    <form method="get"><input type="hidden" value="1" name=edit><button type="submit">Edit</button></form>
<!--CONTENT-->
<h1>MFI Support homepage</h1>
<!--CONTENT-->
<?php } ?>
</html>