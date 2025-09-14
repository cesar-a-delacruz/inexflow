<?php

namespace App\Controllers;

abstract class RestController extends BaseController
{

    public function index()
    {
        echo "index";
    }
    public function new()
    {
        echo "new";
    }
    public function create()
    {
        echo "create";
    }
    public function show($id)
    {
        echo "show";
    }
    public function edit($id)
    {
        echo "edit";
    }
    public function update($id)
    {
        echo "update";
    }
    public function delete($id)
    {
        echo "delete";
    }
}
