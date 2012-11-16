<?php

namespace WNC\FaqBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class WNCFaqBundle extends Bundle
{
    
    public function getParent()
    {
        
        return 'EvercodeFaqBundle';
        
    }
    
}
