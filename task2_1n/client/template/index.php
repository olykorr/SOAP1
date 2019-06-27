<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

</head>
<body>

<div class="container">
    <h1 class="text-center">Cars</h1>
    <hr/>
    <?php if(!empty($Errors)):?>
      <?php foreach ($Errors as $error):?>
       <tr>
          <td><div class="alert alert-danger" role="alert"><?=$error?></div></td>
     </tr>
       <?php endforeach;?>
    <?php endif;?>
    <div class="row">
        <div class="col-md-3">
            <h4>Filters</h4>
            <form class="form" action="index.php" method="POST">
                <div class="form-group">
                    <label for="year">Year</label>
                    <input type="text" class="form-control" id="year" name="year" placeholder="Year" >
                </div>
                <div class="form-group">
                    <label for="brand">brand</label>
                    <input type="text" class="form-control" id="brand" name="brand" placeholder="brand">
                </div>
                <div class="form-group">
                    <label for="model">model</label>
                    <input type="text" class="form-control" id="model" name="model" placeholder="model">
                </div>
                <div class="form-group">
                    <label for="color">color</label>
                    <input type="text" class="form-control" id="color" name="color" placeholder="color">
                </div>
                <div class="form-group">
                    <label for="max_speed">max_speed</label>
                    <input type="text" class="form-control" id="max_speed" name="max_speed" placeholder="max_speed">
                </div>
                <div class="form-group">
                    <label for="engine">engine</label>
                    <input type="text" class="form-control" id="engine" name="engine" placeholder="engine">
                </div>

                 <button type="submit" class="btn btn-outline-info btn-sm" name="FindCar">Find car</button>
            </form>
        </div>
        <div class="col-md-9">
		<form class="form" action="index.php" method="POST">
            <table class="table table-hover table-responsive-sm">
                <thead>
                <tr>
                     <th>Year</th>
                    <th>Brand</th>
                    <th>Model</th>
					<th>Color</th>
					<th>Speed</th>
					<th>Price</th>
					<th>Bye</th>
                </tr>

                </thead>

                <tbody>
                <?php if(!empty($Cars)):?>
                    <?php foreach ($Cars as $car):?>
						 <tr>
							<td><?=$car['YEAR']?></td>
              <td><?=$car['BRAND']?></td>
              <td><?=$car['MODEL']?></td>
							<td><?=$car['COLOR']?></td>
							<td><?=$car['MAX_SPEED']?></td>
							<td><?=$car['PRICE']?></td>
							<td> <button type="submit" class="btn btn-outline-success btn-sm" value="<?=$car['ID']?>" name="Bye">Купить</button></td>
						</tr>

                    <?php endforeach;?>
                <?php else:?>
                    <tr>
                        <td colspan="3">Empty</td>
                    </tr>
                <?php endif;?>


                </tbody>
            </table>
			</form>
        </div>
    </div>
</div>


</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
