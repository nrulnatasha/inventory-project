<?php

use Slim\Http\Request; //namespace
use Slim\Http\Response; //namespace

//include productProc.php file
include __DIR__ . '/../function/productProc.php';

//read table products
$app->get('/products', function (Request $request, Response $response, array $arg){
  return $this->response->withJson(array('data' => 'success'), 200);
});

//request table products by condition(name)
$app->get('/products/[{name}]', function ($request, $response, $args){

  $productName = $args['name'];
  
  $data = getProduct($this->db,$productName);
  if (empty($data)) {
      return $this->response->withJson(array('error' => 'no data'), 404);
  }
  return $this->response->withJson(array('data' => $data), 200);
});

$app->post('/InsertProducts', function(Request $request, Response $response, array $arg){
  $form_data=$request->getParsedBody();
$data = createProduct($this->db, $form_data);
  
  if (is_null($data)) {
      return $this->response->withJson(array('error' => 'no data'), 404);
  }

  return $this->response->withJson(array('data' => 'data insert successfully'), 200);
});

//delete row 
$app->delete('/products/del/[{name}]', function ($request, $response, $args){ 
    $productName = $args['name']; 
    
    $data = deleteProduct($this->db,$productName); 
    if (empty($data)) { 
        return $this->response->withJson(array($productName=> 'is successfully deleted'), 202);
    }; 
});
  
//put table products
$app->put('/products/put/[{name}]', function ($request, $response, $args){
  $productName = $args['name'];
  $date = date("Y-m-j h:i:s");
  
  $form_data=$request->getParsedBody();
  $data=updateProduct($this->db,$form_data,$productName,$date);
  return $this->response->withJson(array('data' => 'successfully updated'), 200);
});