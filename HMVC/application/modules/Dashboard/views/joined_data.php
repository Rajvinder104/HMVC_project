<!-- Loop through the joined data and display it in the view -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>jointdata</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="card">
                <div class="card-body">
                <?php foreach ($result as $row) : ?>
                    <div class="col-6">
                        <h4>tbl_sponser_count</h4>
                    <p><?php echo $row->user_id; ?></p>
                    </div>
                    <div class="col-6">
                        <h4>tbl_income_wallet</h4>
                    <p><?php echo $row->user_id; ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

</body>

</html>