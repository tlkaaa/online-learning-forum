<html>

<head>
    <title>INFS3202 Demo</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

</head>

<body>
    <div class="container">
        <h4>To Do List</h4>
        <p><?php
            $model = model('App\Models\Calender_model');
            $todo = $model->get_todo();
            if (!$todo->getResult()) {
                echo "Currently Empty";
            } else {
                foreach ($todo->getResult() as $row) {
                    echo date('d/n', strtotime($row->time)) . " - " . $row->task . "<br>";
                }
            }
        ?></p>
        
    </div>


</body>
<script>

</script>

</html>