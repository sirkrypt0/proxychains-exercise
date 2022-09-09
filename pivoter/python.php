<?php
    $code = 'print("hello world")';
    if(isset($_GET['code'])){
        $code = $_GET['code'];
        $code = str_replace('"', "'", $code);
        $execReturn = exec('python3 -c "' . $code. '"');
    }
?>

<html>
<head>
    <title>Python as a Service</title>
    <style>
        body {
            font-family: Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: left;
        }
        .wrapper{
            width: 70%;
            margin: 0 auto;
            margin-top: 2%
        }
        .form-control {
            display: block;
            width: 100%;
            height: calc(1.5em + .75rem + 2px);
            padding: .375rem .75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: .25rem;
            transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        }
        textarea.form-control {
            height: auto;
        }
        .btn {
            display: inline-block;
            font-weight: 400;
            color: #212529;
            text-align: center;
            vertical-align: middle;
            cursor: pointer;
            border: 1px solid transparent;
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: .25rem;
        }
        .btn-primary {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }
        code {
            font-size: 87.5%;
            color: #e83e8c;
            word-wrap: break-word;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <form action="." method="GET">
            <h1>Python Web IDE</h1>
            <p>The new Python Web IDE!</p>
            <textarea name="code" style="resize: none;" class="form-control" rows=20 id="code"><?= $code ?></textarea>
            <br>
            <input type="submit" class="btn btn-primary" value="Run!">
        </form>
        <?php if(isset($execReturn)) { ?>
            <code class="alert alert-success">
                <?= $execReturn ?>
            </code>
        <?php } ?>
    </div>
</body>
</html>
