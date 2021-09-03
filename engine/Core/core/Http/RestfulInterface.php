<?php 

namespace Base\Http;

Interface RestfulInterface 
{
    public function index();
    public function store($requestData=null);
    public function show($resourceID);
    public function update($resourceID, $requestData=null);
    public function delete($resourceID=null);

}
