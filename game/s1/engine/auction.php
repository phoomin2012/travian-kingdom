<?php
class Auction{
    
    public function get(){
        global $engine;
        
    }
    
    public function runningCount($params){
        global $engine;
        
        $r = query("SELECT * FROM `{$engine->server->prefix}auction`;")->rowCount();
        return $r;
    }
    
    public function runningPage($params){
        
        return [];
    }
    
    public function getPrice($params){
        global $engine;
        
        return [
            "amount" => "1",
            "isNpcBuying" => true,
            "pricePerItem" => 930,
            "quality" => 2,
            "strengthFactor" => 1.5,
            "tier" => 2,
        ];
    }
}