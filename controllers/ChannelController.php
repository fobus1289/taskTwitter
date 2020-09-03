<?php

namespace app\controllers;

class ChannelController extends BaseRestController
{
    
    protected $authoBindingParams = true;
    
    protected function postConstruct() 
    {
        $this->middleware(['cross','me'],'*');
    }
    
    public function actionSubscrib()
    {        
        $channel = user()->subscriber(post('id'));

        return $this->asJson([
            'success' => true,
            'channel' => $channel
        ]);
        
    }
    
    public function actionUnsubscrib()
    {        
        $channel = user()->unSubscriber(post('id'));
        
        return $this->asJson([
            'success' => (bool)$channel,
        ]);
    }

}
