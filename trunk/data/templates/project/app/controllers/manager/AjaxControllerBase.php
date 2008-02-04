<?php
class AjaxControllerBase extends IndexController
{
    var $model;

    function _parseParameters($req, $args) 
    {
        $query = $req->getQuery();

        $id         = isset($query['id'])?          $query['id']:           null;
        $conditions = isset($query['conditions'])?  $query['conditions']:   null;
        $page       = isset($query['page'])?        $query['page']:         null;

        return compact('id', 'query', 'conditions', 'page');
    }

    function get($req, $args)
    {
        extract($this->_parseParameters($req, $args));

        $result = $this->retreive($id, $query);
        unset($result['row']['password']);
        return $result;
    }

    function getall($req, $args)
    {
        return $this->model->retrieve('all', $this->_parseParameters($req, $args));
    }

    function getlist($req, $args) 
    {
        return $this->model->retrieve('list', $this->_parseParameters($req, $args));
    }

    function get($req, $args)
    {
        extract($this->_parseParameters($req, $args));

        $result = $this->retreive($id, $query);

        return $result;
    }

    function retreive($id, $query)
    {
        return array(
            'values' => $this->model->get($id)
        );
    }


    function onBeforeSave($id, &$row, $query, $req, $args)
    {
    }

    function onBeforeCreate(&$row, $query, $req, $args)
    {
    }

    function onBeforeUpdate($id, &$row, $query, $req, $args)
    {
    }

    function onAfterCreate($id, $row, $query, $req, $args)
    {
        return array('result'=>$id);
    }

    function onAfterUpdate($id, $row, $query, $req, $args)
    {
        return array('result'=>$id);
    }

    function onAfterSave($id, $row, $query, $req, $args)
    {
        return array('result'=>$id);
    }

    function save($req, $args)
    {
        $query = $req->getQuery();
        $id = $query['id'];
        $values = $query['values'];

        $this->onBeforeSave($id, $values, $query, $req, $args);
        if ($id)
        {
            $this->onBeforeUpdate($id, $values, $query, $req, $args);
            $result = $this->model->update($values, $id);
            $result = $this->onAfterUpdate($id, $values, $query, $req, $args);
        } else {
            $this->onBeforeCreate($values, $query, $req, $args);
            $id = $this->model->create($values);
            $result = $this->onAfterCreate($id, $values, $query, $req, $args);
        }
        $this->onAfterSave($id, $values, $query, $req, $args);
        
        return $result;
    }
   

    function getpage($req, $args)
    {
        $query = $req->getQuery('page');
        $page = $query['page'] > 0 ? $query['page'] : 1;
        return $this->model->getPage($page, 20, null, false);
    }

    function delete($req, $args)
    {
        $query = $req->getQuery();
        $id = $query['id'];
        $this->model->delete($id);
        return array('result' => true);
    }
    
    protected function moveUpload($name, $fileName)
    {
        $dirName = dirname($fileName);
        if (!is_dir($dirName)) {
            mkdir($dirName, 0777);
        }

        $tmpName = $_FILES[$name]['tmp_name'];
        if (@is_uploaded_file($tmpName) && move_uploaded_file($tmpName, $fileName)) {
            return true;
        }

        return false;
    }

    function moveImage($name, $fileName)
    {
        //dbg($_FILES);
        if (!empty($_FILES[$name])) {
            
            $dirName = dirname($fileName);
            if (!is_dir($dirName)) {
                mkdir($dirName, 0777);
            }

            $tmpFile = $_FILES[$name]['tmp_name'];
            $origFile = $_FILES[$name]['name'];

            $pathinfo = pathinfo($origFile);
            //dbg($pathinfo);
            $fileName .= '.' . $pathinfo['extension'];
            if (is_uploaded_file($tmpFile) && move_uploaded_file($tmpFile, $fileName)) {
                list($width, $height, $type, $attr) = getimagesize($fileName);
                
                $result = array(
                    $name.'_width' => $width,
                    $name.'_height' => $height,
                    $name.'_ext' => $pathinfo['extension'],
                    $name.'_size' => $_FILES[$name]['size'],
                    //$name.'_name' => $origFile,
                );
                //dbg($result);
                return $result;
            }
        }
        return false;
    }

}
?>