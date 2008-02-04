<?= "<?php\n";?>
class <?= $prefix.$controllerClass; ?> extends AjaxControllerBase
{
    function __construct()
    {
        $this->model = new <?= $modelClass; ?>();
    }
}
?>