<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Admin\CoverageArea;
use Session;




class CsvsImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $j=1;
        $i=0;
             
        foreach ($rows as $row) 
        {

             if($j!=1){


                if(!(is_numeric($row[2]))&&!(is_numeric($row[5]))){

                    Session::put('type_error_msg', "Invalid phone,collection number found!");             
                   
                }
                else if(!(is_numeric($row[2]))){

                    Session::put('type_error_msg', "Invalid phone number found!");             
                   
                }
                else if(!(is_numeric($row[5]))){

                    Session::put('type_error_msg', "Invalid collection number found!");

                }else{

                $array_data[$i]['invoice_no']=$row[0]??'';

                $array_data[$i]['customer_name']=$row[1]??'';       
      
                $array_data[$i]['customer_phone']=$row[2]??'';
      
                $array_data[$i]['customer_address']=$row[3]??'';
                
                $array_data[$i]['product_title']=$row[4]??'';
      
                $array_data[$i]['collection']=$row[5]??'';
      
                 $array_data[$i]['remarks']=$row[6]??'';  
                
                }
         

   
        } 
            ++$j;
            ++$i;
        }
        Session::put('session_data', $array_data);

      

    }
}
