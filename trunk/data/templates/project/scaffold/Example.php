<?
$scaffold = array(
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
        'company_name'=>array(
            'title'=>'��������'
        ),
        'status'=>array(
            'title'=>'������',
            'valueTitles'=>array(
                'I'=>'���������',
                'A'=>'�������',
                'S'=>'���� ������'
            )
        ),
        'company_name'=>array(
            'title'=>'��������'
        ),
        'branch_id'=>array(
            'title'=>'������� ������������'
        ),
        'comment'=>array(
            'title'=>'�����������'
        ),
        'city_id'=>array(
            'title'=>'�����'
        ),
        'region_id'=>array(
            'title'=>'������'
        ),
        'is_agency'=>array(
            'title'=>'���������'
        ),
        'is_developer'=>array(
            'title'=>'����������'
        ),
        'is_renter'=>array(
            'title'=>'������������'
        ),
        'is_another'=>array(
            'title'=>'��������� �����������'
        )
    ),

    'list'=>array(
        'title'=>'������������',
        'columns'=>array(
            'id',
            'login'=>array('container'=>'editLink'),
            'email',
            'status',
            'company_name',
            'C1'=>array('container'=>'edit'),
            'C2'=>array('container'=>'del')
        ),
    ),

    'form'=>array(
        'title'=>'������������',
        'sets'=>array(
            array(
                'legend'=>'��������',
                'fields'=>array('login', 'email', 'password', 'status', 'company_name', 'branch_id', 'comment')
            ),
            array(
                'legend'=>'��������������',
                'fields'=>array('city_id', 'region_id')
            ),
            array(
                'legend'=>'��� �������',
                'fields'=>array('is_agency', 'is_developer', 'is_renter', 'is_another')
            )
        )
    )
);
?>