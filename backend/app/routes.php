<?php

use App\Models\User;
use App\Validation\UserValidator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Capsule\Manager as DB;

return function (App $app) {
    $app->get('/api/users', function (Request $request, Response $response) {
        try {
            $users = User::all();
            $response->getBody()->write(json_encode($users));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    });
    $app->put('/api/users/{id}', function (Request $request, Response $response, $args) {
        try {
            $data = $request->getParsedBody();
            error_log(print_r($data, true));  
            $errors = UserValidator::validate($data);
    
            if (!empty($errors)) {
                error_log(print_r($errors, true));  
                $response->getBody()->write(json_encode(['errors' => $errors]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
            }
    
            $user = User::find($args['id']);
            if (!$user) {
                $response->getBody()->write(json_encode(['error' => 'User not found']));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
            }
    
            $user->update($data);
            $response->getBody()->write(json_encode($user));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            error_log($e->getMessage()); 
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    });

    $app->post('/api/users', function (Request $request, Response $response) {
        try {
            $data = $request->getParsedBody();
            $errors = UserValidator::validate($data);

            if (!empty($errors)) {
                $response->getBody()->write(json_encode(['errors' => $errors]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
            }

            $user = User::create($data);
            $response->getBody()->write(json_encode($user));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    });



    $app->delete('/api/users/{id}', function (Request $request, Response $response, $args) {
        try {
            $user = User::find($args['id']);
            if (!$user) {
                $response->getBody()->write(json_encode(['error' => 'User not found']));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
            }
            $user->delete();
            return $response->withStatus(204);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    });
};
