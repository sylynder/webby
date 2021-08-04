<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webby PHP</title>
    <style type="text/css">
        body {
            background-color: rgb(72, 4, 156);
            font: 16px/26px normal Helvetica, Arial, sans-serif;
        }

        .center-div {
            position: absolute;
            margin: auto;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            width: 50%;
            height: 80%;
            background-color: #f2f2f2;
            border-radius: 3px;
            -moz-box-shadow: 0 0 3px #ccc;
            -webkit-box-shadow: 0 0 3px #ccc;
            box-shadow: 0 0 3px #ccc;
        }

        .div-shadow {
            box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
        }

        .image {
            width: 80%;
            position: relative;
            margin: auto;
            text-align: center;
            padding: 12px;
        }

        .body {
            position: relative;
            padding: 20px;
            margin: 5px;
            height: 80%;
        }

        .small {
            font-size: 0.5em;
            font-style: italic;
        }

        .text-center {
            text-align: center;
        }

        a {
            color: #003399;
            background-color: transparent;
            font-weight: normal;
        }

        img {
            width: 20%;
        }

        h1 {
            color: #444;
            background-color: transparent;
            font-size: 30px;
            font-weight: 500;
            margin: 0 0 14px 0;
            padding: 14px 15px 10px 15px;
            text-align: center;
        }

        h2 {
            color: #444;
            background-color: transparent;
            font-size: 25px;
            font-weight: 500;
            margin: 0 0 14px 0;
            padding: 14px 15px 10px 0px;
        }

        p {
            color: #8c8b8b;
            line-height: 26px;
        }

        code {
            font-family: Consolas, Monaco, Courier New, Courier, monospace;
            font-size: 12px;
            background-color: #f5f5f5;
            border: 1px solid #48049c;
            color: #002166;
            display: block;
            margin: 14px 0 14px 0;
            padding: 12px 10px 12px 10px;
        }

        p.footer {
            font-size: 11px;
            line-height: 32px;
            padding: 0 10px 0 10px;
            margin: 20px 0 0 0;
            font-weight: 600;
        }

        * {
            box-sizing: border-box;
        }

        .row {
            display: flex;
        }
        
        .column {
            flex: 50%;
            padding: 10px;
            height: 150px;
        }
    </style>
</head>
<body>
    <div class="center-div div-shadow">
        <div class="image" style>
            <img src="<?=asset("webby-readme.png")?>" alt="">
        </div>
        <div class="body">
            <h1>Build awesomely with Webby! <br>
                <small class="small">
                    An extension of the CodeIgniter3 framework.
                </small>
            </h1>

            <div id="within">

                <p>If you would like to edit this page you'll find it located at:</p>
                <code>app/Views/welcome.php</code>

                <p>The corresponding controller for this page is found at:</p>
                <code>app/Web/app/controllers/App.php</code>

                <div class="row">
                    <div class="column">
                        <h2><a href="https://www.codeigniter.com/userguide3/index.html" target="_blank">Documention</a></h2>
                        <p>
                            Webby uses the HMVC Design Pattern but still follows CodeIgniter's Documentation guide at: 
                            <br>
                            <a href="javascript:void(0)">
                                CodeIgniter 3 Online Guide
                            </a>.
                        </p>
                    </div>
                    <div class="column">
                        <h2><a href="https://heartofphp.com" target="_blank">Heart of PHP</a></h2>
                        <p>A resource for PHP developers from beginners to intermediate level</p>
                    </div>
                </div>
            </div>

            <p class="text-center footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <strong>{memory_usage}</strong> memory used.</p>

            <p class="text-center footer">
                <?php echo (ENVIRONMENT === 'development') ?  'Webby <strong>' . WEBBY_VERSION . ' (PHP v'.phpversion().')</strong>' : '' ?>
            </p>
        </div>
    </div>
</body>
</html>