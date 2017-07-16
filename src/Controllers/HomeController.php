<?php

namespace App\Controllers;

use App\Collections\ClienteRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    public function index()
    {
        $clienteRepository = new ClienteRepository($this->app);

        $clientes = $clienteRepository->all();

        return $this->app['twig']->render('welcome.twig', [
            'clientes' => $clientes
        ]);
    }

    public function getCreate()
    {
        return $this->app['twig']->render('create.twig');
    }

    public function postCreate(Request $request)
    {
        $data = $request->request->all();

        $clienteRepository = new ClienteRepository($this->app);

        if($clienteRepository->validate($data)){
            $clienteRepository->save($data);
        }

        return RedirectResponse::create("/");
    }

    public function getUpdate($id)
    {
        $clienteRepository = new ClienteRepository($this->app);

        if($clienteRepository->find($id)){
            return $this->app['twig']->render('update.twig', [
                'cliente' => $clienteRepository->find($id)
            ]);
        }

        return RedirectResponse::create("/");
    }

    public function postUpdate($id, Request $request)
    {
        $data = $request->request->all();
        $clienteRepository = new ClienteRepository($this->app);

        if($clienteRepository->find($id) && $clienteRepository->validate($data)) {
            $clienteRepository->update($id, $data);
            return RedirectResponse::create("/");
        }

        return RedirectResponse::create("/update/" . $id);
    }

    public function delete($id)
    {
        $clienteRepository = new ClienteRepository($this->app);

        if($clienteRepository->find($id)){
            $clienteRepository->delete($id);
        }

        return RedirectResponse::create("/");
    }
}
