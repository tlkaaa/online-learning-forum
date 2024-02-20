<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
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

    <!-- Button trigger modal -->
    <div class="container">
        <div class="row">
            <div class="col-2">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    New Thread
                </button>
            </div>
            <div class="col-8">
                <script src="https://code.jquery.com/jquery-3.6.4.min.js"
                    integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
                <?php echo form_open(base_url() . 'home/thread/') ?>
                <form method="POST" name='search_ajax'>
                    <input type="text" onkeyup="sendRequest(this.value)" id='search_ajax' name='search_ajax'>
                    <button type="submit">go</button>
                    <div id="suggestions"></div>
                    <?php echo form_close() ?>
                </form>

                <script>
                    function sendRequest(str) {
                        var xhttp = new XMLHttpRequest();

                        xhttp.open("POST", "<?php echo base_url() . "home/ajax/"; ?>" + str, true);
                        xhttp.setRequestHeader("X-Requested-With", "XMLHTTPRequest");
                        xhttp.send();

                        xhttp.onreadystatechange = function () {
                            if (this.readyState == 4 && this.status == 200) {
                                document.getElementById("suggestions").innerHTML = this.responseText.substring(1, this.responseText.length - 1).replace("\\r\\n", "");
                            }
                        }
                    };



                </script>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create a Thread</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php echo form_open(base_url() . 'home/post_thread'); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <textarea rows="10" class="form-control" placeholder="Subject" required="required"
                            name="thread_subject"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Post Thread</button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
</body>

</html>