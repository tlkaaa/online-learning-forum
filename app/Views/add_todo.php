<body>
    <div class="container">
        <div class="col">
            <strong>
                <p>
                    <?php echo $data; ?>
                </p>
            </strong>
        </div>
        <div id="accordion">
            <div class="card">
                <div class="card border-0" id="headingThree">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree"
                            aria-expanded="false" aria-controls="collapseThree">
                            - Delete To-Do Task
                        </button>
                    </h5>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                        <?php
                        $model = model('App\Models\Calender_model');
                        $todo = $model->get_todo();
                        if (!$todo->getResult()) {
                            echo "Currently Empty";
                        } else {
                            foreach ($todo->getResult() as $row) {
                                echo "<a href=\"". base_url()."todo/2/".$row->task ."\">" . date('d/n', strtotime($row->time)) . " - " . $row->task . "</a><br>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card border-0" id="headingTwo">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo"
                            aria-expanded="false" aria-controls="collapseTwo">
                            + Add New To-Do Task
                        </button>
                    </h5>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
                        <div class="col-4 offset-4">
                            <?php echo form_open(base_url() . 'todo'); ?>

                            <strong>
                                <h5 class="text-center">Add a New To-Do Task</h5>
                            </strong>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Task" required="required"
                                    name="task">
                            </div>
                            <div class="form-group">
                                <input type="date" class="form-control" placeholder="Confirm Password"
                                    required="required" name="date">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">Add Task</button>
                            </div>

                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>