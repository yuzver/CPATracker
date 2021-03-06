<?php


class Adsup {
    
    
    public $net = 'Adsup';
    
    private $common;
    
    private $params = array(
        'profit' => 'payout',
        'subid' => 'aff_sub',
        'date_add' => 'datetime',
        't1' => 'ip',
        't4' => 'offer_name',
        't7' => 'source',
        't12' => 'device_os',
        't13' => 'device_brand',
        't14' => 'affiliate_name',
        't15' => 'file_name',
        't16' => 'aff_sub2',
        't17' => 'aff_sub3',
        't18' => 'aff_sub4',
        't19' => 'aff_sub5',
        't20' => 'currency',
        't21' => 'device_model',
        't22' => 'device_os_version',
        't23' => 'device_id',
        't24' => 'android_id',
        't25' => 'mac_address',
        't26' => 'open_udid',
        't27' => 'ios_ifa',
        't28' => 'ios_ifv',
        't29' => 'unid',
        't30' => 'mobile_ip',
        'i1' => 'goal_id',
        'i2' => 'offer_id',
        'i3' => 'transaction_id',
        'i7' => 'offer_url_id',
        'i10' => 'offer_file_id',
        'i11' => 'device_id',
        'i12' => 'affiliate_id',
        'i13' => 'affiliate_ref',
        'i14' => 'offer_ref',
    );
    
    private $reg_url = 'http://www.cpatracker.ru/networks/adsup';
    
    private $net_text = 'Белая монетизация мобильного и социального трафика для рунета. Есть международные мобильные офферы, отзывчивая поддержка и частые выплаты. Сеть на платформе HasOffers.';
    
    
    function __construct() {
        $this->common = new common($this->params);
    }
    
    
    function get_links() {
        $url = tracklink() . '/p.php?n='.$this->net;
        
        foreach ($this->params as $name => $value) {
            $url .= '&'.$name.'={'.$value.'}';
        }
        
        $code = $this->common->get_code();
        $url .= '&ak='.$code;
        
        $return = array(
            'id' => 0,
            'url' => $url,
            'description' => 'Вставьте эту ссылку в поле PostBack ссылки в настройках оффера Adsup.me.'
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
        unset($data['net']);
        
        
        $this->common->process_conversion($data);
    }
    
    
    
}




