<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>

</head>
<body>
<div class="container">
    <h1 class="text-center">You choose car!</h1>
    <hr/>
    <div class="row">
        <div class="col-md-12">
            <h4>Full fill order form</h4>
            <?php if(!empty($Errors)):?>

               <tr>
                  <td><div class="alert alert-danger" role="alert"><?=$Errors?></div></td>
             </tr>

            <?php endif;?>

            <form class="form" action="index.php" method="POST">

                <div class="form-group">
                    <label for="id_car">You choose</label>
                    <input type="text" class="form-control" id="id_car" name="id_car" placeholder="id_car" value="<?=$chosenID?>" >
                </div>

				<div class="form-group">
                    <label for="carName">CarName</label>
                    <input type="text" class="form-control" id="carName" name="carName" placeholder="CarName" value="<?=$AllInfo?>" >
                </div>

                <div class="form-group">
                    <label for="f_name">Enter you first name</label>
                    <input type="text" class="form-control" id="f_name" name="f_name" placeholder="first name">
                </div>

                <div class="form-group">
                    <label for="l_name">Enter you last name</label>
                    <input type="text" class="form-control" id="l_name" name="l_name" placeholder="last name">
                </div>

                <div class="form-group">
                    <label for="payment">Type of payment</label>
                    <select name="payment"  id="payment" class="form-control" >
                        <option value="Cash">cash</option>  
                        <option value="Credit_card">Credit card</option>
                    </select>
                </div>

                 <button type="submit" class="btn btn-outline-success btn-sm" name="SendOrder">Send order</button>
            </form>
        </div>
     </div>
</div>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
