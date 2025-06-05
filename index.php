<?php
if (!isset($_SESSION['login'])) {
    header("Location: views/auth/login.php");
    exit;
}

// <!doctype html>
// <html>

// <head>
//     <meta charset="UTF-8">
//     <meta name="viewport" content="width=device-width, initial-scale=1.0">
//     <link href="./public/assets/css/style.css" rel="stylesheet">
// </head>

// <body>
//     <h1 class="text-3xl bg-primary font-bold underline">
//         Hello world!
//     </h1>
// </body>

// </html>