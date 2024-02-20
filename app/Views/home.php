<!-- <!DOCTYPE html>
<html>

<head>
    <title>Welcome to Home Page</title>
   
</head> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<body>
    <div class="container p-2">
        <div class="row border">
            <div class="col-lg-7 p-3 border-right-0 bg-light">
                <a href="<?php echo base_url(); ?>home/thread/<?php echo $id; ?>"><?php echo $subject; ?></a>
            </div>
            <div class="col-lg-1 pt-3 pb-3 border-right-0 border-left-0 bg-light">
                <?php echo $likes; ?> ♡  &nbsp;  <?php echo $views; ?> <i class="fa fa-eye"></i>
            </div>
            <div class="col-lg-2 pt-3 pb-3  bg-light">
                <?php echo $date_created; ?>
            </div>
            <div class="col-lg-2 pt-3 pb-3 bg-light">
                <div class="row">
                    <div class="col"><img src="<?php echo $thumbnail; ?>"></div>
                    <div class="col">
                        <?php echo $username; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>



    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ"
        crossorigin="anonymous"></script> -->


</body>
<!-- 

</html> -->