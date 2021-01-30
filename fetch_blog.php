<?php 
    if(     isset($_POST) && 
            isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
       )
    {
    	include( "DBconfig/common_functions.php" );
		$crud = new crud();
	    $item_per_page = $crud->item_per_page;

		if(isset($_POST["numberofpages"]))
	        $item_per_page = (int)$_POST["numberofpages"] ;
        if(isset($_POST["page"]))
        {
		    $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
            if(!is_numeric($page_number))
            {
                die('Invalid page number!');
            }
        }
        else
        {
		    $page_number = 1;
	    }


        $status = "active";
	    $sql           =   "SELECT COUNT(*) FROM bp_post_list WHERE bpl_post_status  = :status ";
        $prepare_c     =    $crud->prepare($sql);
        $prepare_c->bindParam( "status",$status );
        $prepare_c->execute();
        $cat_count     =    $prepare_c->fetchColumn();
        
        $total_pages = ceil($cat_count/$item_per_page);
        
        $page_position = (($page_number-1) * $item_per_page);

        if( isset( $_POST['search_val'] ) )
        {
        	$search_val = $_POST['search_val'];
        	$sql1 = "   SELECT * FROM bp_post_list bp 
                        LEFT JOIN bp_user_register bug  
                        ON 
                            bug.bur_user_register_id = bp.bpl_post_created_by
        				WHERE 
    					( 
    						bp.bpl_post_title LIKE '%".$search_val."%' OR 
    						bp.bpl_post_description LIKE '%".$search_val."%'   
    					) 
        				LIMIT $page_position, $item_per_page";	
        }
        else
        {
        	$sql1 = "  	SELECT * FROM bp_post_list bp 
                        LEFT JOIN bp_user_register bug  
                        ON 
                            bug.bur_user_register_id = bp.bpl_post_created_by
	                    LIMIT $page_position, $item_per_page ";
        }
        $pre_vale   =   $crud->prepare( $sql1 );
        $pre_vale->execute();
        $result     =   $pre_vale->fetchAll();   

        $product_list = '';
        $product_list.= 'Pages '. $page_number . ' of '. $total_pages;
        $product_list.="<table class='table table-bordered' width='100%'>
                            <thead>
	                            <tr>
	                                <th class='text-center'>S.no</th>
	                                <th class='text-center'>Post Title</th>
	                                <th class='text-center'>Post Description</th>
                                    <th class='text-center'>Created By</th>
                                    <th class='text-center'>Post Created On</th>
                                    <th class='text-center'>Post Status</th>
                                    <th class='text-center'>Action</th>
	                            </tr>
                           	</thead>
                            <tbody>";
		$i=$page_position+1;
		foreach ( $result as $key => $row)
		{
            $created_date = date('d-m-Y',strtotime( $row['bpl_post_created_on'] ) );
			$product_list.=   "<tr>
			        <td class='text-center'>".$i."</td>
			        <td class='text-center'>".$row['bpl_post_title']."</td>
			        <td class='text-center'>".$row['bpl_post_description']."</td>
                    <td class='text-center'>".$row['bur_user_name']."</td>
                    <td class='text-center'>".$created_date."</td>
                    <td class='text-center'>".$row['bpl_post_status']."</td>
                    <td class='text-center'>";
                    if( $_SESSION['user_details']['bur_user_type'] == 'admin' )
                    {
                        $product_list .=    "   <i onclick='send_post_method(`post_id`,`".$row['bpl_post_id']."`,`view_post`)'   class='fa fa-eye cursor-pointer'></i>
                                                <i onclick='send_post_method(`post_id`,`".$row['bpl_post_id']."`,`edit_post`)'   class='fa fa-edit cursor-pointer'></i>
                                                <i onclick='send_post_method(`post_id`,`".$row['bpl_post_id']."`,`delete_post`)' class='fa fa-trash cursor-pointer'></i>"; 
                    }
                    else 
                    {
                        if( $_SESSION['user_details']['bur_user_register_id'] == $row['bpl_post_created_by'] )
                        {
                            $product_list .=    "   <i onclick='send_post_method(`post_id`,`".$row['bpl_post_id']."`,`view_post`)'   class='fa fa-eye cursor-pointer'></i>
                                                    <i onclick='send_post_method(`post_id`,`".$row['bpl_post_id']."`,`edit_post`)'   class='fa fa-edit cursor-pointer'></i>
                                                    <i onclick='send_post_method(`post_id`,`".$row['bpl_post_id']."`,`delete_post`)' class='fa fa-trash cursor-pointer'></i>"; 
                        }
                        else 
                        {
                            $product_list .=    "   <i onclick='send_post_method(`post_id`,`".$row['bpl_post_id']."`,`view_post`)'   class='fa fa-eye cursor-pointer'></i>";       
                        }
                    }        
            $product_list.=     "</td>";
			$product_list.=  "</tr>";
			$i++; 
		} 

		$product_list.= "</tbody></table>";
		echo $product_list;
		echo "<div class='row'>
				<div class='col-md-6'>&nbsp;</div>
				<div class='col-md-6'>";
		echo $crud->paginate_function($item_per_page, $page_number, $cat_count, $total_pages);
		echo "</div></div>";
		exit;
    }

?>