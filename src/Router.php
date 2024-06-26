<?php 

namespace App;
use AltoRouter;

class Router{

  /**
   * @var string
   */
  private $path;

  /**
   * @var AltoRouter
   */
  private $router;

  public function __construct(string $path){
    $this->path = $path;
    $this->router = new AltoRouter();
  }
  
  /**
   * get is function to set a route for a GET request
   *
   * @param  mixed $url
   * @param  mixed $template
   * @param  mixed $title
   * @return void
   */
  public function get(string $url, string $template, $title = null){
    $this->router->map('GET', $url, $template, $title);

    return $this;
  }
  
  /**
   * generateURL for generate a custom url with slug and id
   *
   * @param  mixed $name
   * @param  mixed $params
   * @return void
   */
  public function generateURL(string $name, array $params = []){
    return $this->router->generate($name, $params);
  }

  public function start(){
    $match = $this->router->match();
    $view = $match['target'];
    $params = $match['params'];
    $router = $this;
    ob_start();
    require $this->path . $view;
    $content = ob_get_clean();
    require $this->path . '/layouts/default.php';
    return $this;
    }

}
