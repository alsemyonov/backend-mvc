<?= "<?php\n";?>
class <?= $modelClass.'ManagerController'; ?> extends AjaxControllerBase
{
    function __construct()
    {
        $this->model = new <?= $modelClass; ?>();
    }
}
?>