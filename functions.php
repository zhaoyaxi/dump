<?php
/**
 * Created by PhpStorm.
 * User: zhaoyaxi <zhaoyaxiphp@163.com>
 * Date: 2020/5/20 0020
 * Time: 15:51
 */

/**
 * 调试函数
 * @params $data
 * @return
 */
if(!function_exists("pp")){
    function pp(){
        $route = debug_backtrace();
        $info = array_shift($route);
        if(current($route)['function'] == "call_user_func_array"){
            array_shift($route);
            $info = array_shift($route);
        }
        $args = func_get_args();
        $num = func_num_args();
        echo "<pre>";
        //secho $info['file'].',line'.$info['line']."<br>";
        printf("%s,line %s".PHP_EOL,$info['file'],$info['line']);
        $rst = array_walk($args,function($n,$k){print_r($n);echo PHP_EOL;});
        echo "</pre>";
    }
}

/**
 * 调试函数,强制结束
 * @params $data
 * @params $data
 * @return
 */
if(!function_exists("dp")){
    function dp(){
        call_user_func_array("pp",func_get_args());
        die();
    }
}

/**
 * 获取路径
 * @params $data
 * @return
 */
if(!function_exists("trace")){
    function trace(...$args){
        $trace = (new \Exception())->getTraceAsString();
        $args[] = $trace;
        $sArg = implode(PHP_EOL,$args);
        call_user_func_array("pp",[$sArg]);
    }
}

/**
 * 获取路径并停止
 * @params $data
 * @return
 */
if(!function_exists("dtrace")){
    function dtrace(...$args){
        $trace = (new \Exception())->getTraceAsString();
        $args[] = $trace;
        $sArg = implode(PHP_EOL,$args);
        call_user_func_array("pp",[$sArg]);
        die();
    }
}

if(!function_exists("T")){
    function T($firstToLast = 0,$isDie = false){
        static $_zz_debug_time_count = 0;
        if(!empty($GLOBALS['zz_debug_time_point_0'])){
            $GLOBALS['zz_debug_time_point_'.$_zz_debug_time_count] = microtime(true);
        }else{
            $GLOBALS['zz_debug_time_point_0'] = microtime(true);
        }
        if($_zz_debug_time_count !== 0){
            if($firstToLast){
                $time = $GLOBALS['zz_debug_time_point_'.$_zz_debug_time_count]
                    - $GLOBALS['zz_debug_time_point_0'];
            }else{
                $prevCount = $_zz_debug_time_count-1;
                $time = $GLOBALS['zz_debug_time_point_'.$_zz_debug_time_count]
                    - $GLOBALS['zz_debug_time_point_'.$prevCount];
            }
        }else{
            $time = "start";
        }
        $_zz_debug_time_count++;

        $route = debug_backtrace();
        $info = array_shift($route);
        echo "<pre>";
        printf("%s,line %s".PHP_EOL,$info['file'],$info['line']);
        echo $time;
        echo "</pre>";
        $isDie && die();
    }
}

