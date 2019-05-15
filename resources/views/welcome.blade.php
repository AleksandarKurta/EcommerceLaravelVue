<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="/css/app.css">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Ecommerce - Laravel Vue JS</title>
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <body>
        <div id="app">
            <div class="container-fluid">
                <div class="container">
                    <div class="row pt-1 pb-1">
                        <div class="col-md-4">
                            <i class="fa fa-envelope"></i> aleksandarkurta1988@gmail.com
                        </div> 
                        <div class="col-md-4">
                            <i class="fa fa-search"></i>Search
                        </div>
                        <div class="col-md-4">
                            <i class="fa fa-shopping-cart"></i>Cart <i class="fa fa-user"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid bg-dark">
                <nav class="container navbar navbar-expand-lg navbar-dark bg-dark">
                    <a class="navbar-brand" href="#">Navbar</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Link</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>

            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                    <img src="{{ asset('img/slider/slider1.jpg') }}" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h1>Some random Text</h1>
                            <p>...</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('img/slider/slider2.jpg') }}" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h1>Some random Text</h1>
                            <p>...</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('img/slider/slider3.jpg') }}" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h1>Some random Text</h1>
                            <p>...</p>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

            <div class="container-fluid offer pt-5 pb-3 bg-orange d-none d-md-block">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 m-right">
                            <h4>FREE SHIPPING</h4>
                            <p>Some Text</p>
                        </div>
                        <div class="col-md-4 m-right">
                            <h4>CALL US ANYTIME</h4>
                            <p>Some Text</p>
                        </div>
                        <div class="col-md-4">
                            <h4>OUR LOCATION</h4>
                            <p>Some Text</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid mt-5">
                <div class="container">
                    <div>
                        <div class="row">
                            <h3>Products</h3>
                        </div>
                        <div class="row">
                            <div class="underline"></div>
                        </div>
                    </div>

                    <front-products default_products="{{ $products }}"></front-products>

                </div>
            </div>



            <footer>
                <div class="container-fluid pt-5 bg-dark text-light mt-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="row">
                                    <h5>Meta</h5>
                                </div>
                                <div class="row mb-4">
                                    <div class="underline bg-light-p"></div>
                                </div>
                                <p><i class="fa fa-chevron-right" aria-hidden="true"></i> Register</p>
                                <p><i class="fa fa-chevron-right" aria-hidden="true"></i> Log In</p>
                                <p><i class="fa fa-chevron-right" aria-hidden="true"></i> Enter RSS</p>
                                <p><i class="fa fa-chevron-right" aria-hidden="true"></i> Comments</p>
                            </div>

                            <div class="col-md-3">
                                <div class="row">
                                    <h5>Recent Posts</h5>
                                </div>
                                <div class="row mb-4">
                                    <div class="underline bg-light-p"></div>
                                </div>
                                <div class="row">
                                    <div class="media">
                                        <img class="align-self-start mr-3" src="" alt="Generic placeholder image">
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="row">
                                    <h5>About</h5>
                                </div>
                                <div class="row mb-4">
                                    <div class="underline bg-light-p"></div>
                                </div>
                                <div class="row pr-5">
                                    <p>Lorem ipsum sim doloret Lorem ipsum sim doloret Lorem ipsum sim doloret Lorem ipsum sim doloret Lorem ipsum sim doloret Lorem ipsum sim doloret Lorem ipsum sim doloret Lorem ipsum sim doloret Lorem ipsum sim doloret.</p>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="row">
                                    <h5>Meta</h5>
                                </div>
                                <div class="row mb-4">
                                    <div class="underline bg-light-p"></div>
                                </div>
                                <p><i class="fa fa-chevron-right" aria-hidden="true"></i> Register</p>
                                <p><i class="fa fa-chevron-right" aria-hidden="true"></i> Log In</p>
                                <p><i class="fa fa-chevron-right" aria-hidden="true"></i> Enter RSS</p>
                                <p><i class="fa fa-chevron-right" aria-hidden="true"></i> Comments</p>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>

        </div>
        <script type="text/javascript" src="js/app.js"></script>
    </body>
</html>
