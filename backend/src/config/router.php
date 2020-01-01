<?php 

header("Content-type: application/json");

use Slim\Psr7\Response as ResponseModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

$customErrorHandler = function () use ($app) {
    $response = $app->getResponseFactory()->createResponse();
    $response->getBody()->write('404 - not found');
    return $response->withStatus(404);
};

$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setErrorHandler(Slim\Exception\HttpNotFoundException::class, $customErrorHandler);

$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
            ->withHeader('Access-Control-Allow-Origin', 'http://localhost:8080')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

$app->addBodyParsingMiddleware();

$authorizationMiddleware = function (Request $request, RequestHandler $handler) {
    $response = $handler->handle($request);
    $authorization = $request->getHeader('Authorization')[0];
    if(!Auth::validateToken($authorization)) {
        $response = new ResponseModel();
        $response->getBody()->write(
            json_encode(
                array(
                    'message' => 'Acesse negado!',
                    'status' => 401
                )
            )
        );
        return $response->withStatus(401);
    }
    return $response;
};

$adminMiddleware = function (Request $request, RequestHandler $handler) {
    $response = $handler->handle($request);
    $authorization = $request->getHeader('Authorization')[0];
    if(Auth::validateToken($authorization) and !Auth::isAdmin($authorization)) {
        $response = new ResponseModel();
        $response->getBody()->write(
            json_encode(
                array(
                    'message' => 'É preciso ser administrador para executar esta ação!',
                    'status' => 401
                )
            )
        );
        return $response->withStatus(401);
    }
    return $response;
};

$app->get('/users', function (Request $request, Response $response, $args) {
    try {
        $data = UserController::getAll();
        $data = array_map(function($el) {
            unset($el['password']);
            return $el;
        }, $data);
        $message = 'Recuperação de registros efetuada com sucesso!';
        $status = 200;
    }
    catch(Exception $e) {
        $data = [];
        $message = $e->getMessage();
        $status = 400;
    }
    $response->getBody()->write(json_encode(array('data' => $data, 'message' => $message, 'status' => $status)));
    return $response->withStatus($status);
});

$app->get('/users/{id}', function (Request $request, Response $response, $args) {
    try {
        $data = UserController::get($args['id']);
        unset($data['password']);
        $message = 'Recuperação de registro efetuada com sucesso!';
        $status = 200;
    }
    catch(Exception $e) {
        $data = [];
        $message = $e->getMessage();
        $status = 400;
    }
    $response->getBody()->write(json_encode(array('data' => $data, 'message' => $message, 'status' => $status)));
    return $response->withStatus($status);
});

$app->delete('/users/{id}', function (Request $request, Response $response, $args) {
    try {
        UserController::delete($args['id']);
        $message = 'Registro deletado com sucesso!';
        $status = 200;
    }
    catch(Exception $ex) {
        $message = $ex->getMessage();
        $status = 400;
    }
    $response->getBody()->write(json_encode(array('message' => $message, 'status' => $status)));
    return $response->withStatus($status);
});

$app->put('/users/{id}', function (Request $request, Response $response, $args) {
    try {
        UserController::update($args['id'], json_decode($request->getBody(), true));
        $data = UserController::get($args['id']);
        unset($data['password']);
        $message = 'Registro alterado com sucesso!';
        $status = 200;
    }
    catch(Exception $ex) {
        $data = [];
        $message = $ex->getMessage();
        $status = 400;
    }
    $response->getBody()->write(json_encode(array('data' => $data, 'message' => $message, 'status' => $status)));
    return $response->withStatus($status);
});

$app->post('/users', function (Request $request, Response $response, $args) {
    try {
        $data = $request->getBody();
        UserController::signup(json_decode($request->getBody(), true));
        $message = 'Usuário registrado com sucesso!';
        $status = 200;
    }
    catch(Exception $ex) {
        $data = [];
        $message = $ex->getMessage();
        $status = 500;
    }
    $response->getBody()->write(json_encode(array('data' => $data, 'message' => $message, 'status' => $status)));
    return $response->withStatus($status, $message);
});

$app->post('/chat', function (Request $request, Response $response, $args) {
    try {
        $body = json_decode($request->getBody(), true);
        $data = MessageController::getChat($body['user1'], $body['user2']);
        $message = 'Recuperação de registros efetuada com sucesso!';
        $status = 200;
    }
    catch(Exception $e) {
        $data = [];
        $message = $e->getMessage();
        $status = 400;
    }
    $response->getBody()->write(json_encode(array('data' => $data, 'message' => $message, 'status' => $status)));
    return $response->withStatus($status);
});

$app->get('/messages', function (Request $request, Response $response, $args) {
    try {
        $data = MessageController::getAll();
        $message = 'Recuperação de registros efetuada com sucesso!';
        $status = 200;
    }
    catch(Exception $e) {
        $data = [];
        $message = $e->getMessage();
        $status = 400;
    }
    $response->getBody()->write(json_encode(array('data' => $data, 'message' => $message, 'status' => $status)));
    return $response->withStatus($status);
});

$app->get('/messages/{id}', function (Request $request, Response $response, $args) {
    try {
        $data = MessageController::get($args['id']);
        $message = 'Recuperação de registro efetuada com sucesso!';
        $status = 200;
    }
    catch(Exception $e) {
        $data = [];
        $message = $e->getMessage();
        $status = 400;
    }
    $response->getBody()->write(json_encode(array('data' => $data, 'message' => $message, 'status' => $status)));
    return $response->withStatus($status);
});

$app->delete('/messages/{id}', function (Request $request, Response $response, $args) {
    try {
        MessageController::delete($args['id']);
        $message = 'Registro deletado com sucesso!';
        $status = 200;
    }
    catch(Exception $ex) {
        $message = $ex->getMessage();
        $status = 400;
    }
    $response->getBody()->write(json_encode(array('message' => $message, 'status' => $status)));
    return $response->withStatus($status);
});

$app->put('/messages/{id}', function (Request $request, Response $response, $args) {
    try {
        MessageController::update($args['id'], json_decode($request->getBody(), true));
        $data = UserController::get($args['id']);
        $message = 'Registro alterado com sucesso!';
        $status = 200;
    }
    catch(Exception $ex) {
        $data = [];
        $message = $ex->getMessage();
        $status = 400;
    }
    $response->getBody()->write(json_encode(array('data' => $data, 'message' => $message, 'status' => $status)));
    return $response->withStatus($status);
});

$app->post('/messages', function (Request $request, Response $response, $args) {
    try {
        $data = $request->getBody();
        MessageController::insert(json_decode($request->getBody(), true));
        $message = 'Usuário registrado com sucesso!';
        $status = 200;
    }
    catch(Exception $ex) {
        $data = [];
        $message = $ex->getMessage();
        $status = 500;
    }
    $response->getBody()->write(json_encode(array('data' => $data, 'message' => $message, 'status' => $status)));
    return $response->withStatus($status, $message);
});

$app->post('/signin', function (Request $request, Response $response, $args) {
    $reqBody = json_decode($request->getBody(), true);
    try {
        $token = UserController::signin($reqBody['email'], $reqBody['password']);
        $user = UserController::getByEmail($reqBody['email']);
        $data = array(
            'user' => $user,
            'token' => $token
        );
        $message = "Login efetuado com sucesso!";
        $status = 200;
    }
    catch(Exception $e) {
        $data = [];
        $message = $e->getMessage();
        $status = 400;
    }
    $response->getBody()->write(json_encode(array('data' => $data, 'message' => $message, 'status' => $status)));
    return $response->withStatus($status);
});

$app->post('/validate', function (Request $request, Response $response, $args) {
    $reqBody = json_decode($request->getBody(), true);
    if(Auth::validateToken($reqBody['token'])){
        $message = "Token válido!";
        $status = 200;
    }
    else {
        $message = "Token inválido!";
        $status = 400;
    }
    $response->getBody()->write(json_encode(array('message' => $message, 'status' => $status)));
    return $response->withStatus($status);
});

$app->run();
