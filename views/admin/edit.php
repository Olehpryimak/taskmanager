
<?php include ROOT . '/views/layouts/header.php'; ?>

<section>
    <div class="container" style="margin: 5%">
        <div class="col-md-3"></div>
        <div class="col-md-5">

            <div class="well">

                <div class="form-group">
                    <form action="/admin/edit/<?php echo $task->id; ?>" method="post">
                        <div>
                            <h3><?php echo $task->user; ?></h3>
                        </div>
                        <div>
                            <h3><?php echo $task->email; ?></h3>
                        </div>
                        <br>
                        <input type="text" name="text" value="<?php echo $task->text; ?>" class="form-control" required>
                        <br>
                        <input type="checkbox" name="edited" value="1" <?php if($task->is_checked == 1):?>checked<?php endif;?> class="form-control">
                        <br>
                        <div style="text-align: center">
                            <button type="submit"  name="edit" class="btn btn-success btn-md" >Enter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-3" style="text-align: right; display:flex; justify-content:space-around">

            <button style="width: 100%;" class="btn-lg btn-success fa fa-tasks" onclick="document.location.href = '/'" > Tasks</button>
            <button style="width: 100%;"  class="btn-lg btn-success fa fa-plus" onclick="document.location.href = '/add'" > Add task</button>

        </div>
    </div>
</section>
