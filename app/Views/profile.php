<html>

<head>
    <title>My Profile</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
    <script src="<?php echo base_url(); ?>assets/js/jquery-3.6.0.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
    <link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />
    <style>
        #map {
            height: 500px;
        }
    </style>
</head>

<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone-amd-module.min.js"
    integrity="sha512-oQq8uth41D+gIH/NJvSJvVB85MFk1eWpMK6glnkg6I7EdMqC1XVkW7RxLheXwmFdG03qScCM7gKS/Cx3FYt7Tg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<body>

    <div class="container">
        <div class="row">
            <div class="col-4">
                <img src="<?php echo $profile_picture; ?>">
            </div>
            <div class="col-4">
                <div class="row">
                    <div class="col">
                        <p>
                            <?php echo $username ?>'s Profile
                        </p>
                        <p>Email:
                            <?php echo $email ?>
                        </p>
                        <p>Email Vertification Status:
                            <?php echo $verification; ?>
                            <?php echo $verification_link; ?>
                        </p>

                        <p>Phone number:
                            <?php echo $phone ?>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <?php echo form_open(base_url() . 'profile/update'); ?>
                        <button type="submit" class="btn btn-primary">Edit my details</button>
                        <?php echo form_close(); ?>
                    </div>
                    <div class="container">
                <a href="<?php echo base_url()?>profile/download" target="_blank">Download Account TransScript Here</a>
            </div>
                </div>

            </div>
            <div class="col-4">
                <h6>Change Profile Picture</h6>
                <!-- drag and drop -->

                <div class="col">
                    <form method="POST" action="<?php echo base_url() . 'profile/upload/dz'; ?>" class='dropzone'
                        name='image'></form>
                    <?php echo form_open_multipart(base_url() . 'profile/upload'); ?>
                    <input id="image" type="file" name='image'>
                    <button type="sumbit">Upload</botton>
                        <?php echo form_close() ?>
                </div>
            </div>
        </div>

        <div class="row bg-light">
            <div class="col">
                <p>User's Location</p>
                <div id="map"></div>
                <script src="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.js"></script>
            </div>
        </div>
        <div class="row">
            <div class="col mt-2">
                <h6>Liked Threads</h6>
            </div>
        </div>
    </div>
</body>

<script>
    // drop.ondragover = drop.ondragenter = function (e) {
    //     e.preventDefault();
    // };

    // drop.ondrop = function (e) {
    //     image.files = evt.dataTransfer.files;

    //     const dataTransfer = new DataTransfer();
    //     dataTransfer.items.add(e.dataTransfer.files[0]);
    //     image.files = dataTransfer.files;
    //     e.preventDefault();

    // };

    Dropzone.options.imageUpload = {
        maxFilesize: 1,
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        url: "<?php echo base_url("profile/upload") ?>"
    };

    var latitude;
    var longitude;

    navigator.geolocation.getCurrentPosition(showPosition);

    function showPosition(position) {
        latitude = position.coords.latitude;
        longitude = position.coords.longitude;

        var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 13);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
        marker.bindPopup("You are here!").openPopup();

    }

</script>
</body>


</html>