<?php

namespace App\Services;

class Router
{
   private static $list = [];

   public static function page($uri, $page_name)
   {
      self::$list[] = [
         "uri" => $uri,
         "page" => $page_name,
         "post" => false,
      ];
   }

   public static function post($uri, $class, $action)
   {
      self::$list[] = [
         "uri" => $uri,
         "class" => $class,
         "action" => $action,
         "post" => true
      ];
   }

   public static function enable()
   {
      $query = isset($_GET['q']) ? $_GET['q'] : '';

      foreach (self::$list as $route) {
         if ($route["uri"] === '/' . $query) {
            if ($route["post"] === true) {
               $class = new $route["class"];
               $method = $route["action"];
               $class->$method($_POST);
            } else {
               require_once "views/pages/" . $route["page"] . ".php";
            }
            die();
         }
      }

      self::not_found_page();
   }

   private static function not_found_page()
   {
      require_once "views/errors/404.php";
   }
}
