<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    </head>
    <body>
        <form action='controller/login.php' method='post'>
            <div class='container'>
                <div class='row'>
                    <div class='col col-xs-4'>
                        <div class='card'>
                            <div class='card-header'>
                                LBC Login
                            </div>
                            <div class='card-body'>
                                <div class='row'>
                                    <div class='col col-xs-12'>
                                        <label>Username</label>
                                        <input type='text' class='form-control' name='user' />
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col col-xs-12'>
                                        <label>Password</label>
                                        <input type='text' class='form-control' name='pass' />
                                    </div>
                                </div>
                            </div>
                            <div class='card-footer'>
                                <div class='row'>
                                    <div class='col col-xs-12'>
                                        <button type='submit' class='btn btn-default'>Login</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>
