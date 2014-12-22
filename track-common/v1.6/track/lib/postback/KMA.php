<?php
class KMA {
    public $net = 'KMA';
    
    private $common;
    
    private $params = array(
        'profit' => 'sum',
        'subid' => 'data1',
        't4' => 'campaignid',
        'i3' => 'orderid',
        't6' => 'chan',
        't5' => 'data2',
    );
    
    
    //private $reg_url = 'http://www.cpatracker.ru/networks/kma';
    private $reg_url = 'http://kma.biz/affiliates/';
    
    private $net_text = 'Конвертируем ваш трафик в деньги!';
    
    function __construct() {
        $this->common = new common($this->params);
    }
    
    
    function get_links() {
        $protocol = isset($_SERVER["HTTPS"]) ? (($_SERVER["HTTPS"]==="on" || $_SERVER["HTTPS"]===1 || $_SERVER["SERVER_PORT"]===$pv_sslport) ? "https://" : "http://") :  (($_SERVER["SERVER_PORT"]===$pv_sslport) ? "https://" : "http://");
        $cur_url = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
        $url = substr($cur_url, 0, strlen($cur_url)-21);
        $url .= '/track/p.php?n='.$this->net;
        foreach ($this->params as $name => $value) {
            $url .= '&'.$name.'={'.$value.'}';
        }
        
        $code = $this->common->get_code();
        $url .= '&ak='.$code;
        
        $return = array(
            'id' => 0,
            'url' => $url,
            'description' => 'Вставьте эту ссылку в поле PostBack ссылки в настройках оффера KMA.'
        );
        
        return array(
            0 => $return,
            'reg_url' => $this->reg_url,
            'net_text' => $this->net_text
        );
    }
    
    function process_conversion($data_all) {
        $this->common->log($this->net, $data_all['post'], $data_all['get']);
        $data = $data_all['get'];
        $data['network'] = $this->net;
        $data['status'] = 1;
        $data['txt_param2'] = 'rub';
        unset($data['net']);   
        $this->common->process_conversion($data);
    }   
}