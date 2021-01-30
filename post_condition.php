<?php 
include( "DBconfig/common_functions.php" );
$crud = new crud();

if( isset( $_POST['login'] ) )
{
	$email_id = $_POST['email'];
	$password = $_POST['password'];
	$enc_pass  = 	$crud->encrypt_string( $password );

	$select_query = "	SELECT * FROM bp_user_register 
						WHERE 
							bur_user_email 		=	:user_email AND 
							bur_user_password	= 	:user_pass 
					";
	$prepare 	=	$crud->prepare( $select_query );
	$prepare->bindParam( "user_email",$email_id );
	$prepare->bindParam( "user_pass",$enc_pass 	);
	if($prepare->execute() )
	{
		if( $get_user  = $prepare->fetch() )
		{
			$_SESSION['user_details'] = $get_user;
			echo "<script> window.location.href='index'; </script>"; 			
		}	
		else 
		{
			echo "	<script>
					alert( 'Invalid email or password' );
					window.location.href='login';
				</script>";			
		}
	}
	else 
	{
		echo "	<script>
					alert( 'Err-LG001 Unable to process your request.' );
					window.location.href='login';
				</script>";	
	}
}

if( isset( $_POST['register'] ) )
{
	$user_name = 	$_POST['user_name'];
	$email_id  = 	$_POST['email_id'];
	$mobile_no = 	$_POST['mobile_no'];
	$password  = 	$_POST['new_password'];
	$enc_pass  = 	$crud->encrypt_string( $password );

	$register_query = 	"	INSERT INTO bp_user_register 
							(
								bur_user_name,
								bur_user_email,
								bur_user_mobile_number,
								bur_user_password
							)
							VALUES 
							(
								:user_name,
								:user_email,
								:user_mobile,
								:user_password
							)
						"; 
	$prepare_register 	=	$crud->prepare( $register_query );
	$prepare_register->bindParam( "user_name",$user_name 	);
	$prepare_register->bindParam( "user_email",$email_id 	);
	$prepare_register->bindParam( "user_mobile",$mobile_no 	);
	$prepare_register->bindParam( "user_password",$enc_pass );
	if( $prepare_register->execute() )
	{
		echo "	<script>
					alert( 'Successfully register.' ); 
					window.location.href='login';
				</script>";	
	}
	else 
	{
		echo "	<script>
					alert( 'Err-RE001 Unable to register.' );
					window.location.href='login';
				</script>";	
	}
}

if( isset( $_POST['uplod_post'] ) )
{
	$blog_title 		= 	$_POST['blog_title'];
	$blog_description	=	$_POST['blog_description'];

	$file_name 			=	$_FILES['blog_image']['name'];
	$temp_name 			= 	$_FILES['blog_image']['tmp_name'];
	$upload_folder 		=	"post_images/";

	$get_exetnsion 		=	explode( ".",$file_name );
	$cur_date_name 		=	date("Y_m_d_H_i_s");

	$new_file_name 		=	$cur_date_name.".".$get_exetnsion[1];
	$destination 		=	$upload_folder.$new_file_name;
	$created_by 		=   $_SESSION['user_details']['bur_user_register_id'];
	if( move_uploaded_file( $temp_name,$destination ) )
	{
		$insert_query 	=	"	INSERT INTO bp_post_list 
								(
									bpl_post_title,
									bpl_post_description,
									bpl_post_image_name,
									bpl_post_created_by
								)
								VALUES 
								(
									:post_title,
									:post_description,
									:post_image_name,
									:post_created_by
								)
							"; 
		$prepare 		=	$crud->prepare( $insert_query );
		$prepare->bindParam( "post_title",$blog_title 				);
		$prepare->bindParam( "post_description",$blog_description 	);
		$prepare->bindParam( "post_image_name",$new_file_name 		);
		$prepare->bindParam( "post_created_by",$created_by 			);

		if( $prepare->execute() )
		{
			echo "	<script>
						alert('Successfully Uploaded.' );
						window.location.href='index';
					</script>";			
		}
		else 
		{
			echo "	<script>
						alert('unable to process your record' );
						window.location.href='add_blog';
					</script>";		
		}
	}
	else 
	{
		echo "	<script>
					alert('unable to upload image file' );
					window.location.href='add_blog';
				</script>";
	}
}

if( isset( $_POST['operation'] ) )
{
	if( $_POST['operation'] == "put_like" )
	{
		$post_id = $_POST['post_id'];
		$user_id = $_SESSION['user_details']['bur_user_register_id'];
		$like_res = $crud->put_like( $post_id,$user_id ); 
		echo json_encode( $like_res );
	}
	else if( $_POST['operation'] == "put_unlike" )
	{
		$post_id = $_POST['post_id'];
		$user_id = $_SESSION['user_details']['bur_user_register_id'];
		$like_res = $crud->put_unlike( $post_id,$user_id ); 
		echo json_encode( $like_res );
	}
}
?>