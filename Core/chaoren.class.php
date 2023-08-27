<?php
class Chaorendama
{
    function __construct($user, $pass)
    {
        $this->user = $user;
        $this->pass = $pass;
        $this->softid = '54131';
    }
    public function get_info()
    {
        $url = 'http://api2.sz789.net:88/GetUserInfo.ashx';
        $postData = 'username=' . $this->user . '&password=' . $this->pass;
        $data = $this->postdata($url, $postData);
        $array = json_decode($data, true);
        return $array;
    }
    public function recv_byte($imgdata)
    {
        $url = 'http://api2.sz789.net:88/RecvByte.ashx';
        $postData = 'username=' . $this->user . '&password=' . $this->pass . '&softId=' . $this->softid . '&imgdata=' . $imgdata;
        $data = $this->postdata($url, $postData);
        $array = json_decode($data, true);
        return $array;
    }
    public function report_err($imgid)
    {
        $url = 'http://api2.sz789.net:88/ReportError.ashx';
        $postData = '&username=' . $this->user . '&password=' . $this->pass . '&imgid=' . $imgid;
        $data = $this->postdata($url, $postData);
        $array = json_decode($data, true);
        return $array;
    }
    private function postdata($url, $postData)
    {
        $http = curl_init();
        curl_setopt($http, CURLOPT_URL, $url);
        curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($http, CURLOPT_POSTFIELDS, $postData);
        $data = curl_exec($http);
        curl_close($http);
        return $data;
    }
}