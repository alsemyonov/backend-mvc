<?php
class AjaxControllerBase extends BaseController
{
    var $model;
    var $cName;

    function _parseParameters($req, $args) 
    {
        $query = $req->getQuery();

        $id         = isset($query['id'])?          $query['id']:           null;
        $conditions = isset($query['conditions'])?  $query['conditions']:   null;
        $page       = isset($query['page'])?        $query['page']:         null;

        return compact('id', 'query', 'conditions', 'page');
    }

    function getall($req, $args)
    {
        return $this->retreive(null, $this->_parseParameters($req, $args));
    }

    function get($req, $args)
    {
        extract($this->_parseParameters($req, $args));

        $result = $this->retreive($id, $query);

        return $result;
    }

    function retreive($id, $query)
    {
        if (!$id) {
            return array(
                'items' => Application::$db->query('FROM '.$this->cName.' u')->toArray()
            );
        } else {
            $item = Application::$db->query('FROM '.$this->cName.' u WHERE id = ?', array($id))->toArray();
            $item = $item[0];
            return array(
                'values' => $item
            );
        }
            
    }

    function save($req, $args)
    {
        $query = $req->getQuery();
        $id = $query['id'];
        $values = $query['values'];
        if ($id) {
            $q = new Doctrine_Query();
            $model = $q->from($this->cName)->where('id = ?')->fetchOne(array($id));
        } else {
            $model = $this->model;
        }
        $model->fromArray($values);
        $model->save();
        return 1;

/*        $query = $req->getQuery();
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
        
        return $result;*/
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