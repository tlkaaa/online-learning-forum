<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

</head>

<body>

    <!-- Button trigger modal -->
    <div class="container">
        <div class="row">
            <div class="col-2">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    Add a Comment
                </button>
            </div>
            <div class="col-3">
                <script src="https://code.jquery.com/jquery-3.6.4.min.js"
                    integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
                <button onclick="sendRequest()" id="ajax">
                    <?php echo $like; ?>
                </button>

                <script>
                    function sendRequest() {
                        var xhttp = new XMLHttpRequest();

                        xhttp.open("POST", "<?php echo base_url() . uri_string() . "/ajax"; ?>", true);
                        xhttp.setRequestHeader("X-Requested-With", "XMLHTTPRequest");
                        xhttp.send();

                        xhttp.onreadystatechange = function () {
                            if (this.readyState == 4 && this.status == 200) {
                                document.getElementById("ajax").innerHTML = this.responseText.substring(1, this.responseText.length - 1);
                            }
                        };
                    }
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
                    <h5 class="modal-title" id="exampleModalLabel">Comment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php echo form_open(base_url() . 'home/post_comment/' . $id); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <textarea class="form-control" rows="10" placeholder="Subject" required="required"
                            name="comment"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Post Comment</button>
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