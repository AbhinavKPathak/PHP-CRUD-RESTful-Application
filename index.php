<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="./public/images/favicon.ico">
    <title>The Fred Cohen Company</title>
    <!-- Editable CSS -->
    <link href="http://js-grid.com/css/jsgrid.min.css" rel="stylesheet" />
    <link href="http://js-grid.com/css/jsgrid-theme.min.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link href="./public/css/style.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>

    <!-- use the font -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            font-size: 1em;
            color: black;
            background-color: #85200cff;
        }

        .hide {
            display: none;
        }

        .jsgrid-selected-row>.jsgrid-cell {
            background-color: #85200c;
            color: white;
        }

        .jsgrid-header-row>.jsgrid-header-cell {
            background-color: #85200c;
            color: white;
        }
    </style>
</head>

<body>
    <div id="container">
        <div class="container-fluid">
            <div class="row">
                <header style="width:100%;">
                    <nav>
                        <div id="logo" class="col-sm-5 col-xs-12 col-lg-3 col-md-3" style="float:left">
                            <a href="index.php">
                                <img src="./public/images/Custom_Logo.png" alt="homepage" height="100%" width="100%;" style="margin-left:-8%;margin-top:12%;"
                                />
                            </a>

                        </div>
                        <div id="slogan" class="col-sm-7 col-xs-12 col-lg-9 col-md-9" style="float:right;">
                            <h1 style="text-align:center;color:white;margin-top:5%;">Coverage Management</h1>
                            <blockquote style="text-align:center;border:none;color:white;">
                                <h3>&ldquo;Leading through perspiration&rdquo;</h3>
                            </blockquote>

                        </div>
                    </nav>
                </header>
                <!-- Column -->
                <div class="card col-sm-12 col-xs-12">
                    <div class="card-body" style="height:100%; background-color:white;">

                        <div id="message" class="alert alert-danger" style="display:none">
                        </div>

                        <div id="jsGrid" style="height:100%;margin-top:5%;"></div>

                    </div>
                </div>
            </div>
        </div>

        <footer class="footer" style="margin:10px;">
            © 2018 The Fred Cohen Company
        </footer>
    </div>
    </div>
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="http://js-grid.com/js/jsgrid.min.js"></script>
    <script src="./public/js/grid.js"></script>
</body>

</html>