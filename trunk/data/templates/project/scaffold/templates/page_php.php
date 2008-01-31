<?= "<?php\n";?>
class <?= $controllerClass; ?> extends AjaxControllerBase
{
    function __construct()
    {
        $this->model = new <?= $modelClass; ?>();
    }
}
?>