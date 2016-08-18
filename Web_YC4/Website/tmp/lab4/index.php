<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Business Frontpage - Start Bootstrap Template</title>
    <link rel="stylesheet" type="text/css" href="templates/basicjoomla3.0template/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="templates/basicjoomla3.0template/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="templates/basicjoomla3.0template/css/business-frontpage.css">
    <script src="templates/basicjoomla3.0template/js/jquery.js"></script>
    <script src="templates/basicjoomla3.0template/js/bootstrap.min.js"></script>
</head>
<body>

    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
             <jdoc:include type="modules" name="logo" style="xhtml" />
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Start Bootstrap</a>
            </div>
            
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
             <jdoc:include type="modules" name="navbar" style="xhtml" />
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#">About</a>
                    </li>
                    <li>
                        <a href="#">Services</a>
                    </li>
                    <li>
                        <a href="#">Contact</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Image Background Page Header -->
    <!-- Note: The background image is set within the business-casual.css file. -->
    <header class="business-header">
        <div class="container">
             <jdoc:include type="message" />
             <jdoc:include type="component" />
             <jdoc:include type="modules" name="position-1" style="none" />
            <div class="row">
                <div class="col-lg-12">
               <jdoc:include type="modules" name="header" style="xhtml" />
                    <h1 class="tagline">Business Name or Tagline</h1>
                </div>
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <div class="container">

        <hr>

        <div class="row">
            <div class="col-sm-8">
             <jdoc:include type="modules" name="position-0" style="xhtml" />        
                <h2>What We Do</h2>
                <p>Introduce the visitor to the business using clear, informative text. Use well-targeted keywords within your sentences to make sure search engines can find the business.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Et molestiae similique eligendi reiciendis sunt distinctio odit? Quia, neque, ipsa, adipisci quisquam ullam deserunt accusantium illo iste exercitationem nemo voluptates asperiores.</p>
                <p>
                    <a class="btn btn-default btn-lg" href="#">Call to Action &raquo;</a>
                </p>
            </div>
            <div class="col-sm-4">
                <jdoc:include type="modules" name="position-2" style="xhtml" />
                <h2>Contact Us</h2>
                <address>
                    <strong>Start Bootstrap</strong>
                    <br>3481 Melrose Place
                    <br>Beverly Hills, CA 90210
                    <br>
                </address>
                <address>
                    <abbr title="Phone">P:</abbr>(123) 456-7890
                    <br>
                    <abbr title="Email">E:</abbr> <a href="mailto:#">name@example.com</a>
                </address>
            </div>
        </div>
        <!-- /.row -->

        <hr>

        <div class="row">
            <div class="col-sm-4">
            <jdoc:include type="modules" name="position-3" style="none" />
                <img class="img-circle img-responsive img-center" src="http://placehold.it/300x300" alt="">
                <h2>Marketing Box #1</h2>
                <p>These marketing boxes are a great place to put some information. These can contain summaries of what the company does, promotional information, or anything else that is relevant to the company. These will usually be below-the-fold.</p>
            </div>
            <div class="col-sm-4">
            <jdoc:include type="modules" name="position-4" style="none" />
                <img class="img-circle img-responsive img-center" src="http://placehold.it/300x300" alt="">
                <h2>Marketing Box #2</h2>
                <p>The images are set to be circular and responsive. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>
            </div>
            <div class="col-sm-4">
            <jdoc:include type="modules" name="position-5" style="none" />
                <img class="img-circle img-responsive img-center" src="http://placehold.it/300x300" alt="">
                <h2>Marketing Box #3</h2>
                <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>
            </div>
        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                <jdoc:include type="modules" name="footer" style="none" />
                    <p>Copyright &copy; Your Website 2014</p>
                </div>
            </div>
            <!-- /.row -->
        </footer>

    </div>
</body>

</html>
