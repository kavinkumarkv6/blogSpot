<?php
session_start();
include_once 'db_connect.php';

class crud extends DBconfig
{	
	public function __construct()
	{
		parent::__construct();
	}
	public function is_login()
	{
		if( ! isset( $_SESSION['user_details'] ) )
		{
			echo "<script>window.location.href='login';</script>";
		}
	}
    public function encrypt_string( $string )
    {
        $ciphering      =    "AES-128-CTR"; 
        $options        =    0;
        $encryption_iv  =   '1234567891011121';

        $encryption_key =   "blog_spot";

        $encryption     = openssl_encrypt($string, $ciphering, $encryption_key, $options, $encryption_iv);

        return $encryption;
    }
    public function decrypt_string( $string )
    {
        $ciphering      =    "AES-128-CTR"; 
        $options        =    0;

        $decryption_iv  =   '1234567891011121';
        $decryption_key =   "blog_spot"; 

        $decryption     =   openssl_decrypt ($string, $ciphering, $decryption_key, $options, $decryption_iv); 
        return $decryption;
    }
    public function check_if_like_is_exist_or_not( $post_id,$user_id )
    {
        $response       =   array();
        $select_query   =   "   SELECT * FROM bp_like_history 
                                WHERE 
                                    blh_like_post_id    =   :post_id    AND 
                                    blh_like_user_id    =   :user_id  
                            ";
        $prepare_query  =   $this->prepare( $select_query );
        $prepare_query->bindParam( "post_id",$post_id );
        $prepare_query->bindParam( "user_id",$user_id );
        if( $prepare_query->execute() )
        {
            if( $fetch_history = $prepare_query->fetch() )
            {
                $response['appresponse'] = "success";
                $response['message']     = "records found.";
            }
            else 
            {
                $response['appresponse'] = "failed";
                $response['message'] = "no likes found";       
            }
        }
        else 
        {
            $response['appresponse'] = "failed";
            $response['message'] = "unable to process.";
        }
        return $response;
    }
    public function put_like( $post_id,$user_id )
    {
        $response       =   array();
        $this->to_auto_commit();
        $select_like    =   "   SELECT 
                                    bpl_post_likes 
                                FROM 
                                    bp_post_list 
                                WHERE 
                                    bpl_post_id = :post_id
                            ";
        $post_query     =   $this->prepare( $select_like ); 
        $post_query->bindParam( "post_id",$post_id );
        if( $post_query->execute() )
        {
            if( $get_like = $post_query->fetch() )
            {
                $previous_like  =   $get_like['bpl_post_likes'];
                $previous_like++;
                $update_query   =   "   UPDATE 
                                            bp_post_list 
                                        SET 
                                            bpl_post_likes  =  :new_like
                                        WHERE 
                                            bpl_post_id = :post_id
                                    ";    
                $prepare_update =   $this->prepare( $update_query );
                $prepare_update->bindParam( "new_like",$previous_like   );
                $prepare_update->bindParam( "post_id",$post_id          );
                if( $prepare_update->execute() )
                {
                    $history_insert =   "   INSERT INTO bp_like_history 
                                            (
                                                blh_like_post_id,
                                                blh_like_user_id
                                            )
                                            VALUES 
                                            (
                                                :post_id,
                                                :user_id
                                            )
                                        ";
                    $prepare_insert =   $this->prepare( $history_insert );                    
                    $prepare_insert->bindParam( "post_id",$post_id );
                    $prepare_insert->bindParam( "user_id",$user_id );
                    if( $prepare_insert->execute() )
                    {
                        $this->to_commit();
                        $response['appresponse']    =  "success";
                        $response['new_like_count'] =  $previous_like;
                    }
                    else 
                    {
                        $this->to_roll_back();
                        $response['appresponse'] = "failed";
                        $response['errorMessage'] = "Err-004 Unable to process your request.";
                    }
                }
                else 
                {
                    $this->to_roll_back();
                    $response['appresponse'] = "failed";
                    $response['errorMessage'] = "Err-003 Unable to process your request.";
                }
            }
            else 
            {
                $response['appresponse'] = "failed";
                $response['errorMessage'] = "Err-002 Unable to process your request.";
            }
        }   
        else 
        {
            $response['appresponse']  = "failed";
            $response['errorMessage'] = "Err-001 Unable to process your request.";
        }                
        return $response;
    }
    public function put_unlike( $post_id,$user_id )
    {
        $response       =   array();
        $this->to_auto_commit();
        $select_like    =   "   SELECT 
                                    bpl_post_likes 
                                FROM 
                                    bp_post_list 
                                WHERE 
                                    bpl_post_id = :post_id
                            ";
        $post_query     =   $this->prepare( $select_like ); 
        $post_query->bindParam( "post_id",$post_id );
        if( $post_query->execute() )
        {
            if( $get_like = $post_query->fetch() )
            {
                $previous_like  =   $get_like['bpl_post_likes'];
                $previous_like--;
                $update_query   =   "   UPDATE 
                                            bp_post_list 
                                        SET 
                                            bpl_post_likes  =  :new_like
                                        WHERE 
                                            bpl_post_id = :post_id
                                    ";    
                $prepare_update =   $this->prepare( $update_query );
                $prepare_update->bindParam( "new_like",$previous_like   );
                $prepare_update->bindParam( "post_id",$post_id          );
                if( $prepare_update->execute() )
                {
                    $delete_like = "    DELETE FROM bp_like_history 
                                        WHERE 
                                            blh_like_post_id  =     :post_id AND 
                                            blh_like_user_id  =     :user_id 
                                    ";
                    $prepare_del =  $this->prepare( $delete_like );
                    $prepare_del->bindParam( "post_id",$post_id );                
                    $prepare_del->bindParam( "user_id",$user_id );
                    if( $prepare_del->execute() )
                    {
                        $this->to_commit();
                        $response['appresponse']    =  "success";
                        $response['new_like_count'] =  $previous_like;
                    }   
                    else 
                    {
                        $this->to_roll_back();
                        $response['appresponse']    =   "failed";
                        $response['errorMessage']   =   "Err-004 Unable to process your request.";       
                    }             
                }
                else 
                {
                    $this->to_roll_back();
                    $response['appresponse'] = "failed";
                    $response['errorMessage'] = "Err-003 Unable to process your request.";
                }
            }
            else 
            {
                $response['appresponse'] = "failed";
                $response['errorMessage'] = "Err-002 Unable to process your request.";
            }
        }
        else 
        {
            $response['appresponse']  = "failed";
            $response['errorMessage'] = "Err-001 Unable to process your request.";
        }
        return $response;
    }
################ pagination function #########################################
    public function paginate_function($item_per_page, $current_page, $total_records, $total_pages)
    {
        $pagination = '';
        if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages)
        { 	//verify total pages and current page number
            $pagination .= '<ul class="pagination">';
            $right_links    = $current_page + 3; 
            $previous       = $current_page - 1; //previous link 
            $next           = $current_page + 1; //next link
            $first_link     = true; //boolean var to decide our first link
            
            if($current_page > 1)
            {
    			$previous_link = ($previous==0)? 1: $previous;
                $pagination .= '<li class="first"><a href="#" data-page="1" title="First">&laquo;</a></li>'; //first link
                $pagination .= '<li><a href="#" data-page="'.$previous_link.'" title="Previous">&lt;</a></li>'; //previous link
                for($i = ($current_page-2); $i < $current_page; $i++)
                { //Create left-hand side links
                    if($i > 0)
                    {
                        $pagination .= '<li><a href="#" data-page="'.$i.'" title="Page'.$i.'">'.$i.'</a></li>';
                    }
                }   
                $first_link = false; //set first link to false
            }
            
            if( $first_link )
            {   //if current active page is first link
                $pagination .= '<li class="first active">'.$current_page.'</li>';
            }
            elseif( $current_page == $total_pages )
            {   //if it's the last active link
                $pagination .= '<li class="last active">'.$current_page.'</li>';
            }
            else
            {   //regular current link
                $pagination .= '<li class="active">'.$current_page.'</li>';
            }
                    
            for($i = $current_page+1; $i < $right_links ; $i++)
            { //create right-hand side links
                if($i<=$total_pages)
                {
                    $pagination .= '<li><a href="#" data-page="'.$i.'" title="Page '.$i.'">'.$i.'</a></li>';
                }
            }
            if($current_page < $total_pages)
            { 
    				// $next_link = ($i > $total_pages) ? $total_pages : $i;
    				$next_link = $current_page + 1;
                    $pagination .= '<li><a href="#" data-page="'.$next_link.'" title="Next">&gt;</a></li>'; //next link
                    $pagination .= '<li class="last"><a href="#" data-page="'.$total_pages.'" title="Last">&raquo;</a></li>'; //last link
            }
            
            $pagination .= '</ul>'; 
        }
        return $pagination; //return pagination links
    }      
}
?>