<?
$scaffold = array(
    'prefix'=>'re',
    'projectName'=>'Real',

    'columns'=>array(
        'id'=>array(
            'title'=>'ID'
        ),
        'login'=>array(
            'title'=>'�����'
        ),
        'password'=>array(
            'title'=>'������'
        ),
        'email'=>array(
            'title'=>'E-mail'
        ),
        'status'=>array(
            'title'=>'������'
        )
    ),

    'list'=>array(
        'title'=>'������������',
        'columns'=>array('id', 'login', 'email', 'status')
    ),

    'form'=>array(
        'title'=>'������������',
        'sets'=>array(
            array(
                'legend'=>'��������',
                'fields'=>array('id', 'login', 'email', 'password', 'status')
            )
        )
    )
);
?>