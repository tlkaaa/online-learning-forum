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
    <script src="<?php echo base_url(); ?>assets/js/jquery-3.6.0.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
</head>
<style>
    #float_home {
        position: fixed;
        width: 4.5em;
        height: 4.5em;
        bottom: 2%;
        right: 1%;
        border-radius: 100%;


    }
</style>

<body>
    <form action="https://infs3202-bb356835.uqcloud.net/demo/home">
        <input id="float_home" type="submit" value="Home" />
    </form>

    <nav class="navbar navbar-expand navbar-light bg-light">

        <div class="collapse navbar-collapse p-1">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item ml-3">
                    <a href="<?php echo base_url(); ?>login"> Home </a>
                </li>
            </ul>
            <ul class="navbar-nav my-0">
                <li class="nav-item mx-1">
                    <div class="dropdown dropleft">
                        <button class="btn btn-dark pl-4 pr-4" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Calendar
                        </button>
                        <div class="dropdown-menu mr-3 p-2" onclick="event.stopPropagation()"
                            aria-labelledby="dropdownMenuButton" style="width: 350px;">
                            <b>
                                <h5 class="text-center">
                                    <?php echo date("l | Y-m-d", time() + 600 * 60); ?>
                                </h5>
                            </b>
                            <b>To Do List:</b><br>
                            <p class="pl-2 pt-1">
                                <?php
                                $model = model('App\Models\Calender_model');
                                $todo = $model->get_todo();
                                if (!$todo->getResult()) {
                                    echo "Currently Empty";
                                } else {
                                    foreach ($todo->getResult() as $row) {
                                        echo date('d/n', strtotime($row->time)) . " - " . $row->task . "<br>";
                                    }
                                }

                                ?>
                            </p>
                            <p class="pl-2"><a href="<?php echo base_url() ?>todo">Edit To Do List</a></p>

                            <b>Upcomming Holidays:</b><br>
                            <p class="pl-2 pt-1">
                                <?php
                                $model = model('App\Models\Calender_model');
                                $model->calender();
                                ?>
                            </p>
                        </div>
                    </div>
                </li>
                <li class="nav-item mx-1">
                    <?php echo form_open(base_url() . 'profile'); ?>
                    <button type="submit" class="btn btn-primary">Profile</button>
                    <?php echo form_close(); ?>
                </li>
                <li class="nav-item mx-1">
                    <?php echo form_open(base_url() . 'login/logout'); ?>
                    <button id='log_out' type="submit" class="btn btn-danger">Log Out</button>
                    <?php echo form_close(); ?>
                </li>

            </ul>

        </div>

    </nav>

</body>
<script>
    //scroll to saved position 
    window.onload = function () {
        window.scrollTo(0, localStorage.getItem(window.location.href));
    }

    window.onscroll = function (event) {
        localStorage.setItem(window.location.href, window.pageYOffset);
        console.log(localStorage.getItem(window.location.href));
    };

    document.getElementById("log_out").onclick = function () {
        console.log("clear");
        localStorage.clear();
    }

</script>


</html>