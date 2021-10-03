<?php 
   
   # session start ... 
   session_start();


   # Clean ... 
   function CleanInputs($input)
   {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    
    return $input;
    }
    
   
    # Validation ...

    function validate($input,$flag){

        $status = true;

        switch ($flag) {
            case 1:
                # code...
                if(empty($input)){
                    $status = false;  
                }
                break;

            case 2: 
                # code ... 
                if(!filter_var($input,FILTER_VALIDATE_INT)){
                    $status = false;
                }
                break;    


            case 3: 
                    # code ... 
                    if(!filter_var($input,FILTER_VALIDATE_EMAIL)){
                        $status = false;
                    }
                    break;    

            case 4: 
                    # code ... 
                    if(strlen($input) < 6){
                            $status = false;
                       }
                        break;   
            
        }

        return $status;

    }




    # Sanitization 

    function Sanitize($input,$flag){

      
        switch ($flag) {
            case 1:
                # code...
                return  filter_var($input,FILTER_SANITIZE_NUMBER_INT);
                
                break;
          
        }


    }
    # URL ... 
    function url($input){

        return "http://".$_SERVER['HTTP_HOST'].'/Group5/blog/Admins/'.$input;
        
    }






?>