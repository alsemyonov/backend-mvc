<?
$scaffold = array(
    'prefix'=>'',
    'projectName'=>'Project',
    'formTitle'=>'�ਬ��',
    'pageTitle'=>'�ਬ��',
    'columns'=>array(
        'id'=>array(
            'title'=>'ID',
            'isColumn'=>true
        ),
        'name'=>array(
            'title'=>'Name'
        ),
        'surname'=>array(
            'title'=>'Surname'
        ),
        'category_id'=>array(
            'title'=>'Category',
            'relation'=>array(
                'labelField'=>'title'
            )
        )
    ),

    'sets'=>array(
        array(
            'legend'=>'�᭮����',
            'fields'=>array('id', 'name', 'surname', 'category_id')
        )
    )
);
?>