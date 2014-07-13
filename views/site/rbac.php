<?php
/**
 * Page of rbac editor
 * @var yii\base\View $this
 */
use yii\helpers\Html;
?>

<h3>Edit RBAC Rules for <?php echo $action;?></h3>
<script type="text/javascript">
    $(function() {
            $('select').change(function(){
                    var val = this.options[this.selectedIndex].value, url = document.location.pathname + '?action=' + val;
                    document.location = url;
            });
    });
</script>
<div class="row">
<div class="col-md-3">

<?php

    echo Html::dropDownList('Roles', $action, $model->getRuleListData(),
            ['class' => 'form-control']
        );
?>
    <br>
    <button class="btn btn-primary" onclick="document.getElementById('roleName').submit();"type="button">Change Private Rules</button>
</div>

<div class="col-md-7">
    <form class="form-horizontal" id="roleName" method="post" role="form" >
        <input type="hidden" name="_csrf" value="<?php echo Yii::$app->request->getCsrfToken()?>">

<?php
    foreach($model->getRoleListData() as $roles) {
        echo $this->render('_roles', ['roles' => $roles, 'data' => $model->getRule($ruleName)]);
    }
?>
    </form>
</div>
</div>
