<?php

namespace App\Controllers;

interface RestController
{
    public function index();
    public function new();
    public function create();
    public function show($id);
    public function edit($id);
    public function update($id);
    public function delete($id);
}
