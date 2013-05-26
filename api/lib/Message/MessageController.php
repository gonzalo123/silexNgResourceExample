<?php
namespace Message;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MessageController
{
    public function getAllAction(Application $app)
    {
        return new JsonResponse($app['db']->fetchAll("SELECT * FROM messages"));
    }

    public function getOneAction($id, Application $app)
    {
        return new JsonResponse($app['db']
            ->fetchAssoc("SELECT * FROM messages WHERE id=:ID", ['ID' => $id]));
    }

    public function deleteOneAction($id, Application $app)
    {
        return $app['db']->delete('messages', ['ID' => $id]);
    }

    public function addOneAction(Application $app, Request $request)
    {
        $payload = json_decode($request->getContent());;

        $newResource = [
            'id'      => (integer)$app['db']
                ->fetchColumn("SELECT max(id) FROM messages") + 1,
            'author'  => $payload->author,
            'message' => $payload->message,
        ];
        $app['db']->insert('messages', $newResource);

        return new JsonResponse($newResource);
    }

    public function editOneAction($id, Application $app, Request $request)
    {
        $payload = json_decode($request->getContent());;
        $resource = [
            'author'  => $payload->author,
            'message' => $payload->message,
        ];
        $app['db']->update('messages', $resource, ['id' => $id]);

        return new JsonResponse($resource);
    }
}
