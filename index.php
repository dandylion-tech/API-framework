<?php
    function route($path, $file_location,$conditions=[]){
        extract($GLOBALS);
        $_POST = array_merge($_POST??[],json_decode(file_get_contents('php://input'),true)??[]);
        if(is_string($method_list))$method_list = [$method_list];
        $url_check = preg_replace("/\/{[a-zA-Z0-9\-_]+}/","/([a-zA-Z0-9\-_]+)",$path);
        $path_info = pathinfo($_SERVER['REQUEST_URI']);
        $request_path = ($path_info["dirname"]=="/"?"/":$path_info["dirname"]."/").explode("?",$path_info["basename"])[0];
        if(preg_match_all("/^".str_replace("/","\/",$url_check)."$/",$request_path,$value_list,PREG_SET_ORDER)&&count($value_list)>0){
            $value_list = $value_list[0];
            array_shift($value_list);
            preg_match_all("/\/{([a-zA-Z0-9\-_]+)}/",$path,$key_list);
            $url_variables = array_combine($key_list[1],$value_list);
            foreach($conditions as $key=>$value){
                if(!isset($url_variables[$key])||!preg_match("/^".$value."$/",$url_variables[$key])){
                    http_response_code(400);
                    exit;
                }
            }
            $_GET = $url_variables;
            include "api/".$file_location;
            $method_list = array_map("strtoupper",get_class_methods(API::class));
            $method_list[] = "OPTIONS";
            header("Allow: ".implode(", ",$method_list));
            switch($_SERVER["REQUEST_METHOD"]){
                case "OPTIONS":
                    http_response_code(204);
                    exit;
                default:
                    $method = $_SERVER["REQUEST_METHOD"];
                    if(method_exists(API::class,$method)){
                        echo json_encode(API::$method());
                    } else {
                        http_response_code(405);
                    }
                    exit;
            }
        }
    }