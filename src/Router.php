<?php 

namespace App;
use AltoRouter;
use App\Helper\URL;

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
   * get is function to set a route for a only GET request
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
   * post is function to set a route for a only POST request
   *
   * @param  mixed $url
   * @param  mixed $template
   * @param  mixed $title
   * @return void
   */
  public function post(string $url, string $template, $title = null){
    $this->router->map('POST', $url, $template, $title);
    return $this;
  }
  
  /**
   * getPost is function to set a route for a GET and POST request
   *
   * @param  mixed $url
   * @param  mixed $template
   * @param  mixed $title
   * @return void
   */
  public function getPost(string $url, string $template, $title = null){
    $this->router->map('GET|POST', $url, $template, $title);
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
    URL::request_slash($_SERVER['REQUEST_URI']);
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
