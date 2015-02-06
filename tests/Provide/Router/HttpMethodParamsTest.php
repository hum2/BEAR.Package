<?php

namespace BEAR\Package\Provide\Router;

require __DIR__ . '/file_get_contents.php';

class HttpMethodParamsTest extends \PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $server = ['REQUEST_METHOD' => 'GET'];
        $get = ['id' => '1'];
        $post = [];
        list($method, $params) = (new HttpMethodParams)->get($server, $get, $post);
        $this->assertSame('get', $method);
        $this->assertSame(['id' => '1'], $params);
    }

    public function testPost()
    {
        $server = ['REQUEST_METHOD' => 'POST'];
        $get = [];
        $post = ['id' => '1'];
        list($method, $params) = (new HttpMethodParams)->get($server, $get, $post);
        $this->assertSame('post', $method);
        $this->assertSame(['id' => '1'], $params);
    }

    public function testPut()
    {
        $server = ['REQUEST_METHOD' => 'PUT', HttpMethodParams::CONTENT_TYPE => HttpMethodParams::FORM_URL_ENCODE];
        $get = ['name' => 'bear'];
        $post = ['name' => 'sunday'];
        list($method, $params) = (new HttpMethodParams)->get($server, $get, $post);
        $this->assertSame('put', $method);
        $this->assertSame(['name' => 'kuma'], $params);
    }

    public function testPatch()
    {
        $server = ['REQUEST_METHOD' => 'PATCH', HttpMethodParams::CONTENT_TYPE => HttpMethodParams::FORM_URL_ENCODE];
        $get = ['name' => 'bear'];
        $post = ['name' => 'sunday'];
        list($method, $params) = (new HttpMethodParams)->get($server, $get, $post);
        $this->assertSame('patch', $method);
        $this->assertSame(['name' => 'kuma'], $params);
    }

    public function testDelete()
    {
        $server = ['REQUEST_METHOD' => 'DELETE', HttpMethodParams::CONTENT_TYPE => HttpMethodParams::FORM_URL_ENCODE];
        $get = ['name' => 'bear'];
        $post = ['name' => 'sunday'];
        list($method, $params) = (new HttpMethodParams)->get($server, $get, $post);
        $this->assertSame('delete', $method);
        $this->assertSame(['name' => 'kuma'], $params);
    }

    public function testOverridePut()
    {
        $server = ['REQUEST_METHOD' => 'POST', HttpMethodParams::CONTENT_TYPE => HttpMethodParams::FORM_URL_ENCODE];
        $post = ['_method' => 'PUT'];
        list($method, ) = (new HttpMethodParams)->get($server, [], $post);
        $this->assertSame('put', $method);
    }

    public function testOverridePatch()
    {
        $server = ['REQUEST_METHOD' => 'POST', HttpMethodParams::CONTENT_TYPE => HttpMethodParams::FORM_URL_ENCODE];
        $post = ['_method' => 'PATCH'];
        list($method, ) = (new HttpMethodParams)->get($server, [], $post);
        $this->assertSame('patch', $method);
    }

    public function testOverrideDelete()
    {
        $server = ['REQUEST_METHOD' => 'POST', HttpMethodParams::CONTENT_TYPE => HttpMethodParams::FORM_URL_ENCODE];
        $post = ['_method' => 'DELETE'];
        list($method, ) = (new HttpMethodParams)->get($server, [], $post);
        $this->assertSame('delete', $method);
    }

    public function testOverrideHeaderPut()
    {
        $server = ['REQUEST_METHOD' => 'POST', 'HTTP_X_HTTP_METHOD_OVERRIDE' => 'PUT'];
        $post = ['name' => 'sunday'];
        list($method) = (new HttpMethodParams)->get($server, [], $post);
        $this->assertSame('put', $method);
    }

    public function testOverrideHeaderPatch()
    {
        $server = ['REQUEST_METHOD' => 'POST', 'HTTP_X_HTTP_METHOD_OVERRIDE' => 'PATCH'];
        $post = ['name' => 'sunday'];
        list($method) = (new HttpMethodParams)->get($server, [], $post);
        $this->assertSame('patch', $method);
    }

    public function testOverrideHeaderDelete()
    {
        $server = ['REQUEST_METHOD' => 'POST', 'HTTP_X_HTTP_METHOD_OVERRIDE' => 'DELETE'];
        $post = ['name' => 'sunday'];
        list($method) = (new HttpMethodParams)->get($server, [], $post);
        $this->assertSame('delete', $method);
    }
}