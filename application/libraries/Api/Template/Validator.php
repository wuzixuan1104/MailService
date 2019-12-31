<?php
namespace Api\Template;

/*  範例規格參照：

    $struct = [
      'name'  => 'String|max:100',
      'age'   => 'Integer|min:12|max:50',
      'sex'   => 'Enum|item:M,F',
      'hobbies:optional' => [
        'details:optional' => [
          [
            'title:optional'   => 'String|max:100',
            'freq:optional'    => 'Integer|min:1|max:100',
            'other:optional'   => [
              'name' => 'String|max:50'
            ]
          ]
        ],
        'total' => 'Integer',
      ],
      'contact:optional' => [
        'phone'      => 'String|min:1',
        'tel:optional'  => 'String|max:100',
      ],
      'childs:optional' => 'Array',
    ];

    $input = [
      'name'  => 'Shari',
      'age'   => 24,
      'sex'   => 'F',
      'hobbies' => [
        'details' => [
          [
            'title' => 'Swimming',
            'freq'  => 2,
            'other' => [
              'name' => '最擅長',
            ]
          ],
          [
            'title' => 'Hiking',
            'freq'  => 1,
          ],
        ],
        'total' => 2
      ],
      'contact' => [
        'phone' => '0919920129',
        'tel'   => '26232229'
      ],
      'childs' => [1,3,5],
    ];
 *
 */
class Validator {
    const DELETE = 'tripresso-validator-delete';
    static $errorMsg = null;

    public static function structFormat($struct) {
        if (!$fields = explode('|', $struct)) {
            self::$errorMsg = '[規格錯誤] ' . $struct;
            return false;
        }
        $type = array_shift($fields);

        array_map(function($v) use (&$condition){
            $item = explode(':', $v);
            $condition[trim(strtolower($item[0]))] = $item[1];
        }, $fields);
        
        return compact('type', 'condition');
    }

    public static function keyType($k, $input) {
        $pos = strpos($k, 'optional');
        if (!$pos) { //is must
            if (!array_key_exists($k, $input)) {
                self::$errorMsg = '[樣板參數傳入錯誤] 缺少必填值 KEY: ' . $k;
                return '+1';
            }
            return $k;
        }
        $k = preg_replace('/\s*:\s*optional/', '', $k);
        if (!array_key_exists($k, $input))
            return '-1';
        return $k;
    }

    public static function structCondition($condition, $input, $k) {
        if (!isset($condition['type'])) {
            self::$errorMsg = '[規格類型錯誤] 沒有此型態 KEY: ' . $k;
            return false; 
        }
        switch ($condition['type']) {
            case 'String':
                is_numeric($input[$k]) && $input[$k] = (string)$input[$k];

                if (!is_string($input[$k])) {
                    self::$errorMsg = '[String 型態錯誤] KEY: ' . $k . '; 值: ' . json_encode($input[$k]);
                    return false; 
                }

                $input[$k] = trim($input[$k]);

                if (isset($condition['condition'])) {
                    foreach ($condition['condition'] as $ckey => $cval) {
                        if ($ckey == 'min' && mb_strlen($input[$k]) < $cval) 
                            self::$errorMsg = '[String 最小規則] min: ' . $cval . '; KEY: ' . $k . '; 值: ' . $input[$k];
                        elseif ($ckey == 'max' && mb_strlen($input[$k]) > $cval) 
                            self::$errorMsg = '[String 最大規則] max: ' . $cval . '; KEY: ' . $k . '; 值: ' . $input[$k];
                    }
                }
                break;
            case 'Integer':
                if (!(is_numeric($input[$k]) && is_integer($input[$k]))) {
                    self::$errorMsg = '[Integer 型態錯誤] KEY: ' . $k . '; 值: ' . $input[$k];
                    return false; 
                }
                if (isset($condition['condition'])) {
                    foreach ($condition['condition'] as $ckey => $cval) {
                        if ($ckey == 'min' && $input[$k] < $cval) 
                            self::$errorMsg = '[Integer 最小規則] min: ' . $cval . '; KEY: ' . $k . '; 值: ' . $input[$k];
                        elseif ($ckey == 'max' && $input[$k] > $cval) 
                            self::$errorMsg = '[Integer 最大規則] max: ' . $cval . '; KEY: ' . $k . '; 值: ' . $input[$k];
                    }
                }
                break;
            case 'Array':
                if (!(is_array($input[$k]))) {
                    self::$errorMsg = '[Array 型態錯誤] KEY: ' . $k . '; 值: ' . $input[$k];
                    return false; 
                }
                if (isset($condition['condition'])) {
                    foreach ($condition['condition'] as $ckey => $cval) {
                        if ($ckey == 'min' && count($input[$k]) < $cval) 
                            self::$errorMsg = '[Array 最小規則] min: ' . $cval . '; KEY: ' . $k . '; 值: ' . $input[$k];
                        elseif ($ckey == 'max' && count($input[$k]) > $cval) 
                            self::$errorMsg = '[Array 最大規則] max: ' . $cval . '; KEY: ' . $k . '; 值: ' . $input[$k];
                    }
                }
                
                break;
            case 'Enum':
                if (!isset($condition['condition'])) {
                    self::$errorMsg = '[Enum 需要定義類型] KEY: ' . $k;
                } else {
                    foreach ($condition['condition'] as $ckey => $cval) {
                        if (!$items = array_map('trim', explode(',', $cval))) {
                            self::$errorMsg = '[Enum 類型格式錯誤] 正確格式應為：%s,%s KEY: ' . $k;
                            return false;
                        } 

                        if ($ckey == 'item' && !in_array($input[$k], $items)) 
                            self::$errorMsg = '[Enum 傳入值錯誤] 應為：' . $cval . '; KEY: ' . $k . '; 值: ' . $input[$k];
                    }
                }
                break;

            case 'Bool':
                if (is_bool($input[$k]) === false)
                    self::$errorMsg = '[Bool 型態錯誤] KEY: ' . $k . '; 值: ' . $input[$k];
                break;

            case 'Double':
                if (is_double($input[$k]) === false)
                    self::$errorMsg = '[Double 型態錯誤] KEY: ' . $k . '; 值: ' . $input[$k];
                break;

            case 'IntegerOrDouble':
                if (is_double($input[$k]) === false && is_integer($input[$k]) === false)
                    self::$errorMsg = '[IntegerOrDouble 型態錯誤] KEY: ' . $k . '; 值: ' . $input[$k];
                break;

            case 'FirstLastName':
                $names = array_map('trim', explode('/', $input[$k]));
                if (count($names) < 2) {
                    self::$errorMsg = '[FirstAndLastName 型態錯誤] 正確格式：ex: TzuHsuan/Wu; KEY: ' . $k . '; 值: ' . $input[$k];
                } else {
                    $input[$k] = implode('/', $names);
                }
                break;

            case 'Date':
                if (!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $input[$k]))
                    self::$errorMsg = '[Date 型態錯誤] KEY: ' . $k . '; 值: ' . $input[$k];
                break;

            case 'Datetime':
                if (!preg_match('/^\d{4}-[01]\d-[0-3]\d [0-2]\d:[0-5]\d:[0-5]\d$/', $input[$k]))
                    self::$errorMsg = '[Datetime 型態錯誤] KEY: ' . $k . '; 值: ' . $input[$k];
                break;

            case 'Time':
                if (!preg_match('/^[0-2]\d:[0-5]\d:[0-5]\d$/', $input[$k]))
                    self::$errorMsg = '[Time 型態錯誤] KEY: ' . $k . '; 值: ' . $input[$k];
                break;

            case 'DatetimeCFormat':
                if (!preg_match('/^\d{4}-[01]\d-[0-3]\dT[0-2]\d:[0-5]\d:[0-5]\d/', $input[$k]))
                    self::$errorMsg = '[DatetimeCFormat 型態錯誤] KEY: ' . $k . '; 值: ' . $input[$k];
                break;

            default:
                self::$errorMsg = '[規格錯誤] 尚未有該型態：' . $match[1][0];
                return false;
        }
        if (self::$errorMsg === null)
            return $input[$k];
        return false;
    }

    public static function errorLog() {
        return ['ValidatorError' => self::$errorMsg];
    } 
  
    public static function checkFormat($fields, $input) {
        $result = [];
        foreach ($fields as $k => $field) {
            $k = self::keyType($k, $input);
            if ($k == '-1')
                continue;

            if ($k == '+1')
                return self::errorLog();

            if (is_array($field)) {
                $arrKeys = count(array_filter(array_keys($input[$k]), function($k) { 
                    return is_numeric($k);
                }));

                //多層 array
                if ($arrKeys == count($input[$k])) {
                    foreach ($input[$k] as $subKey => $v) {
                        if (!isset($field[0]))
                            continue;

                        if (!($callback = self::checkFormat($field[0], $v)))
                            return false;

                        if (isset($callback['ValidatorError'])) {
                            return $callback;
                        }

                        $result[$k][$subKey] = $callback;
                    }
                    continue;
                }

                //單層 array 
                if (!($callback = self::checkFormat($field, $input[$k])))
                    return false;

                if (isset($callback['ValidatorError'])) {
                    return $callback;
                }

                $result[$k] = $callback;
                continue;
            }

            $conditions = self::structFormat($field);
            //判定型別
            if (false === ($callback = self::structCondition($conditions, $input, $k)))
                return self::errorLog();
            
            $result[$k] = $callback;
        }
    
        return $result;
    }

    public static function optionFormat($params) {
        $result = [];
        foreach ($params as $key => $param) {
            if (is_array($param)) {
                $result[$key] = self::optionFormat($param);
                continue;
            }
          
            if ($param === self::DELETE)
                continue;

            $result[$key] = $param;
        }
       
        return array_filter($result, function($v) {
            return $v || $v == 0;
        });
    }
}
