<?php
namespace Services;
/**
 * BaseService
 *
 * @author Jun Lin <xuanjunlin@gmail.com>
 * @link http://www.tripresso.com/
 */
class BaseService
{
    public $session;
    public $config;
    public $errors;

    public $model;


    /**
     * setUp
     * @param array &$session
     * @param array $config
     * @param array $modelArray
     */
    public function __construct($sessionArray = array(), $config = array(), $modelArray = array(), $baseModel = '')
    {
        if (is_array($sessionArray)) {
            foreach ($sessionArray as $key => $val) {
                $this->$key = &$sessionArray[$key];
            }
        } else {
            $this->session = &$sessionArray;
        }

        if (isset($config->config)) {
            $this->config = $config->config;
        }
        if (!empty($modelArray)) {
            foreach ($modelArray as $key => $val) {
                $this->$key = &$modelArray[$key];
                // 若有指定model，成為最底層之model應用
                if ((get_parent_class($val) == 'CI_Model' ||
                    get_parent_class($val) == 'MY_Model') && $baseModel == $key) {
                    $this->model = $this->$key;
                }

            }
        }
    }
    /**
     * Get Single Data
     * @param  [array] $params
     * @param  [FormObject] $form
     * @return [mix] false or array
     */
    public function get($params, $form)
    {
        if (empty($params[$form->primaryKey])) {
            $this->errors[0] = '查無資料';
            return false;
        }
        $id = $params[$form->primaryKey];
        /**
         * getbyonwer , 會用order_code 及user_id來找出擁有者
         * @var [type]
         */
        if ($array = $this->model->get($form->table, $form->primaryKey, $id)) {
            /**
             * 經過parse處理
             * @var [type]
             */
            $array = $form->getParseDataArray($array);
            return $array;
        }
        return false;
    }

    /**
     * Get
     * @param  [array] $params
     * @param  [FormObject] $form
     * @return [mix] false or array
     */
    public function getAll($form, $keys = [], $data = [])
    {
        $params= [];
        if (!empty($keys)) {
            foreach ($keys as $key) {
                if(!empty($data[$key])) {
                    $params[$key] = $data[$key];
                }
            }
        }
        if ($raws = $this->model->getAll($form->table, $params)) {
            foreach ($raws as $key => $raw) {
                $item = $form->getParseDataArray($raw);
                $array[$key] = $item;
            }
            return $array;
        }
        return false;
    }

    /**
     * Store
     * @param  [array] $params
     * @param  [FormObject] $form
     * @return [mix]  false or array
     */
    public function store($params, $form)
    {
        $form->load($params);
        $form->form_validation = $this->form_validation;
        if ($form->validate()) {
            // 再處理
            //$data = $form->getProcessDataArray($params /*raw*/);
            $form->processData();

            // 直接取回 array
            $data = $form->getArray();

            if (empty($data)) {
                $this->errors[0] = '未設定寫入資料 ';
                return false;
            }
            if ($detail = $this->model->create($form->table, $form->primaryKey, $data)) {
                return $detail;
            } else {
                $sys_msg = $this->model->error;
                $this->errors[0] = '寫入失敗 '.$sys_msg;
            }
        } else {
            $this->errors = $form->errors;
        }
        return false;
    }

    /**
     * Store
     * @param  [int] $sn
     * @param  [array] $params
     * @param  [FormObject] $form
     * @param  [boolean] $returnAfterUpdateFlag
     * @return [mix]  false or array
     */
    public function update($sn, $params, $form, $returnAfterUpdateFlag = true, $add_condition = [])
    {
        $form->load($params);
        $form->form_validation = $this->form_validation;
        
        if ($form->validate()) {
            // 再處理
            //$data = $form->getProcessDataArray($params /*raw*/);
            $form->processData();
            // 直接取回 array
            $data = $form->getArray();

            if ($detail = $this->model->update($form->table, $form->primaryKey, $sn, $data, $returnAfterUpdateFlag, $add_condition)) {
                return $detail;
            } else {
                $this->errors[0] = '寫入失敗';
            }
        } else {
            $this->errors = $form->errors;
        }
        return false;
    }

    /**
     * destory from Form Info
     * @param  [int] $sn
     * @param  [FormObject] $form
     * @param  [bool] hard_delete 實刪或軟刪
     * @return [bool]
     */
    public function destory($sn, $form, $hard_delete = true)
    {
        // 軟刪除
        if( $hard_delete == false && property_exists($form->data, 'delete_time')) {
            $params['delete_time'] = date('c');
            if ($this->model->update($form->table, $form->primaryKey, $sn, $params, false)) {
                return true;
            }
        } else {
            if ($this->model->delete($form->table, $form->primaryKey, $sn)) {
                return true;
            }
        }
        return false;
    }

}
