<?php include ROOT . '/views/layouts/header.php'; ?>

<section>
    <div class="container" style="margin: 5%">
        <div class="row">
            <div class="col-sm-3">
                <div class="well">

                    <div class="form-group">
                        <form style="text-align: center" action="<?php echo trim($_SERVER['REQUEST_URI']); ?>" method="post">
                            
                            <h4 style="display: inline-block">By name</h4>
                            <input type="checkbox" <?php if($bName == 1):?>checked<?php endif;?> name="bName" value="1">
                            <br>
                            <h4 style="display: inline-block" >By email</h4>
                            <input type="checkbox" <?php if($bEmail == 1):?>checked<?php endif;?> name="bEmail" value="1">
                            <br>
                            <h4 style="display: inline-block">By status</h4>
                            <input type="checkbox" <?php if($bStatus == 1):?>checked<?php endif;?> name="bStatus" value="1">
                            <br>
                            <br>
                            <div style="text-align: center">
                                <button type="submit"  name="sorting" class="btn btn-success btn-md" >Sort</button>
                            </div>
                        </form>
                    </div>
                </div> 
            </div>
            <div class="col-sm-5">
                  
                <?php foreach ($tasks as $task): ?>
                    <div class = "well row" style="padding-bottom:30px">

                        <?php if ($task['is_checked'] == 1): ?>
                            <p class = "col-sm-11 tasksText form-group"><?php echo $task['text']; ?></p>
                            <p class="col-sm-1 fa fa-check"></p>
                        <?php else: ?>
                            <p class = "col-sm-12 tasksText form-group"><?php echo $task['text']; ?></p>
                        <?php endif; ?>
                        <div class="col-sm-2 tips"> Name</div>
                        <div class = "col-sm-3"><?php echo $task['user']; ?></div> 
                        <div class="col-sm-2 tips">E-mail </div>
                        <a href="mailto:<?php echo $task['email']; ?>"><div class = "col-sm-3"><?php echo $task['email']; ?></div></a>
                        <?php if ($admin): ?>
                            <button style="width: 100%;"  class="btn-lg btn-success fa fa-edit" onclick="document.location.href = '/admin/edit/<?php echo $task['id']; ?>'" > Edit</button>
                        <?php endif; ?>
                    </div>

                <?php endforeach; ?>
                <div><?php echo $pagination->get(); ?></div>
            </div>
            <div class="col-sm-3" style="text-align: right; display:flex; justify-content:space-around">

                <button style="width: 100%;" class="btn-lg btn-success fa fa-plus" onclick="document.location.href = '/add'" > Add task</button>
                <?php if ($admin): ?>
                    <button style="width: 100%;"  class="btn-lg btn-success fa fa-sign-out" onclick="document.location.href = '/admin/logout'" > Log out</button>
                <?php else: ?>
                    <button style="width: 100%;"  class="btn-lg btn-success fa fa-sign-in"  onclick="document.location.href = '/admin/login'" > Log in</button>
                <?php endif; ?>
            </div>


        </div>
    </div>
</section>
