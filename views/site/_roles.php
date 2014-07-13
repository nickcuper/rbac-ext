<?php
    $isHasparmas = isset($data->private_id[$roles]);
    $allow = '';
    $deny = '';
    if ($isHasparmas) {
        $allow = isset($data->private_id[$roles]['allow']) ? implode(',',$data->private_id[$roles]['allow']): $allow;
        $deny = isset($data->private_id[$roles]['deny']) ? implode(',',$data->private_id[$roles]['deny']): $deny;
        #var_dump($data->private_id[$roles]['deny']);
    }
?>
<div class="panel panel-default">
    <div class="panel-heading"><b><?php echo $roles; ?></b></div>
    <div class="panel-body">

            <div class="form-group">
                <label for="<?php echo $roles; ?>_allow" class="col-sm-2 control-label">Allow</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="Rbac[<?php echo $roles; ?>][allow]" placeholder="Allow Post Ids" value="<?php echo $allow;?>">
                </div>
            </div>
            <div class="form-group">
                <label for="<?php echo $roles; ?>_deny" class="col-sm-2 control-label">Deny</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="Rbac[<?php echo $roles; ?>][deny]" placeholder="Deny Post Ids" value="<?php echo $deny;?>">
                </div>
            </div>

    </div>
</div>



